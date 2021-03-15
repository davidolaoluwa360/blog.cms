<?php
namespace App\Repository\Eloquent\CategoryRepository;

use App\Repository\Eloquent\CategoryRepository\CategoryInterface\CategoryInterface;

class CategoryRepository implements CategoryInterface{
    public function detachCategoryPost($model){
        $category = $model->posts()->detach();
        return $category;
    }

    public function allCategoryWithPost($model){
        $post = $model::with("posts")->get();
        return $post;
    }
}
