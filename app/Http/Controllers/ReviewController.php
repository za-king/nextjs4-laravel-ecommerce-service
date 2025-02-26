<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewAddRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function addReview(ReviewAddRequest $request)
    {

        $data = $request->validated();

        $review = new Review($data);

        $review->save();

        return new ReviewResource($review);

    }
}
