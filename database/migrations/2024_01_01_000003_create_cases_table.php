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
        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->string('case_number')->unique()->comment('Unique case identifier');
            $table->string('title')->comment('Case title');
            $table->text('description')->comment('Detailed case description');
            $table->enum('status', ['open', 'in_progress', 'closed', 'archived'])->default('open')->comment('Case status');
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium')->comment('Case priority level');
            $table->enum('category', ['theft', 'assault', 'fraud', 'traffic', 'domestic', 'drug', 'cybercrime', 'other'])->default('other')->comment('Case category');
            $table->string('location')->nullable()->comment('Incident location');
            $table->datetime('incident_date')->nullable()->comment('When the incident occurred');
            $table->foreignId('assigned_officer_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->json('evidence_files')->nullable()->comment('JSON array of uploaded evidence files');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('case_number');
            $table->index('status');
            $table->index('priority');
            $table->index(['status', 'priority']);
            $table->index('assigned_officer_id');
            $table->index('created_by');
            $table->index('incident_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cases');
    }
};