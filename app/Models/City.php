<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    public $incrementing = false;

    protected $fillable = ['id', 'name', 'state'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
