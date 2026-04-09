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
Schema::create('sellers', function (Blueprint $table) {
            $table->id('seller_id');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->string('business_name');
            $table->text('business_address');
            $table->string('business_phone');
            $table->string('business_email')->unique();
            $table->string('tax_id')->unique();
            $table->text('bank_account_details')->nullable();
            $table->decimal('commission_rate', 5, 2)->default(0);
            $table->boolean('is_verified')->default(false);
            $table->json('verification_documents')->nullable();
            $table->decimal('rating', 3, 2)->default(0);
            $table->decimal('total_sales', 10, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};
