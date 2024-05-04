<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;

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
        Gate::define('group_access', function ($user,$group) {
            $userPermissions = $user->getAllPermissions()->pluck('name')->toArray();
            $check = match ($group) {
                'users_management' => ['read_users', 'read_roles', 'read_types', 'read_permissions'],
                default => [],
            };
            if(sizeof(array_intersect($check, $userPermissions))> 0) return true;
            return false;
        });

        Gate::define('role', function ($user,$permission) {
            return $user->hasPermissionTo($permission);
        });

        Validator::extend('permissions', function ($attribute, $value, $parameters, $validator) {
            $invalidPermissions = [];
            $valid = false;
            if (count($value) == 0) $valid = true;
            foreach ($value as $v) {
                $permission = Permission::where('name', $v)->orWhere('group', $v)->exists();
                if ($permission) {
                    $valid = true;
                } else {
                    $invalidPermissions[] = $v;
                }
            }
            if (!empty($invalidPermissions)) {
                $errorMessage = 'Invalid permissions: ' . implode(',', $invalidPermissions);
                $validator->errors()->add('permissions', $errorMessage);
            }
            return $valid;
        });

        Validator::extend('user_name_validators', function($attribute, $value, $parameters, $validator) {
            return preg_match('/^[a-zA-Z\s\'-.]+$/', $value);
        },'Name can only contain letters, spaces, hyphens, apostrophes, and periods.');

        Validator::extend('no_letters_user_name_validator', function($attribute, $value, $parameters, $validator) {
            return !preg_match('/^[\s\'-.]+$/', $value);
        },'Name cannot consist only of spaces, hyphens, apostrophes, and periods.');
    }
}
