<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Models\Parking;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ReviewController extends Controller
{
    public function index(Parking $parking)
    {
        $reviews = Review::where('parking_id', $parking->id)->get();

        if ($reviews->isEmpty()) {
            return wrap_response(200, 'There are no reviews for the above parking lot yet', []);
        }

        $reviewsArray = [];
        foreach ($reviews as $review) {
            $createdAt = $review->created_at ? $review->created_at->diffForHumans() : null;

            $reviewsArray[] = [
                'id' => $review->id,
                'review' => $review->review,
                'rating' => $review->rating,
                'created_at' => $createdAt,
            ];
        }
        return wrap_response(200, 'OK', $reviewsArray);
    }


    public function store(ReviewRequest $request, Parking $parking)
    {
        try {
            $userUuid = $request->user_uuid;
            if (is_null($userUuid)) {

                return wrap_response(400, 'userUuid cannot be null', []);
            }
            $user = User::firstOrCreate(
                ['uuid' => $userUuid],
                [
                    'name' => Str::random(10),
                    'email' => Str::random(10) . '@' . Str::random(10) . '.tld',
                    'password' => Hash::make(Str::random(10)),
                    'remember_token' => Str::random(60),
                    'role_id' => 2,
                ]
            );

            $userId = $user->id;

            $validated = $request->validated();

            $review = new Review();
            $review->parking_id = $parking->id;
            $review->user_id = $userId;
            $review->review = $validated['feedback'];
            $review->rating = $validated['rating'];
            $review->save();

            $result = [
                'id' => $review->id,
                'review' => $review->review,
                'rating' => $review->rating,
                'created_at' => $review->created_at->diffForHumans(),
            ];

            return wrap_response(200, 'OK', $result);
        } catch (\Exception $e) {

            return wrap_response(500, $e->getMessage(), []);
        }
    }
}
