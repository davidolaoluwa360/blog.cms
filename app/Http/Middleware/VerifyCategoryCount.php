<?php

namespace App\Http\Middleware;

use App\Models\Category;
use Closure;
use Illuminate\Http\Request;
use App\Traits\WebResponser;

class VerifyCategoryCount
{
    use WebResponser;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $category = Category::all();
        if($category->count() > 0){
            return $next($request);
        }
        else{
            session()->flash("info", "You need Category to create a post");
            return $this->redirectToRoute("categories.create");
        }
    }
}
