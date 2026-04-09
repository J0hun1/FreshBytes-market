<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    /** @use HasFactory<\Database\Factories\SellerFactory> */
    use HasFactory;

    protected $primaryKey = 'seller_id';

    protected $fillable = [
        'user_id',
        'business_name',
        'business_address',
        'business_phone',
        'business_email',
        'tax_id',
        'bank_account_details',
        'commission_rate',
        'is_verified',
        'verification_documents',
        'rating',
        'total_sales',
        'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id');
    }
}
