<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('employee_code', 45)->nullable();
            $table->string('avatar')->nullable()->comment('avatar route for pictures');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->date('date_hired')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken(); 
            $table->timestamps(); 
            $table->string('cellphone_num', 45)->nullable();
            $table->string('position', 45)->nullable()->comment('Job title');
            $table->enum('department', ['Product and Technology', 'Sales', 'Marketing', 'HR/Admin', 'Finance'])->nullable()->comment("ENUM('Product and Technology', 'Sales', 'Marketing', 'HR/Admin', 'Finance')");
            $table->enum('status', ['Active', 'Inactive', 'Terminated', 'Deleted'])->nullable()->comment('Active = currently working \nInactive = Contract has ended or quitted on the job \nTerminated = Fired\nDeleted = soft-deleted');
            $table->string('address')->nullable()->comment('could separate into province, city/municipality, brgy, and etc for Philippines');
            $table->tinyInteger('is_admin')->nullable();
        });
        

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
