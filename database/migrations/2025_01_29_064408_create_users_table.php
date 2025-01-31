<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
   public function up()
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->string('password');
        $table->enum('role', ['super_admin', 'admin', 'member']);
        $table->unsignedBigInteger('client_id')->nullable();
        $table->boolean('signup_status')->default(false);
        $table->string('email_token')->nullable();
        $table->timestamp('email_token_expiry')->nullable();
        $table->timestamps();
    });
}


    public function down()
    {
        Schema::dropIfExists('users');
    }
}

