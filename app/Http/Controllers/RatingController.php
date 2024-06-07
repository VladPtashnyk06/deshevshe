<?php

namespace App\Http\Controllers;

use App\Http\Requests\RatingRequest;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index()
    {
        return Rating::all();
    }

    public function store(RatingRequest $request)
    {
        return Rating::create($request->validated());
    }

    public function show(Rating $rating)
    {
        return $rating;
    }

    public function update(RatingRequest $request, Rating $rating)
    {
        $rating->update($request->validated());

        return $rating;
    }

    public function destroy(Rating $rating)
    {
        $rating->delete();

        return response()->json();
    }
}
