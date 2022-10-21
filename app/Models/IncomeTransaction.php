<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeTransaction extends Model
{
    use HasFactory;

    protected $dates = [
        'operation_date',
    ];

    protected $guarded = [];

    public function inhouse()
    {
        return $this->belongsTo(Inhouse::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
