<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Resources\Product\ProductResourceCollection;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Traits\GetRequestType;
use App\Services\ProductService;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Http\Resources\Product\ProductResource;
use App\Http\Requests\Product\CreateProductRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use PHPOpenSourceSaver\JWTAuth\Contracts\Providers\Auth;

class ProductController extends Controller
{
    use GetRequestType;

    public function __construct()
    {
        $this->middleware('auth.jwt')->except(['index', 'show', 'search']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return ProductResourceCollection::Collection(Product::orderBy('created_at', 'DESC')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function store(CreateProductRequest $request)
    {
        $product = new Product;
        $product->product_name = $request->product_name;
        $product->description = $request->description;
        $product->category_name = $request->category_name;
        $product->product_price = $request->product_price;
        $product->product_image = $request->product_image;
        $product->user_id = $user = auth()->user()->id;
        $product->save();
        return response([
            'data' => new ProductResource($product)
        ],Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     *
     * @param  Product $id
     * @return ProductResource
     */
    public function show(Product $product)
    {
        return $this->getSingleProduct($product)->additional([
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
    public function myproduct(Product $product)
   {
       $product = ProductService::retrieveMyProduct();
       return $this->getMyProduct($product)->additional([
           'message' => 'My Product successfully retrieved',
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
     * @param  int  $product
     * @return ProductResource
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_name' => 'required',
            'description' => 'required',
            'category_name' => 'required',
            'product_price' => 'required',
        ]);
        $user = auth()->guard('admin')->user();
        if($product->user_id !== $user->id) return response()->errorResponse('Permission Denied', [], 403);

        $product->update($request->all());

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

    /**
     * Search for a name
     *
     * @param $product_name
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function search($product_name)
    {
        $products = Product::where('product_name', 'like', '%'.$product_name.'%')->get();
        return ProductResource::collection($products);
    }

}


