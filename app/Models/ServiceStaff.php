<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceStaff extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'dob' => 'datetime',
    ];

    public function inhouseServices()
    {
        return $this->hasMany(InhouseService::class);
    }

    public function getImage(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (isset($this->profile_image)) {
                    return asset('storage/'. $this->profile_image);
                } else {
                    return asset('images/employee.png');
                }
            }
        );
    }

    public function getFullSizeImage(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (isset($this->full_size_image)) {
                    return asset('storage/'. $this->full_size_image);
                }
            }
        );
    }
}
