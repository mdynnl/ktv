<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    public function inhouses()
    {
        return $this->hasMany(Inhouse::class);
    }

    public function type()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }

    public function table()
    {
        return $this->hasOne(Table::class, 'id', 'id');
    }
}
