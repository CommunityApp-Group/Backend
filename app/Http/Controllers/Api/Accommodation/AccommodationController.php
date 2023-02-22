<?php

namespace App\Http\Controllers\Api\Accommodation;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Accommodation;
use App\Traits\GetRequestType;
use App\Http\Controllers\Controller;
use App\Services\AccommodationService;
use App\Http\Resources\Accommodation\AccommodationResource;
use App\Http\Requests\Accommodation\CreateAccommodationRequest;
use App\Http\Resources\Accommodation\AccommodationsResourceCollection;


class AccommodationController extends Controller
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
        return AccommodationsResourceCollection::Collection(Accommodation::orderBy('created_at', 'DESC')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function store(CreateAccommodationRequest $request)
    {

        $accommodation = new Accommodation;
        $accommodation->title = $request->title;
        $accommodation->description = $request->description;
        $accommodation->category_name = $request->category_name;
        $accommodation->accommodation_price = $request->accommodation_price;
        $accommodation->accommodation_image = $request->accommodation_image;
        $accommodation->type = $request->type;
        $accommodation->bedroom = $request->bedroom;
        $accommodation->bathroom = $request->bathroom;
        $accommodation->state = $request->state;
        $accommodation->city = $request->city;
        $accommodation->address = $request->address;
        $accommodation->nearby = $request->nearby;
        $accommodation->lga = $request->lga;
        $accommodation->user_id = $user = auth()->guard('admin')->user()->id;
        $accommodation->save();
        return response([
            'data' => new AccommodationResource($accommodation)
        ],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Accommodation $accommodation
     * @return AccommodationResource|AccommodationsResourceCollection
     */
    public function show(Accommodation $accommodation)
    {
        return $this->getSingleAccommodation($accommodation)->additional([
            'message' => 'Accommodation successfully retrieved',
            'status' => 'success'
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $accommodation
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function myaccommodation(Accommodation $accommodation)
    {
        $accommodation = AccommodationService::retrieveMyAccommodation();
        return $this->getMyAccommodation($accommodation)->additional([
            'message' => 'My Accommodation successfully retrieved',
            'status' => 'success'
        ]);
    }

    /**
     * Display a listing of the Current User resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function popularaccommodation(Accommodation $accommodation)
    {
        $accommodation = AccommodationService::retrievePopularAccommodation();
        return $this->getPopularAccommodation($accommodation)->additional([
            'message' => 'My Accommodation successfully retrieved',
            'status' => 'success'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Accommodation $accommodation
     * @return AccommodationResource
     */
    public function update(Request $request, Accommodation $accommodation )
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category_name' => 'required',
            'accommodation_price' => 'required',
        ]);
        $user = auth()->guard('admin')->user();
        if($accommodation->user_id !== $user->id) return response()->errorResponse('Permission Denied', [], 403);

        $accommodation->update($request->all());

        return (new AccommodationResource($accommodation))->additional([
            'message' => 'Accommodation successfully updated',
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Accommodation $accommodation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Accommodation $accommodation)
    {
        $user = auth()->guard('admin')->user();
        if($accommodation->user_id !== $user->id) return response()->errorResponse('Permission Denied', [], 403);
        if(!$accommodation->delete()) {
            return response()->errorResponse('Failed to delete product');
        }

        return response()->success('Accommodation deleted successfully');
    }

    /**
     * Search for a name
     *
     * @param $title
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function search($title)
    {
        $accommodation = Accommodation::where('title', 'like', '%'.$title.'%')->get();
        return AccommodationResource::collection($accommodation);
    }
}
