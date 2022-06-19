<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Routing\Route;

trait Multitenant
{

    public static function bootMultitenant()
    {
        
        if (auth()->check()) {

            $url = url()->current();

            if (strpos($url, '/admin')) {

                if (auth()->user()->role_id == 3) {


                    static::creating(function ($model) {
                        $model->created_by_user_id = auth()->id();
                    });

                    static::addGlobalScope('created_by_user_id', function (Builder $builder) {

                        if (auth()->check()) {
                            return $builder->where('created_by_user_id', auth()->id());
                        }

                    });

                }
            }
        }
    }


}