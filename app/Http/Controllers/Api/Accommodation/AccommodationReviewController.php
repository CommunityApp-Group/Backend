<?php

namespace App\Http\Controllers\Api\Accommodation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accommodation\AccommodationReviewRequest;
use App\Http\Resources\Accommodation\AccommodationReviewResource;
use App\Models\Accommodation;
use App\Models\Accommodationreview;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AccommodationReviewController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Accommodation $accommodation
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Accommodation $accommodation)
    {
        return AccommodationReviewResource::collection($accommodation->reviews);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AccommodationReviewRequest $request
     * @param Accommodation $accommodation
     * @return \Illuminate\Http\Response
     */
    public function store(AccommodationReviewRequest $request, Accommodation $accommodation)
    {
        $review = new Accommodationreview($request->all());
        $review->user_id = $user = auth()->user()->id;
        $accommodation->reviews()->save($review);
        return response([
            'data' => new AccommodationReviewResource($review)
        ],Response::HTTP_CREATED);
    }


    /**
     * Display the specified resource.
     *
     * @param Accommodationreview $accommodationreview
     * @return void
     */
    public function show(Accommodationreview $accommodationreview)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Accommodation $accommodation
     * @param Accommodationreview $accommodationreview
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Accommodation $accommodation,  Accommodationreview $accommodationreview)
    {
        $accommodationreview->update($request->all());
        return response([
            'data' => new AccommodationReviewResource($accommodationreview)
        ],Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Accommodation $accommodation
     * @param Accommodationreview $accommodationreview
     * @return \Illuminate\Http\Response
     */
    public function destroy(Accommodation $accommodation,Accommodationreview $accommodationreview)
    {
        $accommodationreview->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
