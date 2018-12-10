<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('driving_license');
            $table->string('vehicle_no');
            $table->string('owner_name');
            $table->string('owner_phone');
            $table->string('owner_address');
            $table->string('owner_email');
            $table->integer('vehicle_id');
            $table->integer('status'); // 0 safe , 1 guilty , 2 dangerous
            $table->integer('point');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drivers');
    }
}
