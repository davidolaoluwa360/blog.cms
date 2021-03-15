<?php
namespace App\Repository\Eloquent\PostRepository;

use App\Repository\Eloquent\PostRepository\PostInterface\PostInterface;

class PostRepository implements PostInterface{
    public function attachCategoryPost($model, $Categorykey){
        $post = $model->categories()->attach($Categorykey);
        return $post;
    }

    public function attachTagPost($model, $tagkey){
        $post = $model->tags()->attach($tagkey);
        return $post;
    }

    public function detachCategoryPost($model){
        $post = $model->categories()->detach();
        return $post;
    }

    public function detachTagPost($model){
        $post = $model->tags()->detach();
        return $post;
    }

    public function syncCategoryPost($model, $categorykey){
        $post = $model->categories()->sync($categorykey);
        return $post;
    }

    public function syncTagPost($model, $tagkey){
        $post = $model->tags()->sync($tagkey);
        return $post;
    }


    public function userPost($currentUser, $data){
        $post = $currentUser->posts()->save($data);
        return $post;
    }

    public function searchModelHasPostRelation($model, $queryName, $searchKey){
        $post = $model->posts()->where($queryName, "LIKE", "%{$searchKey}%");
        return $post;
    }
}
