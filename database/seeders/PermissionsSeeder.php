<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissionsArray = [
            'roles' => ['read_roles','edit_roles','write_roles','delete_roles'],
            'permissions' => ['read_permissions',],
            'users' => [
                'read_users',
                'write_users',
                'edit_users',
                'delete_users',
                'impersonate_users',
            ],
        ];

        foreach($permissionsArray as $key => $permissions) {
            foreach ($permissions as $name) {
                Permission::firstOrCreate(['name'=>$name],[
                    'name' => $name,
                    'group' => $key,
                    'guard_name' => 'web',
                ]);
            }
        }
        $admin = Role::where('name','admin')->first();
        $admin->givePermissionTo(Permission::all());
    }
}
