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
        Schema::create('personnel', function (Blueprint $table) {
            $table->id();
            $table->string('badge_number')->unique()->comment('Officer badge number');
            $table->string('first_name')->comment('Officer first name');
            $table->string('last_name')->comment('Officer last name');
            $table->string('email')->unique()->comment('Officer email address');
            $table->string('phone')->nullable()->comment('Contact phone number');
            $table->enum('rank', ['officer', 'sergeant', 'lieutenant', 'captain', 'major', 'chief'])->default('officer')->comment('Officer rank');
            $table->string('department')->comment('Department assignment');
            $table->enum('status', ['active', 'inactive', 'suspended', 'retired'])->default('active')->comment('Employment status');
            $table->date('hire_date')->comment('Date of hire');
            $table->text('address')->nullable()->comment('Officer address');
            $table->date('birth_date')->nullable()->comment('Date of birth');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->comment('Gender');
            $table->string('emergency_contact_name')->nullable()->comment('Emergency contact name');
            $table->string('emergency_contact_phone')->nullable()->comment('Emergency contact phone');
            $table->json('documents')->nullable()->comment('JSON array of uploaded personnel documents');
            $table->text('notes')->nullable()->comment('Additional notes');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('badge_number');
            $table->index('email');
            $table->index(['first_name', 'last_name']);
            $table->index('department');
            $table->index('status');
            $table->index(['status', 'rank']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personnel');
    }
};