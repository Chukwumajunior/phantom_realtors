<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->decimal('price', 15, 2);
            $table->string('currency', 3)->default('NGN');
            $table->string('type');
            $table->string('category');
            $table->string('status')->default('available');
            $table->string('listing_status')->default('active');

            // Location
            $table->string('address');
            $table->string('country')->default('Nigeria');
            $table->string('city');
            $table->string('state');
            $table->string('lga')->nullable();

            // Property details
            $table->unsignedSmallInteger('bedrooms')->nullable();
            $table->unsignedSmallInteger('bathrooms')->nullable();
            $table->unsignedSmallInteger('toilets')->nullable();
            $table->unsignedInteger('area_sqft')->nullable();
            $table->year('year_built')->nullable();
            $table->json('features')->nullable();

            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('views_count')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('type');
            $table->index('category');
            $table->index('status');
            $table->index('country');
            $table->index('city');
            $table->index('state');
            $table->index('is_featured');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
