<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'is_active',
        'group_id'
    ];

    public function Group()
    {
        return $this->belongsTo(Group::class);
    }

}
