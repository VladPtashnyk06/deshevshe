<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProducerRequest;
use App\Models\Producer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProducerController extends Controller
{
    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index()
    {
        $producers = Producer::paginate(25);
        return view('admin.producers.index', compact('producers'));
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function create() {
        return view('admin.producers.create');
    }

    /**
     * @param ProducerRequest $request
     * @return RedirectResponse
     */
    public function store(ProducerRequest $request)
    {
        Producer::create($request->validated());
        return redirect()->route('producer.index');
    }

    /**
     * @param Producer $producer
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit(Producer $producer)
    {
        return view('admin.producers.edit', compact('producer'));
    }

    /**
     * @param ProducerRequest $request
     * @param Producer $producer
     * @return RedirectResponse
     */
    public function update(ProducerRequest $request, Producer $producer)
    {
        $producer->update($request->validated());

        return redirect()->route('producer.index');
    }

    /**
     * @param Producer $producer
     * @return RedirectResponse
     */
    public function destroy(Producer $producer)
    {
        $producer->delete();

        return redirect()->route('producer.index');
    }
}
