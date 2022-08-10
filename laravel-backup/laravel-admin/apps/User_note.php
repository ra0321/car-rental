<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_note extends Model
{
    //

    public function addedBy() {
        return $this->belongsTo('\App\Admin', 'admin_id', 'id');
    }
}
