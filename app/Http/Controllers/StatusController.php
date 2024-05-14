<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatusRequest;
use App\Models\Status;

class StatusController extends Controller
{
    public function index()
    {
        return Status::all();
    }

    public function store(StatusRequest $request)
    {
        return Status::create($request->validated());
    }

    public function show(Status $status)
    {
        return $status;
    }

    public function update(StatusRequest $request, Status $status)
    {
        $status->update($request->validated());

        return $status;
    }

    public function destroy(Status $status)
    {
        $status->delete();

        return response()->json();
    }
}
