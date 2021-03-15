<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Repository\Eloquent\WebRepository\WebInterface\WebInterface;
use App\Traits\WebResponser;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use WebResponser;

    public $webRepo;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(WebInterface $webRepo)
    {
        $this->middleware('auth');
        $this->webRepo = $webRepo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = $this->webRepo->all(Category::class);
        $posts = $this->webRepo->all(Post::class);
        $tags = $this->webRepo->all(Tag::class);

        return $this->showView('home', compact("categories", "posts", "tags"));
    }
}
