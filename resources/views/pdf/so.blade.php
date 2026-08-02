<?php /** @var App\Models\So $so */ ?>
@php $pdfColor = config('theme.primary'); $onPrimary = config('theme.on_primary'); @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>SO {{ $so->so_code }}</title>
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

        table.info { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
        table.info td { padding: 6px 9px; border: 0.6px solid #d8dce6; }
        table.info td.lbl { background: {{ $pdfColor }}; color: {{ $onPrimary }}; font-weight: bold; width: 17%; }
        table.info .id { font-size: 7.5px; text-transform: uppercase; letter-spacing: 0.4px; }
        table.info .val { font-size: 9.5px; font-weight: bold; color: #131b2e; }
        table.info .val .alt { font-weight: 500; color: #444651; }

        table.data { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
        table.data th { background: {{ $pdfColor }}; color: {{ $onPrimary }}; font-weight: bold; text-transform: uppercase;
                        font-size: 8px; letter-spacing: 0.4px; padding: 7px 9px; border: 0.6px solid {{ $pdfColor }}; text-align: left; }
        table.data td { padding: 6px 9px; border: 0.6px solid #d8dce6; font-size: 9px; }
        table.data tr:nth-child(even) td { background: #f6f8fc; }
        .num { text-align: right; }
        table.data tfoot td { font-weight: bold; background: #eef1f8; }

        .totals-block { width: 46%; margin-left: auto; margin-top: 6px; }
        .totals-block table { width: 100%; border-collapse: collapse; }
        .totals-block td { padding: 4px 9px; font-size: 9px; border: 0.6px solid #d8dce6; }
        .totals-block td.k { background: {{ $pdfColor }}0d; font-weight: bold; }
        .totals-block tr.grand td { background: {{ $pdfColor }}; color: {{ $onPrimary }}; font-weight: bold; font-size: 11px; }

        .notes { margin-top: 12px; border: 0.6px solid #c5c5d3; padding: 9px 11px; background: #faf8ff; }
        .notes h4 { margin: 0 0 5px 0; font-size: 8.5px; color: {{ $pdfColor }}; text-transform: uppercase; letter-spacing: 0.5px; }
        .notes p { margin: 0; font-size: 8.5px; line-height: 1.5; color: #444651; }

        .sign { width: 100%; border-collapse: collapse; margin-top: 26px; border-top: 1px solid #c5c5d3; }
        .sign td { width: 50%; vertical-align: top; text-align: center; font-size: 8.5px; padding-top: 12px; }
        .sign .role { margin: 0 0 2px 0; }
        .sign .gap { height: 52px; }
        .sign .line { border-top: 1px solid #000; font-weight: 600; padding-top: 3px; display: inline-block; min-width: 190px; }
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
                        <div class="t1">Sales Order</div>
                        <div class="t2">Order Confirmation</div>
                    </td>
                </tr>
            </table>

            <p class="certno">
                <span class="k">Nomor Order / Order Number</span><br>
                <span class="v">{{ $so->so_code }}</span>
            </p>

            <table class="info">
                <tr>
                    <td class="lbl">Customer</td>
                    <td><div class="val">{{ $so->customer?->customer_nama ?? '-' }}</div></td>
                    <td class="lbl">Tanggal</td>
                    <td><div class="val">{{ $so->so_tanggal->format('d F Y') }}</div></td>
                </tr>
                <tr>
                    <td class="lbl">Alamat</td>
                    <td colspan="3"><div class="val alt">{{ $so->customer?->customer_alamat ?? '-' }}</div></td>
                </tr>
                <tr>
                    <td class="lbl">Status</td>
                    <td><div class="val">{{ $so->so_status }}</div></td>
                    <td class="lbl">Keterangan</td>
                    <td><div class="val alt">{{ $so->so_keterangan ?? '-' }}</div></td>
                </tr>
            </table>

            <table class="data">
                <thead>
                    <tr>
                        <th style="width:5%">No</th>
                        <th style="width:14%">Kode</th>
                        <th>Nama Alat / Jasa</th>
                        <th style="width:8%" class="num">Qty</th>
                        <th style="width:15%" class="num">Harga Satuan</th>
                        <th style="width:15%" class="num">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($so->details as $i => $detail)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $detail->so_detail_code }}</td>
                            <td>{{ $detail->product?->product_nama ?? '-' }}</td>
                            <td class="num">{{ $detail->so_detail_qty }}</td>
                            <td class="num">{{ number_format((float) $detail->so_detail_harga, 0, ',', '.') }}</td>
                            <td class="num">{{ number_format((int) $detail->so_detail_qty * (float) $detail->so_detail_harga, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">Total Item: {{ $so->details->count() }} &nbsp;|&nbsp; Total Qty: {{ $so->details->sum('so_detail_qty') }}</td>
                        <td></td>
                        <td class="num">{{ number_format($so->so_subtotal, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>

            <div class="totals-block">
                <table>
                    <tr><td class="k">Subtotal</td><td class="num">Rp {{ number_format($so->so_subtotal, 0, ',', '.') }}</td></tr>
                    @if ((float) $so->so_discount > 0)
                        <tr><td class="k">Discount{{ $so->so_discount_note ? ' ('.$so->so_discount_note.')' : '' }}</td><td class="num">- Rp {{ number_format((float) $so->so_discount, 0, ',', '.') }}</td></tr>
                    @endif
                    <tr><td class="k">DPP</td><td class="num">Rp {{ number_format($so->so_dpp, 0, ',', '.') }}</td></tr>
                    @if ($so->so_ppn_amount > 0)
                        <tr><td class="k">PPN ({{ $so->so_ppn_rate }}%)</td><td class="num">Rp {{ number_format($so->so_ppn_amount, 0, ',', '.') }}</td></tr>
                    @endif
                    @if ($so->so_pph_amount > 0)
                        <tr><td class="k">PPH ({{ $so->so_pph_rate }}%)</td><td class="num">Rp {{ number_format($so->so_pph_amount, 0, ',', '.') }}</td></tr>
                    @endif
                    <tr class="grand"><td>Grand Total</td><td class="num">Rp {{ number_format($so->so_grand_total, 0, ',', '.') }}</td></tr>
                </table>
            </div>

            @if ($so->so_keterangan)
                <div class="notes">
                    <h4>Catatan / Keterangan</h4>
                    <p>{{ $so->so_keterangan }}</p>
                </div>
            @endif

            <table class="sign">
                <tr>
                    <td>
                        <p class="role">Dibuat Oleh</p>
                        <div class="gap"></div>
                        <span class="line">{{ config('company.director') }}</span>
                        <p class="ti">{{ config('company.director_title') }}</p>
                    </td>
                    <td>
                        <p class="role">Diterima Oleh</p>
                        <div class="gap"></div>
                        <span class="line">(....................................................)</span>
                        <p class="ti">Customer</p>
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
