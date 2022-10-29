<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
