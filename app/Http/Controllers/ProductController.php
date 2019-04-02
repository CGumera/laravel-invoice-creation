<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Get details of a specific product.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function getProductDetails($id)
    {
        $product = Product::find($id);
        return $product;
    }
}
