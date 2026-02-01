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
        Schema::table('tickets', function (Blueprint $table) {
            $table->string('coupon_code')->nullable()->after('payment_proof');
            $table->decimal('discount_amount', 10, 2)->default(0)->after('coupon_code');
            $table->decimal('subtotal', 10, 2)->nullable()->after('discount_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn(['coupon_code', 'discount_amount', 'subtotal']);
        });
    }
};
