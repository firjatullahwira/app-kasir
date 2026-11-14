<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->when($request->query('search'), function ($query, $search) {
                $query->where('nama', 'like', "%{$search}%");
            })
            ->paginate(10);

        return ProductResource::collection($products);
    }

    public function show(string $id)
    {
        $product = Product::with('category')->findOrFail($id);

        return new ProductResource($product);
    }
}
