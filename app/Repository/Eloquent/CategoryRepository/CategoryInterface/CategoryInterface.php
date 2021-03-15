<?php
namespace App\Repository\Eloquent\CategoryRepository\CategoryInterface;

interface CategoryInterface{
    public function detachCategoryPost($model);
    public function allCategoryWithPost($model);
}
