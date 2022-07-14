<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_active'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }

}
