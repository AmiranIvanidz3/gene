<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSeenNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_seen_news', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('news_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('ip')->nullable();
            $table->string('cookie')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('news_id')->references('id')->on('modal_news')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_seen_news');
    }
}
