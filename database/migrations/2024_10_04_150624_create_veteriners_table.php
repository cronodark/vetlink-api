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
            $table->string('clinic_image');
            $table->enum('register_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->float('latitude');
            $table->float('longitude');
            $table->string('address');
            $table->string('document');
            $table->foreignId('id_user')->constrained('users');
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
