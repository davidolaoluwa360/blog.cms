<?php

namespace App\Http\Middleware;

use App\Models\Tag;
use Closure;
use Illuminate\Http\Request;
use App\Traits\WebResponser;

class VerifyTagCount
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
        $tag = Tag::all();
        if($tag->count() > 0){
            return $next($request);
        }
        $this->flashMessage("info", "You need to have tags to create Posts");
        return $this->redirectToRoute("tags.create");
    }
}
