<?php


namespace App\Services\Repositories;

use App\Models\Model;

class EloquentRepository implements RepositoryInterface
{
    private Model $model;

    public function setModel($modelName)
    {
        $modelName = 'App\Models\\' . $modelName;
        $this->model = new $modelName;
    }

    public function find(int $id): mixed
    {
        return $this->model::find($id);
    }

    public function list()
    {
        return $this->model->get();
    }

    public function paginateList($qty)
    {
        return $this->model->paginate($qty);
    }

    public function paginateListApi(int $limit, int $offset)
    {
        $model = $this->model::query();

        if ($limit) $model->take($limit);
        if ($offset) $model->skip($offset);

        return $model->get();
    }
}
