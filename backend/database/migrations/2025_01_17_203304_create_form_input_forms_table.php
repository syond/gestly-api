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
        Schema::create('form_input_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_input_id')->constrained()->onDelete('cascade');
            $table->foreignId('form_id')->constrained()->onDelete('cascade');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_input_forms', function (Blueprint $table) {
            $table->dropForeign(['form_input_id']);
            $table->dropForeign(['form_id']);
        });
        Schema::dropIfExists('form_input_forms');
    }
};
