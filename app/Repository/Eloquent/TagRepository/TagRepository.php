<?php
namespace App\Repository\Eloquent\TagRepository;

use App\Repository\Eloquent\TagRepository\TagInterface\TagInterface;

class TagRepository implements TagInterface{
    public function detachTagPost($model){
        $model = $model->posts()->detach();
    }

    public function allTagsWithPost($model){
        $post = $model::with("posts")->get();
        return $post;
    }
}
