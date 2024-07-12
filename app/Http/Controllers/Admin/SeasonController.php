<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Season;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SeasonController extends Controller
{
    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index()
    {
        $seasons = Season::paginate(25);
        return view('admin.seasons.index', compact('seasons'));
    }

    /**
     * @param Season $season
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit(Season $season)
    {
        return view('admin.seasons.edit', compact('season'));
    }

    /**
     * @param Request $request
     * @param Season $season
     * @return RedirectResponse
     */
    public function update(Request $request, Season $season)
    {
        $season->update(['title' => $request->post('title')]);

        return redirect()->route('season.index');
    }

    /**
     * @param Season $season
     * @return RedirectResponse
     */
    public function destroy(Season $season)
    {
        $season->delete();

        return redirect()->route('season.index');
    }
}
