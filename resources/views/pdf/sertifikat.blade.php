<?php /** @var App\Models\SoDetail $detail */ ?>
@php $l = $detail->so_detail_lembar ?? []; $laik = ($l['penilaian'] ?? '') !== 'Tidak baik digunakan'; $pdfColor = config('theme.primary'); $onPrimary = config('theme.on_primary'); @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Sertifikat {{ $detail->so_detail_sertifikat_no }}</title>
    <style>
        * { font-family: DejaVu Sans, sans-serif; box-sizing: border-box; }
        @page { size: A4 portrait; margin: 12mm 12mm; }
        body { margin: 0; padding: 0; color: #1a1c1e; font-size: 10px; }

        .frame { border: 2px solid {{ $pdfColor }}; }
        .topbar { background: {{ $pdfColor }}; height: 6px; }
        .bottombar { background: {{ $pdfColor }}; height: 6px; }
        .inner { padding: 20px 24px; }

        .head { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
        .head td { vertical-align: middle; }
        .logo { text-align: center; width: 74px; }
        .logo img { max-width: 70px; max-height: 60px; }
        .logo .tx { color: {{ $pdfColor }}; font-size: 28px; font-weight: bold; line-height: 1.1; }
        .lab { padding-left: 12px; }
        .lab .nm { font-size: 13px; font-weight: bold; color: #131b2e; }
        .lab .ds { font-size: 7.5px; color: #54647a; line-height: 1.5; }
        .head .r { text-align: right; }
        .head .r .t1 { font-size: 24px; font-weight: bold; color: {{ $pdfColor }}; text-transform: uppercase; letter-spacing: 1px; }
        .head .r .t2 { font-size: 10px; font-style: italic; color: #54647a; }

        .certno { background: {{ $pdfColor }}; color: {{ $onPrimary }}; text-align: center; padding: 8px; margin: 0 0 14px 0; }
        .certno .k { font-size: 7px; text-transform: uppercase; letter-spacing: 1px; opacity: 0.85; }
        .certno .v { font-size: 14px; font-weight: bold; letter-spacing: 2px; }

        table.info { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
        table.info td { padding: 6px 9px; border: 0.6px solid #d8dce6; }
        table.info td.lbl { background: {{ $pdfColor }}; color: {{ $onPrimary }}; font-weight: bold; width: 17%; }
        table.info .id { font-size: 7.5px; text-transform: uppercase; letter-spacing: 0.4px; }
        table.info .en { font-size: 6px; font-style: italic; opacity: 0.75; }
        table.info .val { font-size: 9.5px; font-weight: bold; color: #131b2e; }
        table.info .val .alt { font-weight: 500; color: #444651; }

        .env { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        .env td { width: 33.33%; text-align: center; padding: 8px; border: 1px solid {{ $pdfColor }}; background: {{ $pdfColor }}12; }
        .env .k { font-size: 6.5px; text-transform: uppercase; color: #54647a; }
        .env .v { font-size: 10.5px; font-weight: bold; color: {{ $pdfColor }}; padding-top: 2px; }

        h4.sec { font-size: 9.5px; font-weight: bold; letter-spacing: 0.5px; color: {{ $pdfColor }};
                 border-bottom: 1.5px solid {{ $pdfColor }}; padding-bottom: 3px; margin: 0 0 7px 0; text-transform: uppercase; }
        h4.sec .en { font-style: italic; font-weight: normal; color: #54647a; }

        .remark { border: 0.6px solid #c5c5d3; padding: 9px 11px; margin-bottom: 16px; background: #faf8ff; }
        .remark p { margin: 0; font-size: 7.5px; text-align: justify; color: #444651; line-height: 1.5; }
        .remark p.note { margin-top: 5px; color: {{ $pdfColor }}; font-weight: bold; }

        .concl { width: 100%; border-collapse: collapse; border: 2px solid {{ $pdfColor }}; margin-bottom: 22px; }
        .concl td { padding: 12px; vertical-align: middle; background: {{ $pdfColor }}0d; }
        .concl .badge { background: {{ $pdfColor }}; color: {{ $onPrimary }}; padding: 9px 4px; font-weight: bold;
                        font-size: 14px; letter-spacing: 2px; text-align: center; border-radius: 4px; }
        .concl .badge.no { background: #ba1a1a; }
        .concl .id { font-size: 9px; font-weight: bold; color: {{ $pdfColor }}; margin: 0; }
        .concl .en { font-size: 8px; font-style: italic; color: #54647a; margin: 3px 0 0 0; }

        .sign { width: 100%; border-collapse: collapse; border-top: 1px solid #c5c5d3; }
        .sign td { vertical-align: top; font-size: 7.5px; padding-top: 14px; }
        .sign .addr { width: 55%; }
        .sign .addr .b { font-weight: bold; font-size: 8.5px; color: {{ $pdfColor }}; margin: 0 0 3px 0; }
        .sign .addr p { margin: 0; color: #54647a; line-height: 1.6; }
        .sign .iss { width: 45%; text-align: center; }
        .sign .iss .k { font-size: 8px; }
        .sign .iss .d { font-size: 9px; font-weight: bold; margin-bottom: 40px; }
        .sign .iss .nm { border-top: 1px solid #131b2e; display: inline-block; padding-top: 4px; min-width: 210px; font-weight: bold; font-size: 9.5px; }
        .sign .iss .role { font-style: italic; font-size: 7.5px; color: #54647a; margin-top: 2px; }

        .legal { text-align: center; font-size: 6px; text-transform: uppercase; color: #757682; margin-top: 12px; letter-spacing: 0.3px; }
    </style>
</head>
<body>
    <div class="frame">
        <div class="topbar"></div>
        <div class="inner">
            <table class="head">
                <tr>
                    <td class="logo">@if(config('company.logo') && file_exists(public_path(config('company.logo'))))<img src="{{ public_path(config('company.logo')) }}">@else<div class="tx">ECM</div>@endif</td>
                    <td class="lab">
                        <div class="nm">{{ strtoupper(config('company.name')) }}</div>
                        <div class="ds">Laboratorium Pengujian &amp; Kalibrasi Alat Kesehatan<br>
                        No. Izin: {{ config('company.license') }} &nbsp;|&nbsp; KAN {{ config('company.kan') }}</div>
                    </td>
                    <td class="r">
                        <div class="t1">Sertifikat Kalibrasi</div>
                        <div class="t2">Certificate of Calibration</div>
                    </td>
                </tr>
            </table>

            <p class="certno">
                <span class="k">No. Sertifikat / Certificate Number</span><br>
                <span class="v">{{ $detail->so_detail_sertifikat_no ?? '-' }}</span>
            </p>

            <table class="info">
                <tr>
                    <td class="lbl"><div class="id">No. Pesanan</div><div class="en">Order Number</div></td>
                    <td><div class="val">{{ $detail->so?->so_code }}</div></td>
                    <td class="lbl"><div class="id">Nama Alat</div><div class="en">Equipment</div></td>
                    <td><div class="val">{{ $detail->product?->product_nama ?? '-' }}</div></td>
                </tr>
                <tr>
                    <td class="lbl"><div class="id">Pemilik</div><div class="en">Owner</div></td>
                    <td><div class="val">{{ $detail->so?->customer?->customer_nama ?? '-' }}</div></td>
                    <td class="lbl"><div class="id">Merek / Model</div><div class="en">Brand / Model</div></td>
                    <td><div class="val">{{ $l['merek'] ?? '-' }}{{ !empty($l['tipe']) ? ' / '.$l['tipe'] : '' }}</div></td>
                </tr>
                <tr>
                    <td class="lbl"><div class="id">Alamat</div><div class="en">Address</div></td>
                    <td><div class="val alt">{{ $detail->so?->customer?->customer_alamat ?? '-' }}</div></td>
                    <td class="lbl"><div class="id">Nomor Seri</div><div class="en">Serial Number</div></td>
                    <td><div class="val">{{ $l['no_seri'] ?? '-' }}</div></td>
                </tr>
                <tr>
                    <td class="lbl"><div class="id">Lokasi / Ruang</div><div class="en">Location</div></td>
                    <td><div class="val">{{ $l['ruangan'] ?? '-' }}</div></td>
                    <td class="lbl"><div class="id">Tanggal Kalibrasi</div><div class="en">Calibration Date</div></td>
                    <td><div class="val">{{ !empty($l['tanggal']) ? \Illuminate\Support\Carbon::parse($l['tanggal'])->format('d F Y') : (optional($detail->so_detail_kerja_selesai_at)->format('d F Y') ?? '-') }}</div></td>
                </tr>
            </table>

            <table class="env">
                <tr>
                    <td><div class="k">Suhu / Temperature</div><div class="v">{{ $l['suhu_awal'] ?? '-' }}{{ isset($l['suhu_akhir']) && $l['suhu_akhir'] !== '' ? ' – '.$l['suhu_akhir'] : '' }} °C</div></td>
                    <td><div class="k">Kelembaban / Humidity</div><div class="v">{{ $l['lembab_awal'] ?? '-' }}{{ isset($l['lembab_akhir']) && $l['lembab_akhir'] !== '' ? ' – '.$l['lembab_akhir'] : '' }} %RH</div></td>
                    <td><div class="k">Metode / Method</div><div class="v">Kemenkes RI</div></td>
                </tr>
            </table>

            <h4 class="sec">Keterangan / <span class="en">Remark</span></h4>
            <div class="remark">
                <p>Ketidakpastian diperluas dinyatakan sebagai ketidakpastian standar pengukuran dikalikan dengan faktor cakupan k = 2, yang untuk distribusi normal berhubungan dengan tingkat kepercayaan sekitar 95%. Estimasi ketidakpastian dilakukan sesuai dengan JCGM 100:2008 (GUM 1995).</p>
                @if (!empty($l['catatan']))
                    <p class="note">Catatan Petugas: {{ $l['catatan'] }}</p>
                @endif
            </div>

            <h4 class="sec">Kesimpulan / <span class="en">Conclusion</span></h4>
            <table class="concl">
                <tr>
                    <td style="width:150px;"><div class="badge {{ $laik ? '' : 'no' }}">{{ $laik ? 'LAIK PAKAI' : 'TIDAK LAIK' }}</div></td>
                    <td>
                        <p class="id">Berdasarkan Peraturan Menteri Kesehatan RI No. 54 Tahun 2015</p>
                        <p class="en">Based on Ministry of Health Regulation No. 54 of 2015, the equipment is deemed {{ $laik ? 'FIT FOR USE' : 'NOT FIT FOR USE' }}.</p>
                    </td>
                </tr>
            </table>

            <table class="sign">
                <tr>
                    <td class="addr">
                        <p class="b">{{ strtoupper(config('company.name')) }}</p>
                        <p>{{ config('company.footer_address') }}</p>
                        <p>T: {{ config('company.footer_telp') }} &nbsp;|&nbsp; WA: {{ config('company.whatsapp') }}</p>
                        <p>{{ config('company.website') }} &nbsp;|&nbsp; {{ config('company.email') }}</p>
                    </td>
                    <td class="iss">
                        <div class="k">Diterbitkan pada / <span style="font-style:italic;">Issued on</span></div>
                        <div class="d">{{ optional($detail->so_detail_kerja_selesai_at)->format('d F Y') ?? now()->format('d F Y') }}</div>
                        <span class="nm">{{ config('company.director') }}</span>
                        <div class="role">Technical Manager</div>
                    </td>
                </tr>
            </table>

            <div class="legal">© {{ date('Y') }} {{ config('company.name') }} — Sertifikat ini tidak boleh digandakan kecuali secara utuh.</div>
        </div>
        <div class="bottombar"></div>
    </div>
</body>
</html>
