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
        if (!Schema::hasTable('competencies')) {
            Schema::create('competencies', function (Blueprint $table) {
                $table->id('competence_id');
                $table->string('description', 255);
                $table->enum('type', ['soft', 'technical']);
                $table->enum('status', ['active', 'deleted']);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competencies');
    }
};
