<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // Add structured location fields
            $table->string('location_house_number')->nullable()->after('highlights');
            $table->string('location_street_name')->nullable()->after('location_house_number');
            $table->string('location_area')->nullable()->after('location_street_name');
            $table->string('location_lga')->nullable()->after('location_area');
            $table->string('location_state')->nullable()->after('location_lga');
            $table->string('location_zip_code')->nullable()->after('location_state');
            $table->string('location_country')->default('Nigeria')->after('location_zip_code');

            // Index for location filtering
            $table->index('location_state');
            $table->index('location_lga');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropIndex(['location_state']);
            $table->dropIndex(['location_lga']);
            $table->dropColumn([
                'location_house_number', 'location_street_name', 'location_area',
                'location_lga', 'location_state', 'location_zip_code', 'location_country',
            ]);
        });
    }
};
