<?php

use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Cms\ContentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImageScannerController;
use App\Http\Controllers\PublicController;
use App\Models\Notification;
use App\Services\CentrifugoService;
use Buki\AutoRoute\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/api/content/{slug?}', [PublicController::class, 'api'])->name('api.content');

Route::middleware('auth')->post('/centrifugo/token', function (Request $request) {
    if (! config('langkahkecil.notification_enable')) {
        return response()->json(['token' => 'disabled']);
    }

    $centrifugo = app(CentrifugoService::class);
    $user = Auth::user();

    if ($request->input('channel')) {
        return response()->json([
            'token' => $centrifugo->generateSubscriptionToken((string) $user->id, $request->input('channel')),
        ]);
    }

    return response()->json([
        'token' => $centrifugo->generateConnectionToken((string) $user->id),
    ]);
});
Route::middleware(['auth', 'verified', 'access'])->group(function () {

    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::get('image-scanner', ImageScannerController::class)->name('image-scanner');
    Route::get('image-scanner/photo/{path}', ImageScannerController::class)->name('image-scanner.photo')->where('path', '.*');

    Route::auto('/user', 'UsersController', ['name' => 'user']);

    // WMS Master Data
    Route::auto('/wms/gudang', 'Wms\GudangController', ['name' => 'wms-gudang']);
    Route::auto('/wms/supplier', 'SupplierController', ['name' => 'wms-supplier']);
    Route::auto('/wms/customer', 'CustomerController', ['name' => 'wms-customer']);
    Route::auto('/wms/lokasi', 'Wms\LokasiController', ['name' => 'wms-lokasi']);
    Route::auto('/wms/jasa', 'Wms\JasaController', ['name' => 'wms-jasa']);
    Route::auto('/wms/product', 'Wms\ProductController', ['name' => 'wms-product']);

    // WMS Inventory
    Route::auto('/wms/stock', 'Wms\StockController', ['name' => 'wms-stock']);

    // WMS Procurement
    Route::auto('/wms/po', 'Wms\PoController', ['name' => 'wms-po']);
    Route::auto('/wms/po-detail', 'Wms\PoDetailController', ['name' => 'wms-po-detail']);

    // WMS Sales
    Route::auto('/wms/so', 'Wms\SoController', ['name' => 'wms-so']);

    // WMS Inbound
    Route::auto('/wms/masuk-detail', 'Wms\MasukDetailController', ['name' => 'wms-masuk-detail']);
    Route::auto('/wms/masuk-realisasi', 'Wms\MasukRealisasiController', ['name' => 'wms-masuk-realisasi']);

    // WMS Outbound
    Route::auto('/wms/keluar', 'Wms\KeluarController', ['name' => 'wms-keluar']);
    Route::auto('/wms/keluar-detail', 'Wms\KeluarDetailController', ['name' => 'wms-keluar-detail']);
    Route::auto('/wms/keluar-realisasi', 'Wms\KeluarRealisasiController', ['name' => 'wms-keluar-realisasi']);

    // WMS Split
    Route::auto('/wms/split', 'Wms\SplitController', ['name' => 'wms-split']);

    // CMS Routes
    Route::auto('/cms/type', 'Cms\TypeController', ['name' => 'cms-type']);
    Route::auto('/cms/field', 'Cms\FieldController', ['name' => 'field']);
    Route::auto('/cms/section', 'Cms\SectionController', ['name' => 'section']);
    Route::auto('/cms/content', 'Cms\ContentController', ['name' => 'content']);
    Route::auto('/cms/category', 'Cms\CategoryController', ['name' => 'category']);
    Route::auto('/cms/tag', 'Cms\TagController', ['name' => 'tag']);
    Route::auto('/cms/menu', 'Cms\MenuController', ['name' => 'menu']);

    // Section HTML API (AJAX section loading)
    Route::get('/cms/content-entry/field-group-html/{id}', [ContentController::class, 'getSectionHtml'])->name('cms.section.html');

    // Media API Routes
    Route::prefix('api/media')->group(function () {
        Route::get('/', [MediaController::class, 'index']);
        Route::post('/upload', [MediaController::class, 'upload']);
        Route::delete('/{media}', [MediaController::class, 'destroy']);
    });

    Route::prefix('notifications-web')->group(function () {
        Route::get('/', function (Request $request) {
            $notifications = Notification::where('user_id', Auth::id())
                ->orderByDesc('created_at')
                ->limit($request->input('limit', 50))
                ->get();

            $unreadCount = Notification::where('user_id', Auth::id())
                ->where('read', false)
                ->count();

            return response()->json([
                'notifications' => $notifications->map(fn ($n) => [
                    'id' => $n->id,
                    'icon' => $n->icon,
                    'iconColor' => $n->icon_color,
                    'title' => $n->title,
                    'body' => $n->body,
                    'url' => $n->url,
                    'type' => $n->type,
                    'read' => $n->read,
                    'time' => $n->created_at?->diffForHumans() ?? '',
                    'created_at' => $n->created_at->toIso8601String(),
                ]),
                'unread_count' => $unreadCount,
            ]);
        });

        Route::put('/{id}/read', function (int $id) {
            $notification = Notification::where('user_id', Auth::id())->findOrFail($id);
            $notification->update(['read' => true]);

            return response()->json(['message' => 'Marked as read']);
        });

        Route::put('/read-all', function () {
            Notification::where('user_id', Auth::id())
                ->where('read', false)
                ->update(['read' => true]);

            return response()->json(['message' => 'All marked as read']);
        });
    });
});

// Frontend public routes (must be before catch-all /{slug})
Route::get('/services', [PublicController::class, 'services'])->name('services');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');
Route::get('/blog', [PublicController::class, 'blog'])->name('blog');
Route::get('/blog/category/{slug}', [PublicController::class, 'category'])->name('blog.category');
Route::get('/blog/tag/{slug}', [PublicController::class, 'tag'])->name('blog.tag');
Route::get('/blog/{slug}', [PublicController::class, 'post'])->name('blog.post');
Route::get('/search', [PublicController::class, 'search'])->name('search');

// Documentation routes (photo gallery with categories and tags)
Route::get('/documentation', [PublicController::class, 'documentation'])->name('documentation');
Route::get('/documentation/category/{slug}', [PublicController::class, 'documentationCategory'])->name('documentation.category');
Route::get('/documentation/tag/{slug}', [PublicController::class, 'documentationTag'])->name('documentation.tag');
Route::get('/documentation/{slug}', [PublicController::class, 'documentationShow'])->name('documentation.show');

Route::get('/{slug}', [PublicController::class, 'page'])->name('page');
require __DIR__.'/settings.php';
