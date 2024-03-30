<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogVisitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_visitors', function (Blueprint $table) {
            $table->id();
            $table->string('ip');
            $table->timestamp('created_at')->useCurrent();
            $table->string('session_id')->nullable();
            $table->integer('page')->nullable(); 
            $table->text('query_string')->nullable();
            $table->text('referrer')->nullable();

            $table->unique(['created_at', 'session_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_visitors');
    }
}
