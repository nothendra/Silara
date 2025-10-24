<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recommendations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aduan_id')->constrained()->onDelete('cascade');
            $table->foreignId('rt_id')->constrained('users')->onDelete('cascade'); // RT yang kirim
            $table->integer('recommended_status'); // Status yang direkomendasikan (1,2,3)
            $table->text('notes')->nullable(); // Catatan dari RT
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users'); // Admin yang approve
            $table->text('admin_notes')->nullable(); // Catatan dari Admin
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recommendations');
    }
};