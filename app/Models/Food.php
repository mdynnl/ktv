<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    public function foodType()
    {
        return $this->belongsTo(FoodType::class);
    }

    public function getImage(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (isset($this->food_image)) {
                    return asset('storage/' . $this->food_image);
                } else {
                    return asset('images/serving.png');
                }
            }
        );
    }
}
