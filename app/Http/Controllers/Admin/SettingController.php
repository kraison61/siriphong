<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSettingRequest;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings.index', [
            'settings' => Setting::formValues(),
        ]);
    }

    public function update(UpdateSettingRequest $request): RedirectResponse
    {
        Setting::setMany($request->validated());
        Setting::applyToConfig();

        return redirect()
            ->route('admin.settings.edit')
            ->with('success', 'บันทึกการตั้งค่าเรียบร้อยแล้ว');
    }
}
