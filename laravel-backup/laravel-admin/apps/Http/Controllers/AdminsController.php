<?php

namespace App\Http\Controllers;

use App\Admin;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Ultraware\Roles\Models\Role;

class AdminsController extends Controller
{
    public function getAdmin(){
        $getAdmin = Admin::all();
        return \response()->json(['data' => $getAdmin], 200);
    }

    public function getRoles(){
        $getRoles = Role::all();
        return \response()->json(['data' => $getRoles], 200);
    }


    protected function createAdmin(Request $request)
    {

		// Check if role exist
		if(Admin::where('name', $request['name'])->exists()){
			return response()->json(['message' => "User Already Existed", 'status' => false], 201);
		}
		else{
			$admin =  Admin::create([
				'name' => $request['name'],
				'email' => $request['email'],
				'password' => Hash::make($request['password']),
			]);

			$role = Role::where('name', '=', $request->role)->first();
			$admin->attachRole($role);

			// return $admin;
			return response()->json(['message' => "User Created Successfully", 'data' => $admin, 'status' => true], 200);
		}
		
    }

    // protected function createSuperAdmin(Request $request)
    // {

    //     $superadmin =  Admin::create([
    //         'name' => $request['name'],
    //         'email' => $request['email'],
    //         'password' => Hash::make($request['password']),
    //     ]);

    //     $role = Role::where('name', '=', 'Superadmin')->first();
    //     $superadmin->attachRole($role);

    //     return $superadmin;
    // }

    protected function createRole(Request $request) 
    {
		
		// Check if role exist
		if(Role::where('slug', $request->name)->exists()){
			return response()->json(['message' => "Role Already Existed", 'status' => false], 201);
		}
		else{
			$adminRole = Role::create([
				'name' => $request->name,
				'slug' => $request->name,
				'description' => $request->description, // optional
				'level' => $request->level, // optional, set to 1 by default
			]);

			return response()->json(['message' => "Role Created Successfully", 'data' => $adminRole, 'status' => true], 200);
		}
    }


    protected function EditRole(Request $request, $id) 
    {
        $EditAdminRole = Role::find($id);
        $EditAdminRole->name = $request->name;
        $EditAdminRole->slug = $request->name;
        $EditAdminRole->description = $request->description;
        $EditAdminRole->level = $request->level;
        $EditAdminRole->save();
        if($EditAdminRole->save()){
            return response()->json(['message' => "Role updated successfully", 'data' => $EditAdminRole], 200);
        }else{
            return response()->json(['message' => "Error updating role", 'data' => $EditAdminRole], 201);
        }
    }




    public function RemoveAdmin($id) {
        $getAdmin = Admin::where('id', $id)->first();
        $getAdmin->detachAllRoles();
        $getAdmin->delete();
        return response()->json(['message' => "Deleted successfully"], 200);
    }

    public function editAdmin(Request $request, $id){
        $getAdmin = Admin::where('id', $id)->first();
        if ($getAdmin->email == "") {
            $getAdmin->update([
                'email' => $request->email
            ]);
        }
        if ($request->password && $request->password != "") {
            $getAdmin->update([
                'name' => $request->name,
                'password' => $request->password
            ]);
        }
        else{
            $getAdmin->update([
                'name' => $request->name
            ]);
        }

        // dd($request->role);
        if ($request->role && $request->role != "") {
            $role = Role::where('name', '=', $request->role)->first();
            // dd(Admin::find($id)->attachRole($role));
            Admin::find($id)->detachAllRoles();
            Admin::find($id)->attachRole($role);
        }

        return \response()->json(['message' => "Updated Successfully", 'data' => $getAdmin], 200);

    }
}
