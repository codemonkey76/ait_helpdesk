<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained();
            $table->string('company_name')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('current_team_id')->nullable()->constrained('teams');
            $table->foreignId('assigned_agent_id')->nullable()->constrained('users');
            $table->foreignId('owner_id')->nullable()->contrained('users');
            $table->string('subject');
            $table->longText('content');
            $table->foreignId('status_id');
            $table->softDeletes();
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
        Schema::dropIfExists('tickets');
    }
}
