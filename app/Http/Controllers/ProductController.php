<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function store(Request $request, $categoryId)
    {
        $data = $request->validate([
            'product_name' => 'string',
            'product_price' => 'numeric',
            'product_quantity' => 'integer',
        ]);
    
        // Create a new product and associate it with the given category
        $product = new Product($data);
        $product->category_id = $categoryId;
        $product->save();
    
        return response()->json($product, 201);
    }
    
public function update(Request $request, $categoryId, $productId)
{
    $product = Product::findOrFail($productId);

    $data = $request->validate([
        'product_name' => 'string',
        'product_price' => 'numeric',
        'product_quantity' => 'integer',
    ]);

    $product->update($data);
    $product->category_id = $categoryId;
    $product->save();

    return response()->json($product, 200);
}

public function destroy($categoryId, $productId)
{
    $product = Product::findOrFail($productId);
    $product->delete();

    return response()->json(null, 204);
}

}