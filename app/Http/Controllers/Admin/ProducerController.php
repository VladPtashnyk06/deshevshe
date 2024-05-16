<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProducerRequest;
use App\Models\Producer;

class ProducerController extends Controller
{
    public function index()
    {
        $producers = Producer::all();
        return view('admin.producers.index', compact('producers'));
    }

    public function create() {
        return view('admin.producers.create');
    }

    public function store(ProducerRequest $request)
    {
        Producer::create($request->validated());
        return redirect()->route('producer.index');
    }

    public function edit(Producer $producer)
    {
        return view('admin.producers.edit', compact('producer'));
    }

    public function update(ProducerRequest $request, Producer $producer)
    {
        $producer->update($request->validated());

        return redirect()->route('producer.index');
    }

    public function destroy(Producer $producer)
    {
        $producer->delete();

        return redirect()->route('producer.index');
    }
}
