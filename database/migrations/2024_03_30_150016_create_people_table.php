<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mother_id')->nullable();
            $table->unsignedBigInteger('father_id')->nullable();
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->unsignedBigInteger('gender_id')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('personal_number')->unique()->nullable();
            $table->text('about')->nullable();
            $table->text('comment')->nullable();
            $table->boolean('died')->default(false)->nullable();
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
        Schema::dropIfExists('people');
    }
}
