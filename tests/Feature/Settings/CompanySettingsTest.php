<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->envPath = base_path('.env');
    $this->envBackup = File::exists($this->envPath) ? File::get($this->envPath) : null;
});

afterEach(function () {
    if ($this->envBackup !== null) {
        File::put($this->envPath, $this->envBackup);
    }
    $logo = public_path('storage/company-logo.png');
    if (File::exists($logo)) {
        File::delete($logo);
    }
});

function settingsUser(): User
{
    return User::create(['name' => 'Admin', 'email' => 'set-'.uniqid().'@t.com', 'password' => bcrypt('x'), 'role' => 'developer']);
}

it('shows the company settings form', function () {
    $this->actingAs(settingsUser());

    $r = $this->get('/settings/company');

    $r->assertStatus(200);
    $html = $r->getContent();
    expect($html)->toContain('Identitas Perusahaan');
    expect($html)->toContain('Nama Perusahaan');
    expect($html)->toContain('Warna Tema');
    expect($html)->toContain('value="#00288e"');
    expect($html)->toContain('value="#00236f"');
});

it('writes company fields into the .env file', function () {
    $this->actingAs(settingsUser());

    $this->post('/settings/company', [
        'COMPANY_NAME' => 'PT Contoh Kalibrasi',
        'COMPANY_EMAIL' => 'info@contoh.test',
        'THEME_PRIMARY' => '#123456',
        'THEME_PDF_PRIMARY' => '#0a0a0a',
    ])->assertRedirect(route('settings.company'));

    $env = File::get($this->envPath);
    expect($env)->toContain('COMPANY_NAME="PT Contoh Kalibrasi"');
    expect($env)->toContain('THEME_PRIMARY="#123456"');
    expect($env)->toContain('THEME_PDF_PRIMARY="#0a0a0a"');
});

it('rejects an invalid color hex', function () {
    $this->actingAs(settingsUser());

    $this->post('/settings/company', [
        'COMPANY_NAME' => 'PT X',
        'THEME_PRIMARY' => 'red',
    ])->assertSessionHasErrors('THEME_PRIMARY');
});
