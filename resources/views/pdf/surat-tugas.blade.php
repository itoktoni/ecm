<?php /** @var App\Models\So $so */ ?>
@php $pdfColor = config('theme.primary'); $onPrimary = config('theme.on_primary'); @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Surat Tugas {{ $so->so_code }}</title>
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
        .certno .v { font-size: 13px; font-weight: bold; letter-spacing: 1px; }

        p.par { margin: 9px 0; text-align: justify; font-size: 9.5px; line-height: 1.6; }
        .intro { margin: 10px 0; }

        table.data { width: 100%; border-collapse: collapse; margin: 12px 0; }
        table.data th { background: {{ $pdfColor }}; color: {{ $onPrimary }}; font-weight: bold; text-transform: uppercase;
                        font-size: 8px; letter-spacing: 0.4px; padding: 7px 9px; border: 0.6px solid {{ $pdfColor }}; text-align: left; }
        table.data td { padding: 6px 9px; border: 0.6px solid #d8dce6; font-size: 9px; }
        table.data tr:nth-child(even) td { background: #f6f8fc; }
        .ctr { text-align: center; }
        .b { font-weight: bold; }

        table.work { width: 100%; border-collapse: collapse; margin: 10px 0; }
        table.work td { padding: 5px 9px; border: 0.6px solid #d8dce6; font-size: 9px; }
        table.work td.k { background: {{ $pdfColor }}0d; font-weight: bold; width: 22%; }

        .sign { width: 100%; border-collapse: collapse; margin-top: 26px; border-top: 1px solid #c5c5d3; }
        .sign td { width: 50%; vertical-align: top; text-align: center; font-size: 8.5px; padding-top: 12px; }
        .sign .role { margin: 0 0 2px 0; }
        .sign .co { font-weight: bold; color: {{ $pdfColor }}; font-size: 9.5px; margin: 0; }
        .sign .gap { height: 54px; }
        .sign .line { border-top: 1px solid #000; font-weight: 600; padding-top: 3px; display: inline-block; min-width: 200px; }
        .sign .ti { font-size: 8px; color: #54647a; }

        .foot { border-top: 1px solid #e5e2e1; padding-top: 8px; margin-top: 18px; font-size: 8px; color: #666; width: 100%; }
        .foot td { vertical-align: bottom; }
        .foot .b { font-weight: bold; color: {{ $pdfColor }}; }
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
                        <div class="t1">Surat Tugas</div>
                        <div class="t2">Assignment Letter</div>
                    </td>
                </tr>
            </table>

            <p class="certno">
                <span class="k">Nomor Surat Tugas</span><br>
                <span class="v">ST/{{ $so->so_code }}</span>
            </p>

            <p class="intro">Yang bertanda tangan di bawah ini, pimpinan {{ config('company.name') }}, dengan ini menugaskan:</p>

            @if ($so->petugas->isEmpty())
                <p class="par" style="font-style:italic; color:#888;">Belum ada petugas yang ditugaskan. Silakan tambahkan petugas pada form Sales Order.</p>
            @else
                <table class="data">
                    <thead>
                        <tr>
                            <th class="ctr" style="width:8%">No</th>
                            <th>Nama Petugas</th>
                            <th style="width:28%">Email</th>
                            <th style="width:18%">Jabatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($so->petugas as $i => $p)
                            <tr>
                                <td class="ctr">{{ $i + 1 }}</td>
                                <td class="b">{{ $p->name }}</td>
                                <td>{{ $p->email }}</td>
                                <td>{{ ucfirst($p->role ?? 'Teknisi') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <p class="par">Untuk melaksanakan pekerjaan Pengujian dan Kalibrasi Alat Kesehatan dengan rincian sebagai berikut:</p>

            <table class="work">
                <tr><td class="k">Nomor SO</td><td class="b">{{ $so->so_code }}</td><td class="k">Tanggal</td><td>{{ $so->so_tanggal->format('d F Y') }}</td></tr>
                <tr><td class="k">Pemberi Kerja</td><td>{{ $so->customer?->customer_nama ?? '-' }}</td><td class="k">Jumlah Alat</td><td>{{ $so->details->sum('so_detail_qty') }} unit ({{ $so->details->count() }} jenis)</td></tr>
                <tr><td class="k">Lokasi Pekerjaan</td><td colspan="3">{{ $so->customer?->customer_alamat ?? '-' }}</td></tr>
                @if ($so->so_keterangan)
                    <tr><td class="k">Keterangan</td><td colspan="3">{{ $so->so_keterangan }}</td></tr>
                @endif
            </table>

            <p class="par">
                Demikian Surat Tugas ini dibuat untuk dilaksanakan dengan penuh tanggung jawab. Petugas yang ditugaskan wajib
                melaporkan hasil pekerjaan setelah kegiatan selesai.
            </p>

            <table class="sign">
                <tr>
                    <td></td>
                    <td>
                        <p class="role">{{ config('company.city') }}, {{ $so->so_tanggal->format('d F Y') }}</p>
                        <p class="co">{{ strtoupper(config('company.name')) }}</p>
                        <div class="gap"></div>
                        <span class="line">{{ config('company.director') }}</span>
                        <p class="ti">{{ config('company.director_title') }}</p>
                    </td>
                </tr>
            </table>

            <table class="foot">
                <tr>
                    <td><div class="b">{{ strtoupper(config('company.name')) }}</div><div>{{ config('company.footer_address') }}</div></td>
                    <td style="text-align:right;">T: {{ config('company.footer_telp') }} | WA: {{ config('company.whatsapp') }}<br>{{ config('company.website') }} | {{ config('company.email') }}</td>
                </tr>
            </table>
            <div class="legal">© {{ date('Y') }} {{ config('company.name') }} — Dokumen ini sah tanpa tanda tangan basah bila diterbitkan melalui sistem.</div>
        </div>
        <div class="bottombar"></div>
    </div>
</body>
</html>
