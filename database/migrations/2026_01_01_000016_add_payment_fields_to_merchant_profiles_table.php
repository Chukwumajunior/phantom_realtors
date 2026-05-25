<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('merchant_profiles', function (Blueprint $table) {
            $table->foreignId('subscription_plan_id')->nullable()->after('rejection_reason')->constrained()->nullOnDelete();
            $table->string('payment_proof')->nullable()->after('subscription_plan_id');
            $table->string('payment_reference')->nullable()->after('payment_proof');
            $table->decimal('amount_paid', 12, 2)->nullable()->after('payment_reference');
        });
    }

    public function down(): void
    {
        Schema::table('merchant_profiles', function (Blueprint $table) {
            $table->dropForeign(['subscription_plan_id']);
            $table->dropColumn(['subscription_plan_id', 'payment_proof', 'payment_reference', 'amount_paid']);
        });
    }
};
