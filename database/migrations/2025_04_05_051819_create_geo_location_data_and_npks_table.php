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
        Schema::create('geo_location_data_and_npks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brgy_id')
                ->constrained('barangays', 'id')
                ->onDelete('cascade');
            $table->decimal('x_coordinate', 11, 8)->notNull();
            $table->decimal('y_coordinate', 11, 8)->notNull();
            $table->decimal('n', 8, 2)->notNull();
            $table->decimal('p', 8, 2)->notNull();
            $table->decimal('k', 8, 2)->notNull();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('geo_location_data_and_npks');
    }
};
