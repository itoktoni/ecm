<?php /** @var App\Models\SoDetail $detail */ ?>
@php $l = $detail->so_detail_lembar ?? []; $pdfColor = config('theme.primary'); $onPrimary = config('theme.on_primary'); @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Berita Acara {{ $detail->so_detail_code }}</title>
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
        .head .r .t1 { font-size: 22px; font-weight: bold; color: {{ $pdfColor }}; text-transform: uppercase; letter-spacing: 1px; }
        .head .r .t2 { font-size: 10px; font-style: italic; color: #54647a; }

        .certno { background: {{ $pdfColor }}; color: {{ $onPrimary }}; text-align: center; padding: 8px; margin: 0 0 14px 0; }
        .certno .k { font-size: 7px; text-transform: uppercase; letter-spacing: 1px; opacity: 0.85; }
        .certno .v { font-size: 13px; font-weight: bold; letter-spacing: 1px; }

        table.kv { width: 100%; border-collapse: collapse; margin: 8px 0; }
        table.kv td { padding: 6px 9px; border: 0.6px solid #d8dce6; font-size: 9px; vertical-align: top; }
        table.kv td.k { background: {{ $pdfColor }}0d; font-weight: bold; width: 22%; }

        h3.sec { color: {{ $pdfColor }}; font-size: 10px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px;
                 margin: 14px 0 5px 0; border-bottom: 1.5px solid {{ $pdfColor }}; padding-bottom: 3px; }

        table.chk { width: 100%; border-collapse: collapse; margin: 6px 0; }
        table.chk td { border: 0.6px solid #d8dce6; padding: 5px 9px; font-size: 9px; }
        table.chk td.lbl { background: #f6f8fc; }
        table.chk th { background: {{ $pdfColor }}; color: {{ $onPrimary }}; padding: 6px 9px; border: 0.6px solid {{ $pdfColor }}; font-size: 8px; text-transform: uppercase; }
        .ctr { text-align: center; }

        .verdict { margin-top: 10px; padding: 9px 12px; border: 1.5px solid {{ $pdfColor }}; background: {{ $pdfColor }}0d; font-weight: bold; color: {{ $pdfColor }}; }

        .sign { width: 100%; border-collapse: collapse; margin-top: 26px; border-top: 1px solid #c5c5d3; }
        .sign td { width: 50%; vertical-align: top; text-align: center; font-size: 8.5px; padding-top: 12px; }
        .sign .gap { height: 52px; }
        .sign .line { border-top: 1px solid #000; font-weight: 600; padding-top: 3px; display: inline-block; min-width: 180px; }

        .foot { border-top: 1px solid #e5e2e1; padding-top: 8px; margin-top: 18px; font-size: 8px; color: #666; }
        .legal { text-align: center; font-size: 6px; text-transform: uppercase; color: #757682; margin-top: 10px; letter-spacing: 0.3px; }
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
                        <div class="t1">Berita Acara</div>
                        <div class="t2">Inspection Report</div>
                    </td>
                </tr>
            </table>

            <p class="certno">
                <span class="k">Nomor Berita Acara</span><br>
                <span class="v">{{ $detail->so_detail_sertifikat_no ?? '-' }}</span>
            </p>

            <h3 class="sec">Data Pelanggan &amp; Pelaksanaan</h3>
            <table class="kv">
                <tr><td class="k">No Pesanan (SO)</td><td>{{ $detail->so?->so_code }}</td><td class="k">Pelanggan</td><td>{{ $detail->so?->customer?->customer_nama ?? '-' }}</td></tr>
                <tr><td class="k">Tempat Pelaksanaan</td><td>{{ $l['tempat'] ?? '-' }}</td><td class="k">Ruangan</td><td>{{ $l['ruangan'] ?? '-' }}</td></tr>
                <tr><td class="k">Tanggal Pelaksanaan</td><td>{{ $l['tanggal'] ?? '-' }}</td><td class="k">Petugas Pelaksana</td><td>{{ $detail->teknisi?->name ?? '-' }}</td></tr>
            </table>

            <h3 class="sec">Data Peralatan</h3>
            <table class="kv">
                <tr><td class="k">Nama Alat</td><td>{{ $detail->product?->product_nama ?? '-' }}</td><td class="k">Jenis Alat</td><td>{{ $l['jenis_alat'] ?? '-' }}</td></tr>
                <tr><td class="k">Merek</td><td>{{ $l['merek'] ?? '-' }}</td><td class="k">Tipe</td><td>{{ $l['tipe'] ?? '-' }}</td></tr>
                <tr><td class="k">Nomor Seri</td><td>{{ $l['no_seri'] ?? '-' }}</td><td class="k">Resolusi / Rentang</td><td>{{ $l['resolusi'] ?? '-' }} / {{ $l['rentang'] ?? '-' }}</td></tr>
            </table>

            <h3 class="sec">Kondisi Lingkungan</h3>
            <table class="kv">
                <tr><td class="k">Suhu (Awal / Akhir)</td><td>{{ $l['suhu_awal'] ?? '-' }} / {{ $l['suhu_akhir'] ?? '-' }} °C</td><td class="k">Kelembaban (Awal / Akhir)</td><td>{{ $l['lembab_awal'] ?? '-' }} / {{ $l['lembab_akhir'] ?? '-' }} %RH</td></tr>
            </table>

            <h3 class="sec">Pemeriksaan Fisik &amp; Fungsi</h3>
            <table class="chk">
                <tr>
                    <th style="width:38%">Item Pemeriksaan</th>
                    <th style="width:12%" class="ctr">Hasil</th>
                    <th style="width:38%">Item Pemeriksaan</th>
                    <th style="width:12%" class="ctr">Hasil</th>
                </tr>
                @php
                    $items = [
                        'badan' => 'Badan dan Permukaan Alat', 'kabel' => 'Kabel Catu Daya',
                        'sekering' => 'Sekering', 'kotak_kontak' => 'Kotak Kontak',
                        'tombol' => 'Tombol', 'indikator' => 'Tampilan dan Indikator',
                    ];
                    $pairs = array_chunk(array_keys($items), 2, true);
                @endphp
                @foreach(array_chunk(array_keys($items), 2, true) as $chunk)
                    <tr>
                        @foreach($chunk as $key)
                            <td class="lbl">{{ $items[$key] }}</td>
                            <td class="ctr">{{ $l['fisik_'.$key] ?? '-' }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </table>

            <div class="verdict">Penilaian Menyeluruh: {{ $l['penilaian'] ?? '-' }}</div>

            @if(!empty($l['catatan']))
                <h3 class="sec">Catatan Petugas</h3>
                <p style="margin:0; font-size:9px;">{{ $l['catatan'] }}</p>
            @endif

            <table class="sign">
                <tr>
                    <td>
                        <p>Mengetahui / Pelanggan</p>
                        <div class="gap"></div>
                        <span class="line">(....................................................)</span>
                    </td>
                    <td>
                        <p>Petugas Pelaksana,</p>
                        <div class="gap"></div>
                        <span class="line">{{ $detail->teknisi?->name ?? '(..........................)' }}</span>
                    </td>
                </tr>
            </table>

            <div class="foot">
                Sesuai Metode Kerja Pengujian dan Kalibrasi Alat Kesehatan Kementerian Kesehatan RI No. HK.02.02/V/0412/2020.
                Dokumen ini sah tanpa perlu tanda tangan basah bila diterbitkan melalui sistem {{ config('company.name') }}.
            </div>
            <div class="legal">© {{ date('Y') }} {{ config('company.name') }}</div>
        </div>
        <div class="bottombar"></div>
    </div>
</body>
</html>
