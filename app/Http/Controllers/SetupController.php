<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\WebsitesDataTable;

class SetupController extends Controller
{
    public function index(WebsitesDataTable $dataTable)
    {
        return $dataTable->render('setup.index');
    }
}
