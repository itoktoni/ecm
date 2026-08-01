<?php

namespace App\Http\Controllers\Wms;

use App\Concerns\ControllerTrait;
use App\Http\Controllers\Controller;
use App\Models\Jasa;
use App\Models\Product;

class ProductController extends Controller
{
    use ControllerTrait;

    public function __construct(Product $model)
    {
        $this->model = $model::getModel();
    }

    protected function getData()
    {
        return $this->model->with('stock', 'jasa')->filter()->sort();
    }

    protected function share($data = [])
    {
        return array_merge([
            'model' => $this->model,
            'jasaOptions' => Jasa::jasaOptions(),
        ], $data);
    }
}
