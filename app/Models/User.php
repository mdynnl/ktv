<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getImage(): Attribute
    {
        return Attribute::make(
            get: fn () => "https://ui-avatars.com/api/?name={$this->name}&background=30579A&color=fff"
            // get: function () {
            //     if (isset($this->image)) {
            //         return asset('storage/'. $this->image);
            //     } else {
            //         $name = '';
            //         $name .= isset($this->first_name) ? $this->first_name : '';
            //         $name .= isset($this->last_name) ? '+'. $this->last_name : '';
            //         return  "https://ui-avatars.com/api/?name=$name&background=30579A&color=fff";
            //     }
            // }
        );
    }

    public function roleName()
    {
        return $this->roles->count() > 0 ? $this->roles->first()->name : '';
    }
}
