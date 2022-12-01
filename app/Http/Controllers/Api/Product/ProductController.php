<?php

namespace App\Http\Controllers\Api\Product;


use App\Models\Product;
use Illuminate\Http\Request;
use App\Traits\GetRequestType;
use App\Services\ProductService;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Http\Resources\Product\ProductResource;
use App\Http\Requests\Product\CreateProductRequest;

class ProductController extends Controller
{
    use GetRequestType;

    public function __construct()
    {
        $this->middleware('auth.jwt')->except(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $products = ProductService::retrieveProduct();
        return $this->getFullProduct($products)->additional([
            'message' => 'Product successfully retrieved',
            'status' => 'success'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return ProductResource
     */
    public function store(CreateProductRequest $request)
    {
        try {
            if(!$product = $request->createProduct()) {
                return response()->errorResponse('Failed to create product! Please try again later');
            }

            return (new ProductResource($product))->additional([
                'message' => 'Product successfully created',
                'status' => 'success'
            ]);
        } catch(QueryException $e) {
            report($e);
            return response()->errorResponse('Failed to create product! Please try again later');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $product
     * @return \App\Http\Resources\Product\ProductResource|\App\Http\Resources\Product\ProductResourceCollection
     */
    public function show(Product $product)
    {
        return $this->getSimpleProduct($product)->additional([
            'message' => 'Product successfully retrieved',
            'status' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $product
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function productlist(Product $product)
    {
        return $this->getMyProduct($product)->additional([
            'message' => 'Product successfully retrieved',
            'status' => 'success'
        ]);
    }

    /**
     * Display a listing of the Current User resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function popularproduct(Product $product) {
        $product = ProductService::retrievePopularProduct();
        return $this->getPopularProduct($product)->additional([
            'message' => 'My Product successfully retrieved',
            'status' => 'success'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return ProductResource
     */
    public function update(CreateProductRequest $request, Product $product)
    {
        $user = auth()->user();
        if($product->user_id !== $user->id) return response()->errorResponse('Permission Denied', [], 403);

        if(!$update_product = $product->update(
            $request->validated()
        )) {
            return response()->errorResponse('Product Update Failed');
        }

        return (new ProductResource($product))->additional([
            'message' => 'Product successfully updated',
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $user = auth()->user();
        if($product->user_id !== $user->id) return response()->errorResponse('Permission Denied', [], 403);

        if(!$product->delete()) {
            return response()->errorResponse('Failed to delete product');
        }

        return response()->success('Product deleted successfully');
    }
}
