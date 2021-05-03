<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponseUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('response_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_response_id');
            $table->foreignId('user_id');
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['ticket_response_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('response_user');
    }
}
