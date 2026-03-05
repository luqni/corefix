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
        Schema::table('ticket_items', function (Blueprint $table) {
            $table->decimal('capital_price', 12, 2)->default(0)->after('price');
            $table->boolean('is_spare_part')->default(false)->after('capital_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ticket_items', function (Blueprint $table) {
            $table->dropColumn(['capital_price', 'is_spare_part']);
        });
    }
};
