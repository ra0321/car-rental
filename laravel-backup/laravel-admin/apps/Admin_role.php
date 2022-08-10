<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin_role extends Model
{
    //
    protected $with = ['role_name'];
    protected $table = 'admin_role';

    public function role_name(){
        return $this->hasOne('App\Role', 'id', 'role_id');
    }
}
