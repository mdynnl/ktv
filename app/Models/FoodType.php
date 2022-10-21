<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodType extends Model
{
    use HasFactory;

    public function foodCategory()
    {
        return $this->belongsTo(FoodCategory::class);
    }

    public function foods()
    {
        return $this->hasMany(Food::class);
    }

    public function printerType()
    {
        return $this->belongsTo(PrinterType::class);
    }
}
