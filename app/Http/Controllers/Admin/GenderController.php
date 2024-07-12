<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gender;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GenderController extends Controller
{
    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index()
    {
        $genders = Gender::paginate(25);
        return view('admin.genders.index', compact('genders'));
    }

    /**
     * @param Gender $gender
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit(Gender $gender)
    {
        return view('admin.genders.edit', compact('gender'));
    }

    /**
     * @param Request $request
     * @param Gender $gender
     * @return RedirectResponse
     */
    public function update(Request $request, Gender $gender)
    {
        $gender->update(['title' => $request->post('title')]);

        return redirect()->route('gender.index');
    }

    /**
     * @param Gender $gender
     * @return RedirectResponse
     */
    public function destroy(Gender $gender)
    {
        $gender->delete();

        return redirect()->route('gender.index');
    }
}
