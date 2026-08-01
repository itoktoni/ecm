<?php /** @var App\Models\So $so */ ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>SO {{ $so->so_code }}</title>
    <style>
        * { font-family: DejaVu Sans, sans-serif; box-sizing: border-box; }
        body { margin: 0; padding: 0; color: #1a1c1e; font-size: 12px; }
        .page { padding: 24px; }

        .header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 3px solid #1a1c1e; padding-bottom: 16px; margin-bottom: 20px; }
        .company-info h1 { margin: 0 0 6px 0; font-size: 20px; letter-spacing: 1px; }
        .company-info p { margin: 0; font-size: 11px; color: #555; line-height: 1.6; }
        .so-badge { text-align: right; }
        .so-badge h2 { margin: 0 0 6px 0; font-size: 22px; letter-spacing: 3px; }
        .so-badge p { margin: 0; font-size: 12px; }

        .info-grid { display: flex; gap: 16px; margin-bottom: 20px; }
        .info-box { flex: 1; border: 1px solid #ddd; border-radius: 6px; padding: 12px 16px; }
        .info-box h3 { margin: 0 0 8px 0; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: #333; border-bottom: 1px solid #eee; padding-bottom: 6px; }
        .info-box p { margin: 3px 0; font-size: 12px; line-height: 1.5; }
        .info-box .label { color: #777; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
        table th, table td { border: 1px solid #ccc; padding: 7px 9px; text-align: left; font-size: 11px; }
        table thead th { background: #f0f2f5; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; }
        .num { text-align: right; }
        table tfoot td { font-weight: bold; background: #f7f8fa; }

        .totals-block { width: 42%; margin-left: auto; margin-top: 8px; }
        .totals-block table { margin: 0; }
        .totals-block td { border: none; border-bottom: 1px solid #eee; padding: 5px 9px; font-size: 11px; }
        .totals-block td.num { width: 45%; }
        .totals-block tr.grand td { border-top: 2px solid #1a1c1e; border-bottom: none; font-size: 14px; font-weight: bold; }

        .notes { margin-top: 16px; border: 1px solid #ddd; border-radius: 6px; padding: 12px 16px; }
        .notes h4 { margin: 0 0 6px 0; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: #333; }
        .notes p { margin: 0; font-size: 11px; line-height: 1.6; }

        .signatures { width: 100%; margin-top: 44px; }
        .signatures table { width: 100%; }
        .signatures td { width: 50%; text-align: center; font-size: 11px; vertical-align: top; padding: 0; border: none; }
        .signatures .line { height: 1px; background: #333; margin: 0 20px 10px 20px; }
        .signatures .name { font-weight: bold; margin: 0; }
        .signatures .role { color: #666; margin: 2px 0 0 0; }

        .footer { margin-top: 24px; text-align: center; font-size: 10px; color: #888; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="page">
        <div class="header">
            <div class="company-info">
                <h1>{{ strtoupper(config('company.name')) }}</h1>
                <p>
                    {{ config('company.address') }}<br>
                    {{ config('company.area') }}<br>
                    Telp: {{ config('company.telp') }}{{ config('company.fax') ? ' | Fax: '.config('company.fax') : '' }}<br>
                    Email: {{ config('company.email') }}
                </p>
            </div>
            <div class="so-badge">
                <h2>SALES ORDER</h2>
                <p>No: <strong>{{ $so->so_code }}</strong></p>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-box">
                <h3>Customer</h3>
                <p>{{ $so->customer?->customer_nama ?? '-' }}</p>
                @if ($so->customer?->customer_telepon)
                    <p style="font-size:11px; color:#666; margin-top:2px;">Telp: {{ $so->customer->customer_telepon }}</p>
                @endif
                @if ($so->customer?->customer_alamat)
                    <p style="font-size:11px; color:#666;">{{ $so->customer->customer_alamat }}</p>
                @endif
            </div>
            <div class="info-box">
                <h3>Detail Order</h3>
                <p><span class="label">Tanggal:</span> {{ $so->so_tanggal->format('d F Y') }}</p>
                <p><span class="label">Status:</span> {{ $so->so_status }}</p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width:5%">No</th>
                    <th style="width:14%">Kode Item</th>
                    <th>Nama Product</th>
                    <th style="width:9%" class="num">Qty</th>
                    <th style="width:16%" class="num">Harga Satuan</th>
                    <th style="width:16%" class="num">Subtotal</th>
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
                <tr>
                    <td>Subtotal</td>
                    <td class="num">Rp {{ number_format($so->so_subtotal, 0, ',', '.') }}</td>
                </tr>
                @if ((float) $so->so_discount > 0)
                    <tr>
                        <td>Discount{{ $so->so_discount_note ? ' ('.$so->so_discount_note.')' : '' }}</td>
                        <td class="num">- Rp {{ number_format((float) $so->so_discount, 0, ',', '.') }}</td>
                    </tr>
                @endif
                <tr>
                    <td>DPP</td>
                    <td class="num">Rp {{ number_format($so->so_dpp, 0, ',', '.') }}</td>
                </tr>
                @if ($so->so_ppn_amount > 0)
                    <tr>
                        <td>PPN ({{ $so->so_ppn_rate }}%)</td>
                        <td class="num">Rp {{ number_format($so->so_ppn_amount, 0, ',', '.') }}</td>
                    </tr>
                @endif
                @if ($so->so_pph_amount > 0)
                    <tr>
                        <td>PPH ({{ $so->so_pph_rate }}%)</td>
                        <td class="num">Rp {{ number_format($so->so_pph_amount, 0, ',', '.') }}</td>
                    </tr>
                @endif
                <tr class="grand">
                    <td>Grand Total</td>
                    <td class="num">Rp {{ number_format($so->so_grand_total, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        @if ($so->so_keterangan)
            <div class="notes">
                <h4>Catatan / Keterangan</h4>
                <p>{{ $so->so_keterangan }}</p>
            </div>
        @endif

        <div class="signatures">
            <table>
                <tr>
                    <td>
                        <div class="line"></div>
                        <p class="name">Dibuat Oleh</p>
                        <p class="role">Sales Staff</p>
                    </td>
                    <td>
                        <div class="line"></div>
                        <p class="name">Diterima Oleh</p>
                        <p class="role">Customer</p>
                    </td>
                </tr>
            </table>
        </div>

        <div class="footer">
            Sales Order ini merupakan dokumen pengiriman barang ke customer. Harap diverifikasi saat penerimaan.
        </div>
    </div>
</body>
</html>
