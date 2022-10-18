<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('section_name');
            $table->bigInteger('class_id');
            $table->bigInteger('session_id');

            $table->bigInteger('building_id')->nullable();
            $table->bigInteger('room_id')->nullable();

            $table->unique(['section_name','class_id','session_id']);
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('sections');
    }
};
