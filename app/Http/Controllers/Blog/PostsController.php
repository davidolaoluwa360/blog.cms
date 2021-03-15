<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Repository\Eloquent\PostRepository\PostInterface\PostInterface;
use Illuminate\Http\Request;
use App\Repository\Eloquent\WebRepository\WebInterface\WebInterface;
use App\Traits\WebResponser;

class PostsController extends Controller
{
    use WebResponser;

    public $webRepo;
    public $postRepo;
    public function __construct(WebInterface $webRepo, PostInterface $postRepo)
    {
        $this->webRepo = $webRepo;
        $this->postRepo = $postRepo;
        $this->model = Post::class;
    }

    public function show($id){
        $post = $this->webRepo->find($this->model, $id);
        if($post){
            return $this->showView("blog.show", compact("post"));
        }
        abort(404, "Post do not exist in our record");
    }

    public function category($category){
        $category = $this->webRepo->find(Category::class, $category);
        $categories = $this->webRepo->all(Category::class);
        $tags = $this->webRepo->all(Tag::class);
        if(request()->has("search")){
            $search = request()->query("search");
            $posts = $this->postRepo->searchModelHasPostRelation($category, "title", $search);
            $posts = $this->webRepo->simplePaginateMethod($posts, 2);
        }
        else{
            $posts = $this->webRepo->simplePaginateMethod($category->posts(), 2);
        }
        if($category){
            return $this->showView('blog.category', compact("category", "tags","categories", "posts"));
        }
        abort(404, "Category do not exist in our record");
    }

    public function tag($tag){
        $tag = $this->webRepo->find(Tag::class, $tag);
        $categories = $this->webRepo->all(Category::class);
        $tags = $this->webRepo->all(Tag::class);
        if(request()->has("search")){
            $search = request()->query("search");
            $posts = $this->postRepo->searchModelHasPostRelation($tag, "title", $search);
            $posts = $this->webRepo->simplePaginateMethod($posts, 2);
        }
        else{
            $posts = $this->webRepo->simplePaginateMethod($tag->posts(), 2);
        }

        if($tag){
            return $this->showView('blog.tag', compact("tag", "categories" , "tags", "posts"));
        }
        abort(404, "Category do not exist in our record");
    }
}
