<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_note extends Model
{
    //

    public function addedBy() {
        return $this->belongsTo('\App\Admin', 'admin_id', 'id');
    }

    public function user(){
        return $this->belongsTo('\App\User', 'user_id', 'id');
    }
}
