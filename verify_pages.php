<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;

$user = User::first();
$user->role = 'admin';
$user->save();

$request = Request::create('/wms/jasa/table', 'GET');
$request->setUserResolver(fn () => $user);
$request->setLaravelSession(app('session')->driver());
$app->make(Router::class)->setRoutes(app('router')->getRoutes());

$kernel = app(Illuminate\Contracts\Http\Kernel::class);

$routes = ['/wms/jasa/table', '/wms/jasa/create', '/wms/product/create', '/wms/so/create', '/wms/so/table'];
foreach ($routes as $path) {
    try {
        $response = $kernel->handle($req = Request::create($path, 'GET'));
        $status = $response->getStatusCode();
        $html = $response->getContent();
        echo "{$path} => {$status}";
        if (str_contains($html, 'Whoops') || str_contains($html, 'exception')) {
            echo ' [ERROR CONTENT]';
        } else {
            echo ' [len '.strlen($html).']';
        }
        echo PHP_EOL;
    } catch (Throwable $e) {
        echo "{$path} => EXCEPTION: ".$e->getMessage().PHP_EOL;
    }
}
