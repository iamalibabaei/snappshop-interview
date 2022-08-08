<?php

namespace App\Http\Repository;

use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    public Model $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
