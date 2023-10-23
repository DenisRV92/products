<?php

namespace App\Http\Controllers;

use App\Events\ProductCreated;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\ProductServices;

class ProductController extends Controller
{
    /**
     * @var ProductServices $service
     */
    private $service;

    /**
     * UserController constructor.
     * @param ProductServices $service
     */
    public function __construct(ProductServices $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::available()->get();
        return view('product.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product.form', ['product' => new Product()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $product = $this->service->store($request->all());

        if ($product) {
            event(new ProductCreated($product));
            if($product->status != Product::AVAILABLE) {
                return response()->json([
                    'product' => $product,
                ]);
            }
        }

        return response()->json(['error' => 'Failed to save product'], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('product.show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('product.form', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->fill($request->all());
        if ($product->save()) {
            return response()->json([
                'product' => $product,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $result = $this->service->delete($product);

    }
}
