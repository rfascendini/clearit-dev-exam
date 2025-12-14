<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            
            // ID's and Foreign Keys
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Ticket Attributes
            $table->string('name');                         
            $table->unsignedInteger('type'); // It could be 1 or 2 or 3 (I used unsignedInteger for flexibility for future types)   
            $table->enum('transport_mode', ['air', 'land', 'sea']);
            $table->string('product');
            $table->string('country_origin');
            $table->string('country_destination');
            $table->enum('status', ['new', 'in_progress', 'completed'])->default('new');

            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
