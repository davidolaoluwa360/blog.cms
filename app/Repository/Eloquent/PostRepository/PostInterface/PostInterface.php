<?php
namespace App\Repository\Eloquent\PostRepository\PostInterface;

interface PostInterface{
    public function attachCategoryPost($model, $categorykey);
    public function attachTagPost($model, $tagkey);
    public function userPost($currentUser, $data);
    public function detachCategoryPost($model);
    public function detachTagPost($model);
    public function syncCategoryPost($model, $categorykey);
    public function syncTagPost($model, $tagkey);
    public function searchModelHasPostRelation($model, $queryName, $searchKey);
}
