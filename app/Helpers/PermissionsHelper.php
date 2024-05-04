<?php

use Spatie\Permission\Models\Permission;

if (! function_exists('formatRequestPermissions')) {
    function formatRequestPermissions($perms){
        $permissions = [];
        if ($perms) {
            foreach ($perms as $perm) {
                if (!str_contains($perm, '_')) {
                    $groupPermissions = Permission::where('group', $perm)->pluck('name')->toArray();
                    $permissions = array_merge($permissions, $groupPermissions);
                } else {
                    if (!in_array($perm, $permissions)) {
                        array_push($permissions, $perm);
                    }
                }
            }
        }
        return $permissions;
    }
}