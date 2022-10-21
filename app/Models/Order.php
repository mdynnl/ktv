<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function invoiceNo(): Attribute
    {
        return Attribute::make(
            set: function () {
                $todayOrders = Order::whereDate('created_at', today())->orderBy('created_at')->get();
                if ($todayOrders->count() > 0) {
                    $lastInvoice = $todayOrders->last()->invoice_no;
                    $lastD = (int) substr($lastInvoice, -4, 4);
                    $padded = sprintf("%04d", $lastD + 1);
                    return today()->format('ymd') . $padded;
                } else {
                    return today()->format('ymd') . '0001';
                }
            }
        );
    }
}
