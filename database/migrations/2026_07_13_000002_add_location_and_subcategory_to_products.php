<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Add sub-category field
            $table->string('sub_category')->nullable()->after('category');

            // Add structured location fields
            $table->string('location_house_number')->nullable()->after('specifications');
            $table->string('location_street_name')->nullable()->after('location_house_number');
            $table->string('location_area')->nullable()->after('location_street_name');
            $table->string('location_lga')->nullable()->after('location_area');
            $table->string('location_state')->nullable()->after('location_lga');
            $table->string('location_zip_code')->nullable()->after('location_state');
            $table->string('location_country')->default('Nigeria')->after('location_zip_code');

            // Index for location filtering
            $table->index('location_state');
            $table->index('location_lga');
            $table->index('sub_category');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['location_state']);
            $table->dropIndex(['location_lga']);
            $table->dropIndex(['sub_category']);
            $table->dropColumn([
                'sub_category',
                'location_house_number', 'location_street_name', 'location_area',
                'location_lga', 'location_state', 'location_zip_code', 'location_country',
            ]);
        });
    }
};
