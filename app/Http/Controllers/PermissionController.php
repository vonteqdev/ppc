<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\DataTables\PermissionsDataTable;

class PermissionController extends Controller
{
    public function index(PermissionsDataTable $dataTable){
        return $dataTable->render('permissions.index');
    }

    public function show(Permission $permission){
        return view('permissions.show', compact('permission'));
    }
}
