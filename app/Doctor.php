<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


class Doctor extends Model
{
    use HasApiTokens;

    protected $hidden = [
        'password',
        'remember_token',
        'email',
        'phone_number',
        'email_verified_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

}
