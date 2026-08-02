<?php

namespace App\Http\Controllers\Wms;

use App\Concerns\ControllerTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\GeneralRequest;
use App\Models\SoDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PekerjaanController extends Controller
{
    use ControllerTrait;

    public function __construct(SoDetail $model)
    {
        $this->model = $model::getModel();
    }

    protected function template($file = null, $folder = null, $core = false)
    {
        return 'pages.pekerjaan.'.($file ?: 'table');
    }

    /** Lines belonging to SOs where the current user is an assigned petugas. */
    public function getTable(GeneralRequest $request)
    {
        $userId = (int) Auth::id();

        $data = SoDetail::query()
            ->with(['product', 'so.customer', 'teknisi'])
            ->whereHas('so.petugas', fn ($q) => $q->where('users.id', $userId))
            ->orderByRaw("CASE so_detail_kerja_status WHEN 'Tersedia' THEN 0 WHEN 'Diambil' THEN 1 ELSE 2 END")
            ->orderBy('so_detail_id')
            ->cursorPaginate($request->input('per_page', 25))
            ->withQueryString();

        return view('pages.pekerjaan.table', [
            'data' => $data,
            'model' => $this->model,
            'userId' => $userId,
        ]);
    }

    /** Claim a line — only if free and the user is an assigned petugas of the SO. */
    public function getAmbil(GeneralRequest $request, $id)
    {
        try {
            DB::transaction(function () use ($id) {
                $detail = SoDetail::with('so.petugas')->lockForUpdate()->findOrFail($id);
                $userId = (int) Auth::id();

                if (! $detail->so->petugas->contains('id', $userId)) {
                    throw new \RuntimeException('Anda bukan petugas pada Sales Order ini.');
                }

                if ($detail->so_detail_kerja_status !== SoDetail::KERJA_TERSEDIA || $detail->so_detail_id_teknisi) {
                    throw new \RuntimeException('Pekerjaan sudah diambil teknisi lain.');
                }

                $detail->update([
                    'so_detail_id_teknisi' => $userId,
                    'so_detail_kerja_status' => SoDetail::KERJA_DIAMBIL,
                    'so_detail_kerja_ambil_at' => now(),
                ]);
            });

            return redirect()->route('wms-pekerjaan.getLembar', ['id' => $id]);
        } catch (\Throwable $th) {
            return redirect()->route('wms-pekerjaan.getTable')->with('error', $th->getMessage());
        }
    }

    public function getLembar(GeneralRequest $request, $id)
    {
        $detail = SoDetail::with(['product', 'so.customer', 'teknisi'])->findOrFail($id);
        $this->authorizeTeknisi($detail);

        return view('pages.pekerjaan.lembar', ['model' => $detail]);
    }

    public function postLembar(GeneralRequest $request, $id)
    {
        $detail = SoDetail::with('so')->findOrFail($id);
        $this->authorizeTeknisi($detail);

        $validated = $request->validate([
            'lembar' => ['nullable', 'array'],
            'selesai' => ['nullable', 'boolean'],
        ]);

        $update = ['so_detail_lembar' => $validated['lembar'] ?? []];

        if ($request->boolean('selesai')) {
            $update['so_detail_kerja_status'] = SoDetail::KERJA_SELESAI;
            $update['so_detail_kerja_selesai_at'] = now();
            if (! $detail->so_detail_sertifikat_no) {
                $update['so_detail_sertifikat_no'] = 'BA-'.$detail->so->so_code.'-'.str_pad((string) $detail->so_detail_id, 4, '0', STR_PAD_LEFT);
            }
        }

        $detail->update($update);

        return redirect()->route('wms-pekerjaan.getLembar', ['id' => $id])->with('success', 'Lembar kerja tersimpan.');
    }

    public function getBeritaAcara(GeneralRequest $request, $id)
    {
        $detail = SoDetail::with(['product', 'so.customer', 'teknisi'])->findOrFail($id);

        $pdf = Pdf::loadView('pdf.berita-acara', ['detail' => $detail]);

        return $pdf->stream('BeritaAcara-'.$detail->so_detail_code.'.pdf');
    }

    public function getSertifikat(GeneralRequest $request, $id)
    {
        $detail = SoDetail::with(['product', 'so.customer', 'teknisi'])->findOrFail($id);

        $pdf = Pdf::loadView('pdf.sertifikat', ['detail' => $detail])->setPaper('a4', 'portrait');

        return $pdf->stream('Sertifikat-'.$detail->so_detail_code.'.pdf');
    }

    private function authorizeTeknisi(SoDetail $detail): void
    {
        abort_unless((int) $detail->so_detail_id_teknisi === (int) Auth::id(), 403, 'Bukan pekerjaan Anda.');
    }
}
