<?php


namespace App\Services\Repositories;

interface RepositoryInterface
{

    public function setModel($modelName);

    public function find(int $id);

    public function list();

    public function paginateList($qty);

    public function paginateListApi(int $limit, int $offset);

}
