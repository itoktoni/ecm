<?php

namespace App\Http\Controllers\Wms;

use App\Concerns\ControllerTrait;
use App\Http\Controllers\Controller;
use App\Models\Jasa;

class JasaController extends Controller
{
    use ControllerTrait;

    public function __construct(Jasa $model)
    {
        $this->model = $model::getModel();
    }

    protected function getData()
    {
        return $this->model->withCount('products')->filter()->sort();
    }
}
