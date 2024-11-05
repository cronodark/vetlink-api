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
        Schema::create('veteriners', function (Blueprint $table) {
            $table->id();
            $table->string('clinic_name');
            $table->string('clinic_image')->nullable();
            $table->enum('register_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->float('latitude');
            $table->float('longitude');
            $table->string('city');
            $table->string('address');
            $table->string('document')->nullable();
            $table->foreignId('id_user')->constrained('users');
            $table->time('open_time')->nullable(); // Store opening time
            $table->time('close_time')->nullable(); // Store closing time
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('veteriners');
    }
};
