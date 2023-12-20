<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Place;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('category_place', function (Blueprint $table) {
            $table->foreignIdFor(Place::class)->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('category_place', function (Blueprint $table) {
            $table->dropForeignIdFor(Place::class);
            $table->dropColumn('id_places');
        });
    }
};
