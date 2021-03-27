<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    public function up()
    {
        Schema::create('lfm_media', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('path', 150)->index();
            $table->bigInteger('size');
            $table->string('extension', 50);
            $table->string('mimetype', 50);
            $table->string('type', 50)->default('image')->index();
            $table->unsignedBigInteger('folder_id')->nullable()->index();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('user_model', 100)->nullable()->index();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('lfm_media');
    }
}
