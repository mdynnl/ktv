<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewInformationInvoice extends Model
{
    use HasFactory;

    protected $primaryKey= 'inhouse_id';
    public $incrementing = false;

    public function inhouse()
    {
        return $this->belongsTo(Inhouse::class);
    }
}
