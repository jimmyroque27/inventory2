<?php

namespace App\Repositories;

use DB;
use App\Repositories\EloquentRepository;
use App\Product;
use Carbon\Carbon;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductRepository extends EloquentRepository implements ProductRepositoryInterface
{
    protected $allowedAttributes = ['model'];

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->get();
    }


}
