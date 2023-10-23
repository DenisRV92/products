<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;

interface Service
{
    public function store(Request $request);

    public function update(Product $product, Request $request);

    public function delete(Product $product);

}
