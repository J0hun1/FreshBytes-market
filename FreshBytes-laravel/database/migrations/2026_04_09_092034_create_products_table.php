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
Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('product_name');
            $table->text('product_brief_description');
            $table->longText('product_detailed_description')->nullable();
            $table->decimal('product_price', 10, 2);
            $table->decimal('product_discountedPrice', 10, 2)->nullable();
            $table->string('product_sku')->unique();
            $table->string('product_unit')->default('kg');
            $table->enum('product_status', ['fresh', 'withered'])->default('fresh');
            $table->string('product_location');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories', 'category_id')->onDelete('cascade');
            $table->integer('quantity');
            $table->date('post_date');
            $table->date('harvest_date');
            $table->boolean('is_active')->default(true);
            $table->foreignId('seller_id')->constrained('sellers', 'seller_id')->onDelete('cascade');
            $table->decimal('discounted_amount', 10, 2)->default(0);
            $table->boolean('is_discounted')->default(false);
            $table->boolean('is_sale')->default(false);
            $table->boolean('is_srp')->default(false);
            $table->boolean('is_deleted')->default(false);
            $table->string('brand')->nullable();
            $table->boolean('top_rated')->default(false);
            $table->integer('sell_count')->default(0);
            $table->date('offer_start_date')->nullable();
            $table->date('offer_end_date')->nullable();
            $table->decimal('promo_price', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
