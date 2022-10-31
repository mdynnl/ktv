<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Role extends \Spatie\Permission\Models\Role
{
    public static function defaultRoles()
    {
        return [
            'Owner',
            'Manager',
            'Cashier',
            'Accountant',
        ];
    }
}
