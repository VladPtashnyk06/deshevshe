<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StatusRequest;
use App\Models\Status;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class StatusController extends Controller
{
    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index()
    {
        $statuses = Status::paginate(25);
        return view('admin.statuses.index', compact('statuses'));
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function create() {
        return view('admin.statuses.create');
    }

    /**
     * @param StatusRequest $request
     * @return RedirectResponse
     */
    public function store(StatusRequest $request)
    {
        Status::create($request->validated());
        return redirect()->route('status.index');
    }

    /**
     * @param Status $status
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit(Status $status)
    {
        return view('admin.statuses.edit', compact('status'));
    }

    /**
     * @param StatusRequest $request
     * @param Status $status
     * @return RedirectResponse
     */
    public function update(StatusRequest $request, Status $status)
    {
        $status->update($request->validated());

        return redirect()->route('status.index');
    }

    /**
     * @param Status $status
     * @return RedirectResponse
     */
    public function destroy(Status $status)
    {
        $status->delete();

        return redirect()->route('status.index');
    }
}
