<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EsarCars extends Model
{
    protected $table = 'esar_cars';
    public $timestamps = false;
    protected $fillable = [
		'model_make_id','manufacturer_arabic','model_class', 'id', 'model_name', 'model_trim', 'model_year','model_transmission_type','model_body'
	];
}
