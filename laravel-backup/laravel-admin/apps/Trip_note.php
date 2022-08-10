<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip_note extends Model
{
    //
    public function addedBy() {
        return $this->belongsTo('\App\Admin', 'admin_id', 'id');
    }
}
