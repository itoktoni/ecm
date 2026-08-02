<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CompanySettingsController extends Controller
{
    /** env key => [label, config key] — the fields exposed in the form. */
    private const FIELDS = [
        'COMPANY_NAME' => 'Nama Perusahaan',
        'COMPANY_ADDRESS' => 'Alamat',
        'COMPANY_AREA' => 'Kota / Area',
        'COMPANY_CITY' => 'Kota (tanda tangan)',
        'COMPANY_TELP' => 'Telepon',
        'COMPANY_FAX' => 'Fax',
        'COMPANY_EMAIL' => 'Email',
        'COMPANY_WEBSITE' => 'Website',
        'COMPANY_WHATSAPP' => 'WhatsApp',
        'COMPANY_LICENSE' => 'No. Izin Lab',
        'COMPANY_KAN' => 'No. KAN',
        'COMPANY_DIRECTOR' => 'Nama Direktur',
        'COMPANY_DIRECTOR_TITLE' => 'Jabatan Direktur',
        'COMPANY_ADMIN' => 'Nama Administrasi',
        'COMPANY_DOC_CODE' => 'Kode Dokumen Penawaran',
        'COMPANY_REVIEW_CODE' => 'Kode Kaji Ulang',
        'COMPANY_BANK1' => 'Rekening Bank 1',
        'COMPANY_BANK2' => 'Rekening Bank 2',
        'COMPANY_FOOTER_ADDRESS' => 'Alamat Footer',
        'COMPANY_FOOTER_TELP' => 'Telepon Footer',
        // Theme colors — saved to THEME_* env keys, mapped to config('theme.*')
        'THEME_PRIMARY' => 'Primary (Tombol/Aktif)',
        'THEME_PRIMARY_CONTAINER' => 'Primary Container',
        'THEME_SECONDARY' => 'Secondary',
        'THEME_ON_PRIMARY' => 'Teks di Primary',
        'THEME_ERROR' => 'Error / Danger',
        'THEME_PDF_PRIMARY' => 'Warna Dokumen PDF (Sertifikat dll)',
    ];

    /** env key → config('theme.*') key mapping for theme colors. */
    private const THEME_KEYS = [
        'THEME_PRIMARY' => 'primary',
        'THEME_PRIMARY_CONTAINER' => 'primary_container',
        'THEME_SECONDARY' => 'secondary',
        'THEME_ON_PRIMARY' => 'on_primary',
        'THEME_ERROR' => 'error',
        'THEME_PDF_PRIMARY' => 'pdf_primary',
    ];

    public function index(): View
    {
        $values = [];
        foreach (array_keys(self::FIELDS) as $key) {
            $values[$key] = config('company.'.strtolower(str_replace('COMPANY_', '', $key)));
        }

        return view('pages.settings.company', [
            'fields' => self::FIELDS,
            'values' => $values,
            'logo' => config('company.logo'),
            'themeValues' => array_combine(
                array_keys(self::THEME_KEYS),
                array_map(fn ($k) => config('theme.'.$k), self::THEME_KEYS)
            ),
        ]);
    }

    public function save(Request $request): RedirectResponse
    {
        $rules = ['logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048']];
        foreach (array_keys(self::FIELDS) as $key) {
            // THEME_* fields: hex color validation
            if (str_starts_with($key, 'THEME_')) {
                $rules[$key] = ['nullable', 'string', 'regex:/^#[0-9a-fA-F]{6}$/'];
            } else {
                $rules[$key] = ['nullable', 'string', 'max:255'];
            }
        }
        $data = $request->validate($rules);

        $envPath = base_path('.env');
        if (! File::exists($envPath) || ! File::isWritable($envPath)) {
            flash()->error(__('File .env tidak dapat ditulis.'));

            return Redirect::route('settings.company');
        }

        $updates = [];
        foreach (array_keys(self::FIELDS) as $key) {
            // Skip empty theme colors — preserve existing/default via config
            if (str_starts_with($key, 'THEME_') && empty($data[$key])) {
                continue;
            }
            $updates[$key] = $data[$key] ?? '';
        }

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $name = 'company-logo.'.$file->getClientOriginalExtension();
            $file->move(public_path('storage'), $name);
            $updates['COMPANY_LOGO'] = 'storage/'.$name;
        }

        $this->writeEnv($envPath, $updates);

        flash()->success(__('Pengaturan perusahaan & tema tersimpan.'));

        return Redirect::route('settings.company');
    }

    /** Upsert KEY="value" lines into the .env file, preserving everything else. */
    private function writeEnv(string $path, array $updates): void
    {
        $content = File::get($path);

        foreach ($updates as $key => $value) {
            $line = $key.'="'.str_replace('"', '\"', $value).'"';
            $pattern = '/^'.preg_quote($key, '/').'=.*$/m';

            if (preg_match($pattern, $content)) {
                $content = preg_replace($pattern, $line, $content);
            } else {
                $content = rtrim($content, "\r\n")."\n".$line."\n";
            }
        }

        File::put($path, $content);
    }
}
