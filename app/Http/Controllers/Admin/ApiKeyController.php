<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ApiKeyController extends Controller
{
    public function index()
    {
        $novaPoshtaApiKey = config('services.novaposhta.api_key');
        $ukrPoshtaApiKey = config('services.ukrposhta.api_key');

        return view('admin.api-key.index', compact('novaPoshtaApiKey', 'ukrPoshtaApiKey'));
    }
    public function edit()
    {
        return view('admin.api-key.set-api-key');
    }

    public function update(Request $request)
    {
        $request->validate([
            'delivery' => 'required|string',
            'apiKey' => 'required|string',
        ]);

        if ($request->input('delivery') == 'NovaPoshta') {
            $this->updateEnvFile('NOVAPOSHTA_API_KEY', $request->input('apiKey'));
        } else {
            $this->updateEnvFile('UKRPOSHTA_API_KEY', $request->input('apiKey'));
        }

        return redirect()->route('api.index');
    }

    protected function updateEnvFile($key, $value)
    {
        $path = base_path('.env');

        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                $key . '=' . env($key),
                $key . '=' . $value,
                file_get_contents($path)
            ));
        }

        Artisan::call('config:cache');
    }
}

