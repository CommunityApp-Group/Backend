<?php

namespace App\Http\Controllers\Api\Product;

use App\Models\Product;
use App\Models\Productreview;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Product\ReviewResource;
use App\Http\Requests\Product\ProductReviewRequest;

class ProductreviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Product $product)
    {
        return ReviewResource::collection($product->reviews);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Product\ProductReviewRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductReviewRequest $request, Product $product)
    {
        $review = new Productreview($request->all());
        $product->reviews()->save($review);
        return response([
            'data' => new ReviewResource($review)
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
            'data' => new ReviewResource($productreview)
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
