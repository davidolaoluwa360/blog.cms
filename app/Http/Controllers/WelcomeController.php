<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Traits\WebResponser;
use Illuminate\Http\Request;
use App\Repository\Eloquent\WebRepository\WebInterface\WebInterface;

class WelcomeController extends Controller
{
    use WebResponser;

    public $webRepo;
    public function __construct(WebInterface $webRepo)
    {
        $this->webRepo = $webRepo;
        $this->model = Post::class;
    }

    public function index(Request $request){
        $categories = $this->webRepo->all(Category::class);
        $tags = $this->webRepo->all(Tag::class);
        if($request->has("search")){
            $posts = $this->webRepo->search($this->model, "title", $request->query("search"), true, "simplePaginate", 2);
        }
        else{
            $posts = $this->webRepo->simplePaginate($this->model, 2);
        }

        return $this->showView("welcome", compact("posts", "categories", "tags"));
    }
}
