<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\ProductsDataTable;

class ProductsController extends Controller
{
    public function index(ProductsDataTable $dataTable){
        return $dataTable->render('products.index');
    }
}
