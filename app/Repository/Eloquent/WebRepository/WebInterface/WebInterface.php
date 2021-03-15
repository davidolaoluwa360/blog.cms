<?php
namespace App\Repository\Eloquent\WebRepository\WebInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface WebInterface{
    public function all($model) : ? Collection;

    public function paginate($model, $page_num = 5);

    public function simplePaginate($model, $page_num = 5);

    public function where($model, $query, $queryData);

    public function search($model, $query, $queryData, $hasPaginate = false, $paginateType=true, $page_num=5);

    public function find($model, int $id) : ? Model;

    public function create($model, array $data) : ? Model;

    public function withTrashed($model) : Collection;

    public function findTrashed($model, int $id) : ? Model;

    public function restoreTrashed($model);

    public function permanentDelete($model);

    public function getCurrentUser();

    public function onlyTrashed($model) : Collection;

    public function save($model);

    public function update($model);

    public function delete($model);

    public function paginateMethod($model, $page_num = 5);

    public function simplePaginateMethod($model, $page_num = 5);
}
