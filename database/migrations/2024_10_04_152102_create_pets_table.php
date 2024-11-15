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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string('pet_name');
            $table->string('photo')->nullable();
            $table->integer('age');
            $table->float('weight');
            $table->enum('gender', ['Male', 'Female']);
            $table->string('notes')->nullable();
            $table->foreignId('type')->constrained('pet_types');
            $table->foreignId('breed')->constrained('pet_breeds');
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
