<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSettingsRequest;
use App\Services\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function __construct(protected SettingsService $service)
    {
    }

    public function index(): View
    {
        $settings = $this->service->getUserSettings(request()->session());

        return view('settings.index', compact('settings'));
    }

    public function update(UpdateSettingsRequest $request): RedirectResponse
    {
        $this->service->saveUserSettings(request()->session(), $request->validated());

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
