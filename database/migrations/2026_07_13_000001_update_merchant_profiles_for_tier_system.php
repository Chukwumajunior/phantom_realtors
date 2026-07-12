<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('merchant_profiles', function (Blueprint $table) {
            // Add tier system fields
            $table->string('tier')->default('tier_1')->after('status');
            $table->string('company_name')->nullable()->after('tier');
            $table->string('cac_document')->nullable()->after('company_name');
            $table->string('nin')->nullable()->after('cac_document');

            // Add structured location fields
            $table->string('house_number')->nullable()->after('business_address');
            $table->string('street_name')->nullable()->after('house_number');
            $table->string('area')->nullable()->after('street_name');
            $table->string('lga')->nullable()->after('area');
            $table->string('state')->nullable()->after('lga');
            $table->string('zip_code')->nullable()->after('state');
            $table->string('country')->default('Nigeria')->after('zip_code');

            // Drop approval/payment columns
            $table->dropForeign(['approved_by']);
            $table->dropColumn(['approved_at', 'approved_by', 'rejection_reason']);
        });

        // Drop payment fields (added by migration 000016)
        if (Schema::hasColumn('merchant_profiles', 'subscription_plan_id')) {
            Schema::table('merchant_profiles', function (Blueprint $table) {
                $table->dropForeign(['subscription_plan_id']);
                $table->dropColumn(['subscription_plan_id', 'payment_proof', 'payment_reference', 'amount_paid']);
            });
        }

        // Migrate existing approved merchants to tier_3
        \DB::table('merchant_profiles')
            ->where('status', 'approved')
            ->update(['tier' => 'tier_3', 'country' => 'Nigeria']);

        // Auto-approve all pending profiles
        \DB::table('merchant_profiles')
            ->where('status', 'pending')
            ->update(['status' => 'approved', 'tier' => 'tier_1', 'country' => 'Nigeria']);
    }

    public function down(): void
    {
        Schema::table('merchant_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'tier', 'company_name', 'cac_document', 'nin',
                'house_number', 'street_name', 'area', 'lga', 'state', 'zip_code', 'country',
            ]);

            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('rejection_reason')->nullable();
        });
    }
};
