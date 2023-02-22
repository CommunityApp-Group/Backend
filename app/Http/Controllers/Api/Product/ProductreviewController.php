<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Resources\Product\ProductResourceCollection;
use App\Http\Resources\Product\ReviewResourceCollection;
use App\Models\Product;
use App\Models\Productreview;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Product\ReviewResource;
use App\Http\Requests\Product\ProductReviewRequest;
//use function Doctrine\Common\Cache\Psr6\get;

class ProductreviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
//        $product = Product::with('admin:id,name')
//            ->withCount('productreview')
//            ->latest()
//            ->paginate(20);

//        return ReviewResource::collection(Productreview::orderBy('id', 'DESC')->paginate(10));
        return ReviewResource::collection(Product::with('productreview')->paginate(25));


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Product\ProductReviewRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductReviewRequest $request, Product $product)
    {
        $productreview = new Productreview($request->all());
        $productreview->user_id = $user = auth()->user()->id;
        $product->productreview()->save($productreview);
        return response([
            'Review' => new ReviewResource($productreview)
        ],Response::HTTP_CREATED);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Productreview  $productreview
     * @return \Illuminate\Http\Response
     */
    public function show(Productreview $productreview)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Product $product
     * @param \App\Models\Productreview $productreview
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product,  Productreview $productreview)
    {
        $productreview->update($request->all());
        return response([
            'Review' => new ReviewResource($productreview)
        ],Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Productreview  $productreview
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product,Productreview $productreview)
    {
        $productreview->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
