<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExcludedIpRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('excluded_ip_requests', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->unsignedBigInteger('ip_id')->nullable();
            $table->integer('count')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('ip_id')->references('id')->on('excluded_ips')->onDelete('restrict');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('excluded_ip_requests');
    }
}
