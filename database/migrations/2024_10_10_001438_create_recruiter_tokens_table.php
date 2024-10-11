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
        if (!Schema::hasTable('recruiter_tokens')) {
            Schema::create('recruiter_tokens', function (Blueprint $table) {
                $table->id('token_id'); // Primary key
                $table->string('token', 255); // Token field
                $table->string('email', 100); // Email field
                $table->tinyInteger('is_used')->default(0); // To check if the token is used or not
                $table->timestamp('created_at')->useCurrent(); // Creation timestamp
                $table->timestamp('used_at')->nullable(); // When the token was used
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruiter_tokens');
    }
};
