<?php
namespace App\Repository\Eloquent\WebRepository;

use App\Repository\Eloquent\WebRepository\WebInterface\WebInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class WebRepository implements WebInterface{
    public function all($model) : ? Collection{
        $model = $model::all();
        return $model;
    }

    public function paginate($model, $page_num = 5){
        $model = $model::paginate($page_num);
        return $model;
    }

    public function simplePaginate($model, $page_num = 5){
        $model = $model::simplePaginate($page_num);
        return $model;
    }

    public function paginateMethod($model, $page_num = 5){
        $model = $model->paginate($page_num);
        return $model;
    }

    public function simplePaginateMethod($model, $page_num = 5){
        $model = $model->simplePaginate($page_num);
        return $model;
    }

    public function withTrashed($model) : Collection{
        $model = $model::withTrashed()->get();
        return $model;
    }

    public function onlyTrashed($model) : Collection{
        $model = $model::onlyTrashed()->get();
        return $model;
    }

    public function find($model, int $id) : ? Model{
        $model = $model::where("id", $id)->firstOrFail();
        return $model;
    }

    public function findTrashed($model, int $id) : ? Model{
        $model = $model::onlyTrashed()->where("id", $id)->firstOrFail();
        return $model;
    }

    public function where($model, $query, $queryData){
        $model = $model::where($query,$queryData)->get();
        return $model;
    }

    public function search($model, $query, $queryData, $hasPaginate = false, $paginateType=true, $page_num=5){
        $model = $model::where($query, "LIKE", "%{$queryData}%");
        if($hasPaginate){
            if($paginateType == "simplePaginate"){
                $model = $this->simplePaginateMethod($model, $page_num);
            }
            else{
                $model = $this->paginateMethod($model, $page_num);
            }
        }
        return $model;
    }

    public function restoreTrashed($model){
        $model = $model->restore();
        return $model;
    }

    public function permanentDelete($model){
        $model = $model->forceDelete();
        return $model;
    }

    public function delete($model){
        $model = $model->delete();
        return $model;
    }

    public function create($model, array $data) : ? Model{
        $model = $model::create($data);
        return $model;
    }

    public function getCurrentUser(){
        $user = Auth::user();
        return $user;
    }

    public function update($model){
        $model = $this->save($model);
        return $model;
    }

    public function save($model){
        $model = $model->save();
        return $model;
    }
}
