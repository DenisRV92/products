<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;

/**
 * Class PhoneServices
 * @package App\Services
 */
class ProductServices implements Service
{
    /**
     * @param array $request
     * @return bool
     */
    public function store($request)
    {
        $product = new Product($request);
        return $product->save() ? $product : null;
    }

    /**
     * @param Product $phone
     * @param array $request
     * @return mixed
     */
    public function update($product, $request)
    {
        $product->fill($request);
        return $product->save();
    }

    /**
     * @param Product $product
     * @return bool
     * @throws \Exception
     */
    public function delete($product)
    {
        return $product->delete();
    }

}
