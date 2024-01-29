<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sync_uuid')->unique();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('_lft')->nullable();
            $table->unsignedBigInteger('_rgt')->nullable();
            $table->unsignedBigInteger('depth')->nullable();
            $table->unsignedInteger('order_column')->nullable();
            $table->boolean('is_active')->default(false);
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
        });

        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sync_uuid')->unique();
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('is_active')->default(false);
        });

        Schema::create('property_groups', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('slug')->unique()->nullable();
            $table->unsignedInteger('order_column')->nullable();
            $table->boolean('is_active')->default(false);
        });

        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('property_group')->nullable();
            $table->string('slug')->unique();
            $table->string('sync_uuid')->unique();
            $table->foreignId('property_group_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedInteger('order_column')->nullable();
            $table->boolean('is_main')->default(false);
            $table->boolean('is_in_filter')->default(false);
            $table->boolean('is_active')->default(false);
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('sync_uuid');
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('art')->nullable();
            $table->unsignedDecimal('price', 10, 2)->nullable();
            $table->integer('balance')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->jsonb('delivery_properties')->nullable();
            $table->boolean('is_active')->default(false);
            $table->unsignedInteger('order_column')->nullable();
        });

        Schema::create('product_additions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title')->nullable();
            $table->string('images_title')->nullable();
            $table->text('description')->nullable();
            $table->text('other_description')->nullable();
            $table->boolean('is_active')->default(false);
            $table->unsignedInteger('order_column')->nullable();
        });

        Schema::create('property_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->string('value')->nullable();
            $table->decimal('numeric_value')->nullable();
            $table->boolean('is_sync')->default(0);
            $table->index(['product_id', 'property_id']);
        });

        Schema::create('category_product', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->cascadeOnDelete();
            $table->boolean('is_sync')->default(0);
            $table->primary(['category_id', 'product_id']);
        });

        Schema::create('similar_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('related_product_id')->constrained('products')->cascadeOnDelete();
            $table->index(['product_id', 'related_product_id']);
        });

        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('sync_uuid')->nullable();
            $table->string('name');
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->text('opening_hours')->nullable();
            $table->string('lat')->nullable();
            $table->string('lon')->nullable();
            $table->unsignedInteger('order_column')->nullable();
            $table->boolean('is_active')->default(false);
        });

        Schema::create('popular_categories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->unsignedInteger('order_column')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('property_values');
        Schema::dropIfExists('category_product');
        Schema::dropIfExists('similar_products');
        Schema::dropIfExists('popular_categories');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_additions');
        Schema::dropIfExists('brands');
        Schema::dropIfExists('properties');
        Schema::dropIfExists('property_groups');
        Schema::dropIfExists('warehouses');
    }
};
