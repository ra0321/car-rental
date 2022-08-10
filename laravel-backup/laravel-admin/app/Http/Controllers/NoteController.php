<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trip_note;
use App\User_note;
use Auth;
class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserNotes($request_id)
    {
        $getNotes = User_note::where('user_id', $request_id)->with('addedBy')->orderby('created_at', 'DESC')->get();
		return response()->json(['data' =>$getNotes, 'message' => 'Note fetched successfully', 'status' => true]);
		
    }
	public function getTripNotes($request_id)
    {
        $getNotes = Trip_note::where('trip_id', $request_id)->with('addedBy')->orderby('created_at', 'DESC')->get();
		return response()->json(['data' =>$getNotes, 'message' => 'Note fetched successfully', 'status' => true]);
		
	}
	

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeUserNote(Request $request)
    {
        $this->validate($request, [
			'user_id' => 'required',
			'note' => 'required'
		]);
		$user_note = new User_note();
		$user_note->admin_id = $request->user()->id;
		$user_note->user_id = $request->user_id;
		$user_note->comment = $request->note;
		
		$user_note->save();
		if($user_note->save()){
			return response()->json(['data' =>$user_note, 'message' => 'Note added successfully', 'status' => true]);
		}
		else{
			return response()->json(['data' =>'', 'message' => 'Failed to add note', 'status' => false]);
		}
    }
	
	public function storeTripNote(Request $request)
    {
        $this->validate($request, [
			'trip_id' => 'required',
			'note' => 'required'
		]);
		
		$trip_note = new Trip_note();
		$trip_note->trip_id = $request->trip_id;
		$trip_note->admin_id = $request->user()->id;
		$trip_note->comment = $request->note;
		
		$trip_note->save();
		if($trip_note->save()){
			return response()->json(['data' =>$trip_note, 'message' => 'Note added successfully', 'status' => true]);
		}
		else{
			return response()->json(['data' =>'', 'message' => 'Failed to add note', 'status' => false]);
		}
    }

	public function editUserNote(Request $request, $request_id)
    {
        $this->validate($request, [
			'user_id' => 'required',
			'note' => 'required'
		]);
		$user_note = User_note::find($request_id);
		$user_note->user_id = $request->user_id;
		$user_note->note = $request->note;
		
		$user_note->save();
		if($user_note->save()){
			return response()->json(['data' =>$user_note, 'message' => 'Note update successfully', 'status' => true]);
		}
		else{
			return response()->json(['data' =>'', 'message' => 'Failed to update note', 'status' => false]);
		}
    }
	
	public function editTripNote(Request $request, $request_id)
    {
        $this->validate($request, [
			'trip_id' => 'required',
			'note' => 'required'
		]);
		
		$trip_note = Trip_note::find($request_id);
		$trip_note->user_id = $request->user_id;
		$trip_note->note = $request->note;
		
		$trip_note->save();
		if($trip_note->save()){
			return response()->json(['data' =>$trip_note, 'message' => 'Note updted successfully', 'status' => true]);
		}
		else{
			return response()->json(['data' =>'', 'message' => 'Failed to update note', 'status' => false]);
		}
    }
    public function deleteUserNote(Request $request, $request_id)
    {
		$user_note = User_note::find($request_id)->delete();
		if($user_note){
			return response()->json(['message' => 'Note deleted successfully', 'status' => true]);
		}
		else{
			return response()->json(['message' => 'Failed to delete note', 'status' => false]);
		}
    }
	
	public function deleteTripNote(Request $request, $request_id)
    {
		$trip_note = Trip_note::find($request_id)->delete();
		if($trip_note){
			return response()->json(['message' => 'Note deleted successfully', 'status' => true]);
		}
		else{
			return response()->json(['message' => 'Failed to delete note', 'status' => false]);
		}
    }
}
