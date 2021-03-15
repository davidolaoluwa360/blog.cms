<?php
namespace App\Repository\Eloquent\TagRepository\TagInterface;

interface TagInterface{
    public function detachTagPost($model);
    public function allTagsWithPost($model);
}
