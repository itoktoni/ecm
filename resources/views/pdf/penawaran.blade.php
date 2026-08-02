<?php /** @var App\Models\So $so */ ?>
@php $pdfColor = config('theme.primary'); $onPrimary = config('theme.on_primary'); @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Penawaran {{ $so->so_code }}</title>
    <style>
        * { font-family: DejaVu Sans, sans-serif; box-sizing: border-box; }
        @page { margin: 12mm 12mm; }
        body { margin: 0; padding: 0; color: #1a1c1e; font-size: 10px; line-height: 1.5; }

        .frame { border: 2px solid {{ $pdfColor }}; }
        .topbar { background: {{ $pdfColor }}; height: 6px; }
        .bottombar { background: {{ $pdfColor }}; height: 6px; }
        .inner { padding: 18px 22px; }

        .muted { color: #666; }

        .kop { border-bottom: 2px solid {{ $pdfColor }}; padding-bottom: 10px; margin-bottom: 14px; width: 100%; }
        .kop table { width: 100%; }
        .kop td { vertical-align: middle; }
        .kop .logo { font-size: 28px; font-weight: bold; color: {{ $pdfColor }}; line-height: 1; }
        .kop .cname { font-size: 13px; font-weight: bold; color: #131b2e; margin-top: 2px; }
        .kop .sub { font-size: 8px; text-transform: uppercase; font-weight: bold; color: #54647a; margin-top: 2px; line-height: 1.35; }
        .kop .sub .it { font-style: italic; font-weight: normal; text-transform: none; }
        .kan { border: 2px solid {{ $pdfColor }}; padding: 3px 5px; text-align: center; width: 96px; float: right; }
        .kan .b { font-weight: bold; font-size: 12px; color: {{ $pdfColor }}; line-height: 1.1; }
        .kan .s { font-size: 6.5px; line-height: 1.1; margin-bottom: 2px; color: #54647a; }
        .kan .c { font-size: 8.5px; font-weight: bold; border-top: 1px solid {{ $pdfColor }}; padding-top: 2px; color: {{ $pdfColor }}; }
        .kan-sm { border: 1px solid {{ $pdfColor }}; padding: 2px 4px; text-align: center; width: 64px; float: right; }
        .kan-sm .b { font-weight: bold; font-size: 8.5px; color: {{ $pdfColor }}; }
        .kan-sm .s { font-size: 6px; color: #54647a; }

        .meta { width: 100%; margin-bottom: 12px; }
        .meta td { vertical-align: top; }
        .metatbl td { padding: 1px 0; font-size: 9.5px; }
        .metatbl .k { font-weight: bold; width: 30px; }
        .metatbl .s { width: 10px; }
        .date { text-align: right; font-weight: 500; font-size: 9.5px; }

        .to { margin-bottom: 12px; font-size: 10px; }
        .to .b { font-weight: bold; }
        p.par { margin: 9px 0; text-align: justify; font-size: 9.5px; }

        table.data { width: 100%; border-collapse: collapse; margin: 12px 0; }
        table.data th { background: {{ $pdfColor }}; color: {{ $onPrimary }}; font-weight: bold; text-transform: uppercase; font-size: 8px; letter-spacing: 0.4px; padding: 7px 9px; border: 0.6px solid {{ $pdfColor }}; text-align: left; }
        table.data td { padding: 6px 9px; border: 0.6px solid #d8dce6; font-size: 9px; }
        table.data tr:nth-child(even) td { background: #f6f8fc; }
        .ctr { text-align: center; }
        .num { text-align: right; }
        .b { font-weight: bold; }

        .cols { width: 100%; margin-top: 8px; }
        .cols td { vertical-align: top; width: 50%; padding-right: 14px; }
        .cols h3 { font-weight: bold; color: {{ $pdfColor }}; text-transform: uppercase; font-size: 9.5px; letter-spacing: 0.5px; margin: 0 0 5px 0; }
        .cols ol, .cols ul { margin: 0; padding-left: 15px; font-size: 9px; }
        .cols li { margin: 2px 0; }

        .sign { width: 100%; margin-top: 26px; }
        .sign td { width: 50%; text-align: center; vertical-align: top; font-size: 9px; }
        .sign .role { color: #54647a; margin: 0 0 2px 0; }
        .sign .co { font-weight: bold; color: {{ $pdfColor }}; font-size: 9.5px; margin: 0; }
        .sign .gap { height: 54px; }
        .sign .line { border-top: 1px solid #000; font-weight: 600; padding-top: 3px; display: inline-block; min-width: 180px; }
        .sign .cap { font-size: 8px; color: #888; font-style: italic; margin-top: 2px; }
        .sign .ti { font-size: 8.5px; }

        .foot { border-top: 1px solid #e5e2e1; padding-top: 8px; margin-top: 16px; font-size: 8px; color: #666; width: 100%; }
        .foot td { vertical-align: bottom; }
        .foot .b { font-weight: bold; color: {{ $pdfColor }}; }
        .legal { text-align: center; font-size: 6px; text-transform: uppercase; color: #757682; margin-top: 10px; letter-spacing: 0.3px; }

        .page-break { page-break-after: always; }
        h2.title { text-align: center; font-weight: bold; font-size: 14px; text-transform: uppercase; letter-spacing: 2px; color: {{ $pdfColor }}; margin: 0 0 18px 0; padding-bottom: 4px; }
        h2.title.u { border-bottom: 2px solid {{ $pdfColor }}; display: inline-block; }
        .title-wrap { text-align: center; margin-bottom: 18px; }
        .title-band { text-align: center; font-weight: bold; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; background: {{ $pdfColor }}; color: {{ $onPrimary }}; padding: 8px; margin-bottom: 14px; }

        section { margin-bottom: 14px; }
        section h3 { font-weight: bold; color: {{ $pdfColor }}; border-bottom: 1.5px solid {{ $pdfColor }}; padding-bottom: 3px; margin: 0 0 8px 0; font-size: 11px; text-transform: uppercase; }
        section ol { margin: 0; padding-left: 16px; font-size: 9px; }
        section li { margin: 4px 0; text-align: justify; }

        tfoot .total td { background: {{ $pdfColor }}; color: {{ $onPrimary }}; font-weight: bold; border: 0.6px solid {{ $pdfColor }}; padding: 8px 9px; }
        .rev-info { width: 100%; font-size: 9px; margin-bottom: 10px; }
        .rev-info td { vertical-align: top; padding: 1px 0; }
        .rev-info .k { font-weight: bold; width: 115px; }
        .keterangan { border: 1px solid #d8dce6; padding: 8px; font-size: 8.5px; color: #444651; margin-top: 10px; }
        .keterangan .h { font-weight: bold; color: {{ $pdfColor }}; text-transform: uppercase; margin-bottom: 3px; }
        .keterangan td { width: 50%; vertical-align: top; }
        .callout { border: 1px solid {{ $pdfColor }}; background: {{ $pdfColor }}0d; padding: 8px; font-style: italic; text-align: center; font-size: 8.5px; margin-top: 12px; }
    </style>
</head>
<body>
    @php
        $totalQty = $so->details->sum('so_detail_qty');
    @endphp

    {{-- ============ HALAMAN 1: SURAT PENAWARAN ============ --}}
    <div class="frame">
        <div class="topbar"></div>
        <div class="inner">
            <div class="kop">
            <table>
                <tr>
                    <td>
                        @if(config('company.logo') && file_exists(public_path(config('company.logo'))))
                            <img src="{{ public_path(config('company.logo')) }}" style="max-height:52px; margin-bottom:4px;">
                        @else
                            <div class="logo">ECM</div>
                        @endif
                        <div class="cname">{{ strtoupper(config('company.name')) }}</div>
                        <div class="sub">
                            Institusi Pengujian Fasilitas Kesehatan<br>
                            Laboratorium Pengujian dan Kalibrasi Alat Medis<br>
                            <span class="it">- Test And Calibration Medical Devices Laboratory -</span>
                        </div>
                    </td>
                    <td>
                        <div class="kan">
                            <div class="b">KAN</div>
                            <div class="s">Komite Akreditasi Nasional</div>
                            <div class="c">{{ config('company.kan') }}</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <table class="meta">
            <tr>
                <td style="width:60%">
                    <table class="metatbl">
                        <tr><td class="k">No</td><td class="s">:</td><td>{{ config('company.doc_code') }}</td></tr>
                        <tr><td class="k">Hal</td><td class="s">:</td><td>Penawaran Harga Jasa Pengujian dan Kalibrasi Alat Kesehatan</td></tr>
                    </table>
                </td>
                <td class="date">{{ config('company.city') }}, {{ $so->so_tanggal->format('d F Y') }}</td>
            </tr>
        </table>

        <div class="to">
            Kepada Yth,<br>
            <span class="b">{{ $so->customer?->customer_nama ?? '-' }}</span><br>
            {{ $so->customer?->customer_alamat ?? 'Di TEMPAT' }}
        </div>

        <p class="par">
            Bersama ini kami Laboratorium Kalibrasi Alat Kesehatan {{ config('company.name') }} dengan Nomor Izin
            Praktik Laboratorium Kalibrasi Alat Kesehatan: {{ config('company.license') }} memberikan penawaran harga
            jasa Kalibrasi terdiri dari:
        </p>

        <table class="data">
            <thead>
                <tr>
                    <th class="ctr" style="width:8%">No</th>
                    <th>Jenis Pekerjaan</th>
                    <th class="ctr" style="width:15%">Jumlah</th>
                    <th class="num" style="width:26%">Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="ctr">1</td>
                    <td class="b">Pekerjaan Kalibrasi Alat Kesehatan (rincian terlampir)</td>
                    <td class="ctr">{{ $totalQty }}</td>
                    <td class="num b">Rp {{ number_format($so->so_grand_total, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <table class="cols">
            <tr>
                <td>
                    <h3>Keunggulan Layanan:</h3>
                    <ol>
                        <li>Pengujian dan Kalibrasi dilakukan menggunakan System LK Digital (Paperless)</li>
                        <li>Update ASPAK maksimal 1 minggu setelah pembayaran.</li>
                        <li>Label Kalibrasi QR Code System, sertifikat bisa di cek melalui website {{ config('company.website') }}</li>
                        <li>Free Akses Aplikasi ECM CMS Android base*</li>
                        <li>Perhitungan kelaikan alat secara "Real time"</li>
                        <li>Pengiriman Sertifikat maksimal 1 minggu setelah pekerjaan selesai</li>
                    </ol>
                </td>
                <td>
                    <h3>Kondisi Penawaran:</h3>
                    <ul>
                        <li>Termasuk Sertifikat Kalibrasi resmi dari {{ config('company.name') }}.</li>
                        <li>Tarif sudah termasuk biaya pajak yang timbul.</li>
                        <li>Sudah termasuk Biaya Akomodasi (Pekerjaan Insitu).</li>
                        <li>Pembayaran via Bank Nagari Syariah atau Bank BNI.</li>
                    </ul>
                </td>
            </tr>
        </table>

        <p class="par" style="margin-top:22px;">Demikian, atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>

        <table class="sign">
            <tr>
                <td>
                    <p class="role">Menyetujui/tidak menyetujui</p>
                    <div class="gap"></div>
                    <span class="line">(....................................................)</span>
                    <p class="cap">Tanda Tangan &amp; Cap Instansi</p>
                </td>
                <td>
                    <p class="role b" style="color:#1b1c1c;">Hormat kami,</p>
                    <p class="co">{{ strtoupper(config('company.name')) }}</p>
                    <div class="gap"></div>
                    <span class="line">{{ config('company.director') }}</span>
                    <p class="ti">{{ config('company.director_title') }}</p>
                </td>
            </tr>
        </table>

        <div class="muted" style="font-size:9px; font-style:italic; margin-top:10px;">* Syarat dan Ketentuan Berlaku</div>

        <table class="foot">
            <tr>
                <td>
                    <div class="b">{{ strtoupper(config('company.name')) }}</div>
                    <div>{{ config('company.footer_address') }}</div>
                </td>
                <td class="num">
                    <div>Telp: {{ config('company.footer_telp') }} | WA: {{ config('company.whatsapp') }}</div>
                    <div>{{ config('company.website') }} | {{ config('company.email') }}</div>
                </td>
            </tr>
        </table>
        </div>
        <div class="bottombar"></div>
    </div>

    {{-- ============ HALAMAN 2: PERSYARATAN ============ --}}
    <div class="frame page-break">
        <div class="topbar"></div>
        <div class="inner">
            <div class="kop">
                <table>
                    <tr>
                        <td>@if(config('company.logo') && file_exists(public_path(config('company.logo'))))<img src="{{ public_path(config('company.logo')) }}" style="max-height:44px;">@else<div class="logo" style="font-size:20px;">ECM</div>@endif<div class="cname" style="font-size:12px;">{{ strtoupper(config('company.name')) }}</div></td>
                        <td><div class="kan-sm"><div class="b">KAN</div><div class="s">{{ config('company.kan') }}</div></div></td>
                    </tr>
                </table>
            </div>

        <div class="title-wrap"><h2 class="title u">Lampiran Surat Penawaran Harga</h2></div>

        <section>
            <h3>A. PERSYARATAN UMUM</h3>
            <ol>
                <li>Penawaran jadwal pelaksanaan ini hanya berlaku selama 2 (dua) minggu terhitung sejak surat ini dikirim.</li>
                <li>Apabila tidak ada jawaban persetujuan secara tertulis dari pihak Saudara menyangkut biaya dan jadwal pelaksanaan, maka kami anggap batal.</li>
                <li>Pelanggan berkewajiban menugaskan staff atau teknisi untuk mendampingi petugas kami selama melakukan pekerjaan.</li>
                <li>{{ config('company.name') }} tidak bertanggung jawab atas kerusakan akibat pengujian sejauh telah memenuhi prosedur yang berlaku.</li>
                <li>Pelanggan berkewajiban membayar jasa pelayanan sesuai total biaya penawaran tanpa mengkaitkan dengan hasil kelaikan alat.</li>
                <li>Seluruh personel laboratorium {{ config('company.name') }} dilarang menerima gratifikasi, bingkisan, maupun "tip" dalam bentuk apapun.</li>
            </ol>
        </section>

        <section>
            <h3>B. PERSYARATAN KHUSUS PELAYANAN</h3>
            <ol>
                <li>Pengujian mengacu kepada metode kerja resmi Direktorat Jenderal Pelayanan Kesehatan, Kemenkes RI.</li>
                <li>Pelanggan diharuskan menyediakan instalasi pembumian (grounding) pada ruangan yang terdapat peralatan kesehatan.</li>
                <li>Bila tidak tersedia instalasi pembumian, pengujian tetap dilaksanakan dan pelanggan menerima apapun hasil pengujian tersebut.</li>
                <li>Peralatan yang dikerjakan di workshop {{ config('company.name') }}, pelanggan hanya dibebankan tarif pengujian tanpa biaya petugas/akomodasi.</li>
            </ol>
        </section>

        <table class="foot">
            <tr>
                <td><div class="b">{{ strtoupper(config('company.name')) }}</div><div>Dokumen Lampiran Persyaratan Penawaran</div></td>
                <td class="num">Hal. 2 dari 4</td>
            </tr>
        </table>
        </div>
        <div class="bottombar"></div>
    </div>

    {{-- ============ HALAMAN 3: RINCIAN ALAT ============ --}}
    <div class="frame page-break">
        <div class="topbar"></div>
        <div class="inner">
            <div class="kop">
                <table>
                    <tr>
                        <td>@if(config('company.logo') && file_exists(public_path(config('company.logo'))))<img src="{{ public_path(config('company.logo')) }}" style="max-height:44px;">@else<div class="logo" style="font-size:20px;">ECM</div>@endif<div class="cname" style="font-size:12px;">{{ strtoupper(config('company.name')) }}</div></td>
                        <td class="num"><span class="muted" style="font-size:9px;">Ref: {{ config('company.doc_code') }}</span></td>
                    </tr>
                </table>
            </div>

        <h2 class="b primary" style="font-size:15px; margin:0 0 12px 0;">Rincian Peralatan Kesehatan</h2>

        <table class="data" style="font-size:10px;">
            <thead>
                <tr>
                    <th class="ctr" style="width:6%">No</th>
                    <th>Nama Alat Kesehatan</th>
                    <th class="ctr" style="width:9%">Qty</th>
                    <th class="num" style="width:18%">Harga Satuan</th>
                    <th class="num" style="width:20%">Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($so->details as $i => $detail)
                    <tr>
                        <td class="ctr">{{ $i + 1 }}</td>
                        <td class="b">{{ $detail->product?->product_nama ?? '-' }}</td>
                        <td class="ctr">{{ $detail->so_detail_qty }}</td>
                        <td class="num">{{ number_format((float) $detail->so_detail_harga, 0, ',', '.') }}</td>
                        <td class="num">{{ number_format((int) $detail->so_detail_qty * (float) $detail->so_detail_harga, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                @if ((float) $so->so_discount > 0)
                    <tr><td colspan="4" class="num">Discount{{ $so->so_discount_note ? ' ('.$so->so_discount_note.')' : '' }}</td><td class="num">- {{ number_format((float) $so->so_discount, 0, ',', '.') }}</td></tr>
                @endif
                @if ($so->so_ppn_amount > 0)
                    <tr><td colspan="4" class="num">PPN ({{ $so->so_ppn_rate }}%)</td><td class="num">{{ number_format($so->so_ppn_amount, 0, ',', '.') }}</td></tr>
                @endif
                @if ($so->so_pph_amount > 0)
                    <tr><td colspan="4" class="num">PPH ({{ $so->so_pph_rate }}%)</td><td class="num">{{ number_format($so->so_pph_amount, 0, ',', '.') }}</td></tr>
                @endif
                <tr class="total">
                    <td colspan="2" class="ctr">TOTAL AKUMULASI</td>
                    <td class="ctr">{{ $totalQty }}</td>
                    <td class="num" colspan="2">Rp {{ number_format($so->so_grand_total, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <table class="foot">
            <tr>
                <td><div class="b">{{ strtoupper(config('company.name')) }}</div><div>Daftar Rincian Inventaris Alat Kesehatan</div></td>
                <td class="num">Hal. 3 dari 4</td>
            </tr>
        </table>
        </div>
        <div class="bottombar"></div>
    </div>

    {{-- ============ HALAMAN 4: FORM KAJI ULANG ============ --}}
    <div class="frame">
        <div class="topbar"></div>
        <div class="inner">
            <div class="kop">
                <table>
                    <tr>
                        <td>@if(config('company.logo') && file_exists(public_path(config('company.logo'))))<img src="{{ public_path(config('company.logo')) }}" style="max-height:44px;">@else<div class="logo" style="font-size:20px;">ECM</div>@endif<div class="cname" style="font-size:12px;">{{ strtoupper(config('company.name')) }}</div></td>
                        <td><div class="kan-sm"><div class="b">KAN</div><div class="s">{{ config('company.kan') }}</div></div></td>
                    </tr>
                </table>
            </div>

        <div class="title-band">Form Kaji Ulang Permintaan Kalibrasi</div>

        <table class="rev-info">
            <tr>
                <td style="width:50%"><span class="k">Nomor Kaji Ulang</span>: {{ config('company.review_code') }}</td>
                <td><span class="k">Nomor Penawaran</span>: {{ config('company.doc_code') }}</td>
            </tr>
            <tr>
                <td><span class="k">Tanggal Kaji Ulang</span>: {{ $so->so_tanggal->format('d F Y') }}</td>
                <td><span class="k">Pemesan</span>: {{ $so->customer?->customer_nama ?? '-' }}</td>
            </tr>
            <tr>
                <td colspan="2" style="border-top:1px solid #e5e2e1; padding-top:4px;"><span class="k">Identitas Sertifikat</span>: {{ $so->customer?->customer_nama ?? '-' }}{{ $so->customer?->customer_alamat ? ', '.$so->customer->customer_alamat : '' }}</td>
            </tr>
        </table>

        <table class="data" style="font-size:9px;">
            <thead>
                <tr>
                    <th class="ctr" style="width:5%" rowspan="2">No</th>
                    <th rowspan="2">Nama Alat</th>
                    <th class="ctr" style="width:8%" rowspan="2">Qty</th>
                    <th class="ctr" colspan="4">Kaji Ulang*</th>
                    <th class="num" style="width:18%" rowspan="2">Harga Total</th>
                </tr>
                <tr>
                    <th class="ctr" style="width:5%">A</th>
                    <th class="ctr" style="width:5%">B</th>
                    <th class="ctr" style="width:5%">C</th>
                    <th class="ctr" style="width:5%">D</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($so->details as $i => $detail)
                    <tr>
                        <td class="ctr">{{ $i + 1 }}</td>
                        <td>{{ $detail->product?->product_nama ?? '-' }}</td>
                        <td class="ctr">{{ $detail->so_detail_qty }}</td>
                        <td class="ctr">{{ $detail->so_detail_kaji_a ? '✓' : '' }}</td>
                        <td class="ctr">{{ $detail->so_detail_kaji_b ? '✓' : '' }}</td>
                        <td class="ctr">{{ $detail->so_detail_kaji_c ? '✓' : '' }}</td>
                        <td class="ctr">{{ $detail->so_detail_kaji_d ? '✓' : '' }}</td>
                        <td class="num">{{ number_format((int) $detail->so_detail_qty * (float) $detail->so_detail_harga, 0, ',', '.') }}</td>
                    </tr>
                    @if ($detail->so_detail_kaji_keterangan)
                        <tr>
                            <td></td>
                            <td colspan="7" style="font-style:italic; color:#555; font-size:8.5px;">Ket: {{ $detail->so_detail_kaji_keterangan }}</td>
                        </tr>
                    @endif
                @endforeach
                <tr class="total">
                    <td colspan="7" class="num">GRAND TOTAL</td>
                    <td class="num">Rp {{ number_format($so->so_grand_total, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <table class="keterangan">
            <tr>
                <td colspan="2"><div class="h">Keterangan Kaji Ulang Permintaan:</div></td>
            </tr>
            <tr>
                <td>
                    <span class="b">A.</span> Kesiapan Personel Kalibrasi (Tersedia)<br>
                    <span class="b">B.</span> Kondisi Peralatan Standar (Tersedia &amp; Terkalibrasi)
                </td>
                <td>
                    <span class="b">C.</span> Metode Kerja (Resmi Kemenkes)<br>
                    <span class="b">D.</span> Waktu Pelaksanaan (Disepakati)
                </td>
            </tr>
        </table>

        <table class="sign">
            <tr>
                <td>
                    <p class="role b" style="color:#1b1c1c;">Mengetahui / Pelanggan</p>
                    <div class="gap" style="height:48px;"></div>
                    <span class="line">(....................................................)</span>
                </td>
                <td>
                    <p class="role b" style="color:#1b1c1c;">Administrasi ECM</p>
                    <div class="gap" style="height:48px;"></div>
                    <span class="line">{{ config('company.admin') }}</span>
                </td>
            </tr>
        </table>

        <div class="callout">
            Apabila dokumen ini sudah diterima, maka harap ditandatangani dan dicap dan dikirim kembali melalui email:
            {{ config('company.email') }} atau melalui Whatsapp: {{ config('company.whatsapp') }}
        </div>

        <table class="foot">
            <tr>
                <td><div class="b">{{ strtoupper(config('company.name')) }}</div><div>Dokumen Kaji Ulang Layanan</div></td>
                <td class="num">Hal. 4 dari 4</td>
            </tr>
        </table>
        </div>
        <div class="bottombar"></div>
    </div>
</body>
</html>
