<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Content;
use App\Models\Order;
use App\Models\Section;
use App\Models\SoDetail;
use App\Models\Tag;
use App\Models\Type;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();

        if ($user && in_array($user->role, ['admin', 'developer'])) {
            return $this->admin();
        }

        if ($user && $user->role === 'teknisi') {
            return $this->teknisi();
        }

        return $this->cms();
    }

    /**
     * Dashboard admin / developer — fokus pada Order Masuk.
     */
    protected function admin()
    {
        $statusCounts = Order::query()
            ->selectRaw('order_status, COUNT(*) as c')
            ->groupBy('order_status')
            ->pluck('c', 'order_status');

        $totalOrders = Order::count();
        $pending = (int) ($statusCounts['pending'] ?? 0);
        $completed = (int) ($statusCounts['completed'] ?? 0);
        $revenue = (float) Order::sum('order_total');
        $recentOrders = Order::query()
            ->with('details', 'so')
            ->orderByDesc('order_id')
            ->limit(8)
            ->get();

        return view('dashboard-admin', compact(
            'statusCounts', 'totalOrders', 'pending', 'completed', 'revenue', 'recentOrders'
        ));
    }

    /**
     * Dashboard teknisi — fokus pada banyaknya alat yang dikerjakan.
     */
    protected function teknisi()
    {
        $me = (int) auth()->id();

        $totalTaken = SoDetail::where('so_detail_id_teknisi', $me)->count();
        $diambil = SoDetail::where('so_detail_id_teknisi', $me)
            ->where('so_detail_kerja_status', 'Diambil')
            ->count();
        $selesai = SoDetail::where('so_detail_id_teknisi', $me)
            ->where('so_detail_kerja_status', 'Selesai')
            ->count();
        $tersedia = SoDetail::where('so_detail_kerja_status', 'Tersedia')->count();

        $pekerjaan = SoDetail::query()
            ->with('so', 'product')
            ->where('so_detail_id_teknisi', $me)
            ->orderByDesc('updated_at')
            ->limit(10)
            ->get();

        return view('dashboard-teknisi', compact('totalTaken', 'diambil', 'selesai', 'tersedia', 'pekerjaan'));
    }

    /**
     * Dashboard default (CMS portal).
     */
    protected function cms()
    {
        $stats = [
            'total_content' => Content::count(),
            'total_sections' => Section::count(),
            'total_categories' => Category::count(),
            'total_tags' => Tag::count(),
        ];

        $cmsTypes = Type::withCount('contents')->latest()->limit(2)->get();

        $recentContents = Content::latest('updated_at')
            ->limit(5)
            ->get()
            ->map(fn ($content) => [
                'icon' => match ($content->status) {
                    'published' => 'check_circle',
                    default => 'edit_note',
                },
                'iconBg' => match ($content->status) {
                    'published' => 'bg-green-50',
                    default => 'bg-primary/5',
                },
                'iconColor' => match ($content->status) {
                    'published' => 'text-green-600',
                    default => 'text-primary',
                },
                'title' => $content->title,
                'subtitle' => $content->type?->name ?? 'Draft',
                'status' => strtoupper($content->status),
                'statusClass' => match ($content->status) {
                    'published' => 'bg-green-50 text-green-700',
                    default => 'bg-surface-container-high text-on-surface-variant',
                },
                'time' => $content->updated_at?->diffForHumans() ?? '',
            ]);

        return view('dashboard', compact('stats', 'cmsTypes', 'recentContents'));
    }
}

