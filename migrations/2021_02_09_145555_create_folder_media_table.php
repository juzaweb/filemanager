<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFolderMediaTable extends Migration
{
    public function up()
    {
        Schema::create('folder_media', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->bigInteger('user_id')->index();
            $table->string('type', 50)->index();
            $table->bigInteger('parent_id')->index()->nullable();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('folder_media');
    }
}
