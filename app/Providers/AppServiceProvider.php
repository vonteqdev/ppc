<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('user_name_validators', function($attribute, $value, $parameters, $validator) {
            return preg_match('/^[a-zA-Z\s\'-.]+$/', $value);
        },'Name can only contain letters, spaces, hyphens, apostrophes, and periods.');

        Validator::extend('no_letters_user_name_validator', function($attribute, $value, $parameters, $validator) {
            return !preg_match('/^[\s\'-.]+$/', $value);
        },'Name cannot consist only of spaces, hyphens, apostrophes, and periods.');
    }
}
