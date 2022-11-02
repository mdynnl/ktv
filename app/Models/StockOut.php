<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function stockOutType()
    {
        return $this->belongsTo(StockOutType::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
