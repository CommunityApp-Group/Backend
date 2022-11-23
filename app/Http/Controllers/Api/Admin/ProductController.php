<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.jwt:admin');
    }

    public function update(Request $request, Product $product) {
        $request->validate([
            'status' => 'required|in:verified,rejected'
        ]);

        $product->status = $request->status;
        $product->verified_by = auth()->user()->id;

        $product->save();

        if(!$product->wasChanged()) {
            return response()->errorResponse('Could not update product', [
                "errorSource" => "Product is {$product->status}"
            ]);
        }

        return (new ProductResource($product))->additional([
            'status' => 'success',
            'message' => 'Product updated successfully'
        ]);
    }

    public function destroy(Product $product) {
        if(!$product->delete()) {
            return response()->errorResponse('Failed to delete product');
        }

        return response()->success('Product deleted successfully');
    }
}
