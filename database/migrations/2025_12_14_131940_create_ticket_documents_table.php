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
        Schema::create('ticket_documents', function (Blueprint $table) {
            
            // ID's and Foreign Keys
            $table->id();
            $table->foreignId('ticket_id')->constrained()->cascadeOnDelete();
            $table->foreignId('uploaded_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('document_request_id')->nullable()->constrained()->nullOnDelete();

            // Ticket Document Attributes
            $table->string('name'); // user defined name for the document
            $table->string('path'); // storage/app/public/... or /app/private (it depends the access level we want to give)
            $table->string('mime')->nullable();
            $table->unsignedBigInteger('size')->nullable();

            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_documents');
    }
};
