<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = ['value', 'product_id', 'campaign_id'];

    public function product()
    {
        $this->belongsTo(Product::class);
    }

    public function campaign()
    {
        $this->belongsTo(Campaign::class);
    }
}
