<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('inventory.products');
    }

    public function store()
    {

    }

    public function add() {
        return view('inventory.add-product');
    }
}
