<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StatusRequest;
use App\Models\Status;

class StatusController extends Controller
{
    public function index()
    {
        $statuses = Status::all();
        return view('admin.statuses.index', compact('statuses'));
    }

    public function create() {
        return view('admin.statuses.create');
    }

    public function store(StatusRequest $request)
    {
        Status::create($request->validated());
        return redirect()->route('status.index');
    }

    public function edit(Status $status)
    {
        return view('admin.statuses.edit', compact('status'));
    }

    public function update(StatusRequest $request, Status $status)
    {
        $status->update($request->validated());

        return redirect()->route('status.index');
    }

    public function destroy(Status $status)
    {
        $status->delete();

        return redirect()->route('status.index');
    }
}
