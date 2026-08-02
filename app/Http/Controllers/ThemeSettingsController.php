<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ThemeSettingsController extends Controller
{
    /** env key => [label, config key]. */
    private const FIELDS = [
        'THEME_PRIMARY' => ['Primary', 'primary'],
        'THEME_PRIMARY_CONTAINER' => ['Primary Container', 'primary_container'],
        'THEME_SECONDARY' => ['Secondary', 'secondary'],
        'THEME_ON_PRIMARY' => ['Teks di atas Primary', 'on_primary'],
        'THEME_ERROR' => ['Error / Danger', 'error'],
        'THEME_PDF_PRIMARY' => ['Warna Dokumen PDF (Sertifikat dll)', 'pdf_primary'],
    ];

    public function index(): View
    {
        $values = [];
        foreach (self::FIELDS as $key => [$label, $cfg]) {
            $values[$key] = config('theme.'.$cfg);
        }

        return view('pages.settings.theme', [
            'fields' => self::FIELDS,
            'values' => $values,
        ]);
    }

    public function save(Request $request): RedirectResponse
    {
        $rules = [];
        foreach (array_keys(self::FIELDS) as $key) {
            $rules[$key] = ['required', 'string', 'regex:/^#[0-9a-fA-F]{6}$/'];
        }
        $data = $request->validate($rules);

        $envPath = base_path('.env');
        if (! File::exists($envPath) || ! File::isWritable($envPath)) {
            flash()->error(__('File .env tidak dapat ditulis.'));

            return Redirect::route('settings.theme');
        }

        $content = File::get($envPath);
        foreach (array_keys(self::FIELDS) as $key) {
            $line = $key.'="'.$data[$key].'"';
            $pattern = '/^'.preg_quote($key, '/').'=.*$/m';
            $content = preg_match($pattern, $content)
                ? preg_replace($pattern, $line, $content)
                : rtrim($content, "\r\n")."\n".$line."\n";
        }
        File::put($envPath, $content);

        flash()->success(__('Tema tersimpan.'));

        return Redirect::route('settings.theme');
    }
}
