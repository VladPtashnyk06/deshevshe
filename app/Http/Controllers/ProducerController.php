<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProducerRequest;
use App\Models\Producer;

class ProducerController extends Controller
{
    public function index()
    {
        return Producer::all();
    }

    public function store(ProducerRequest $request)
    {
        return Producer::create($request->validated());
    }

    public function show(Producer $producer)
    {
        return $producer;
    }

    public function update(ProducerRequest $request, Producer $producer)
    {
        $producer->update($request->validated());

        return $producer;
    }

    public function destroy(Producer $producer)
    {
        $producer->delete();

        return response()->json();
    }
}
