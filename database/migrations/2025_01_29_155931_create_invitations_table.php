<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvitationsTable extends Migration
{
   public function up()
{
    Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->string('email')->index();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->string('role');
            $table->timestamp('expires_at')->nullable();
            $table->string('token')->unique();
            $table->timestamps();
    });
}


    public function down()
    {
        Schema::dropIfExists('invitations');
    }
}

