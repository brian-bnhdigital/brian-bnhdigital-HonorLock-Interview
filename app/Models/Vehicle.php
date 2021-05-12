<?php

namespace App\Models;


/**
 * A class to represent vehicles that have been found on carvana
 */
class Vehicle extends CustomModel
{
	protected $fillable = array(
		'make',
		'mileage',
		'model',
		'price',
		'vehicle_id',
		'vin'
	);
	protected $table = 'vehicles';

}