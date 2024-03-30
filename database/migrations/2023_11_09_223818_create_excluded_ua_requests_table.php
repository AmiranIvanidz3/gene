<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExcludedUaRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('excluded_ua_requests', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->unsignedBigInteger('user_agent_id')->nullable();
            $table->integer('count')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_agent_id')->references('id')->on('excluded_ua')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('excluded_ua_requests');
    }
}
