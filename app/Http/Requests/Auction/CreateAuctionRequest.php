<?php

namespace App\Http\Requests\Auction;

use App\Models\Auction;
use App\Rules\ValidateValidAmount;
use Illuminate\Foundation\Http\FormRequest;

class CreateAuctionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $data =  [
            "auction_name"   => ['required', 'string', 'max:155'],
            "auction_price" => ['required', 'numeric', new ValidateValidAmount],
            "step" => ['required', 'numeric', new ValidateValidAmount],
            "category_name" => ['required', 'exists:categories,name'],
            "location"      => ['required'],
            "description"   => ['nullable'],
            "auction_image"  => ['required'],
            "auction_image.*"  => ['required'],
            "dt_end"  => ['required','date','date_format:Y-m-d'],
            "negotiable"    => ['nullable', 'boolean', 'in:true,false'],
        ];

        if(request()->routeIs('auction.update')) {
            $data['status'] = 'nullable|in:rejected,verified';
        }

        if($this->filled('auction_image'))
        foreach($this->input('auction_image') as $index => $photo) {
            if(photoType($photo)) {
                $data['auction_image'.$index] = photoType($photo) == "file" ? 'image|mimes:jpeg,jpg,png,gif,webp' : 'base64image|base64mimes:jpeg,jpg,png,gif,webp';
            }
             //dd($photo);
        }

        return $data;
    }

    public function createAuction() {
        $user = auth()->user();
        $data = $this->validated() + ['status' => 'pending'];

        return $user->auction()->create($data);
    }

    protected function getPhotoType() {
        if ($this->filled('auction_image')) {
            return photoType($this->input('auction_image'));
        } elseif($this->file('auction_image')) {
            return photoType($this->file('auction_image'));
        }
    }

    public function messages()
    {
        return [
            'auction_image.*.required' => 'auction image is required'
        ];
    }
}
