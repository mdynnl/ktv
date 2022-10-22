<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $primaryKey= 'Id';
    public $incrementing = false;

    public function orders()
    {
        return $this->hasMany(Order::class, 'table_id', 'id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'id', 'id');
    }
}
