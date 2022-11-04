<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Permission extends \Spatie\Permission\Models\Permission
{
    public static function defaultPermissions()
    {
        return [

            'role' => [
                'view roles',
                'add role',
                'edit role',
                'delete role',
            ],

            'inhouse' => [
                'view inhouses',
                'add inhouse',
                'edit inhouse',
                'delete inhouse',
            ],

            'food and beverage' => [
                'view food and beverages',
                'add food and beverage',
                'edit food and beverage',
                'delete food and beverage',
            ],

            'service staff' => [
                'view service staffs',
                'add service staff',
                'edit service staff',
                'delete service staff',
            ],

            'room' => [
                'view rooms',
                'add room',
                'edit room',
                'delete room',
            ],

            'customer' => [
                'view customers',
                'add customer',
                'edit customer',
                'delete customer',
            ],

            'item' => [
                'view items',
                'add item',
                'edit item',
                'delete item',
            ],

            'supplier' => [
                'view suppliers',
                'add supplier',
                'edit supplier',
                'delete supplier',
            ],

            'purchase' => [
                'view purchases',
                'add purchase',
                'edit purchase',
                'delete purchase',
            ],

            'stockout' => [
                'view stockouts',
                'add stockout',
                'edit stockout',
                'delete stockout',
            ],

            'report' => [
                'view reports',
                // 'add report',
                // 'edit report',
                // 'delete report',
            ],

            'expense' => [
                'view expenses',
                'add expense',
                'edit expense',
                'delete expense',
            ],

            'user' => [
                'view any users',
                'view user',
                'add user',
                'edit user',
                'delete user',
            ],

            // 'transaction' => [
            //     'view transactions',
            //     'add transaction',
            //     'edit transaction',
            //     'delete transaction',
            // ],


        ];
    }
    public function permissionName(): Attribute
    {
        return Attribute::make(
            get: function () {
                return ucwords($this->name);
            }
        );
    }
}
