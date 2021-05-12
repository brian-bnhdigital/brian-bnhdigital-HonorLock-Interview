<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
	private static $_table = 'vehicles';

	/**
	 * Run the migrations.
	 * 
	 * @return void
	 */
	public function up()
	{
		$this->down();

		Schema::create(self::$_table, function (Blueprint $table) {
			$table->bigIncrements('id')->autoIncrement()->unique()->unsigned();
			$table->string('make')->nullable();
			$table->integer('mileage')->nullable()->unsigned();
			$table->string('model')->nullable();
			$table->integer('price')->nullable()->unsigned();
			$table->integer('vehicle_id')->unique()->unsigned();
			$table->string('vin')->index()->unique();
			$table->index('id');
			$table->index('vehicle_id');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down()
	{
		Schema::dropIfExists(self::$_table);
	}
}
