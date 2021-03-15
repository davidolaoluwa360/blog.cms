<?php

namespace App\Http\Controllers;

use App\Http\Requests\Posts\CreatePostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Repository\Eloquent\PostRepository\PostInterface\PostInterface;
use Illuminate\Http\Request;
use App\Traits\WebResponser;
use App\Repository\Eloquent\WebRepository\WebInterface\WebInterface;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    use WebResponser;
    public $webRepo;
    public $postRepo;

    public function __construct(WebInterface $webRepo, PostInterface $postRepo)
    {
        $this->webRepo = $webRepo;
        $this->postRepo = $postRepo;
        $this->model = Post::class;
        $this->middleware(["verifyCategoryCount", "verifyTagCount"], [
            "only" => ["create", "store"]
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->webRepo->all($this->model);
        return $this->showView("posts.index", compact("posts"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories =  $this->webRepo->all(Category::class);
        $tags = $this->webRepo->all(Tag::class);
        return $this->showView("posts.create", compact("categories", "tags"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    {
        $post = new $this->model();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->content = $request->content;

        $image = $request->file("image");
        $image = $image->store("posts");
        $post->image = $image;

        if($request->has("published_at")){
            $post->published_at = $request->published_at;
        }

        $user = $this->webRepo->getCurrentUser();
        $post = $this->postRepo->userPost($user, $post);
        $this->postRepo->attachCategoryPost($post, isset($request->category) ? $request->category : []);
        $this->postRepo->attachTagPost($post, isset($request->tag) ? $request->tag : []);

        if($post){
            $this->flashMessage("info", "Post successfully created");
            return $this->redirectToRoute("posts.index");
        }
        abort(500, "An error occured while trying to create Post");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = $this->webRepo->find($this->model, $id);
        if($post){
            return $this->showView("posts.show",compact("post"));
        }
        abort(404, "Post do not exist in our record");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = $this->webRepo->find($this->model, $id);
        $tags = $this->webRepo->all(Tag::class);
        $post_category_id = $post->categories->pluck("pivot")[0]["category_id"];
        $categories =  $this->webRepo->all(Category::class);
        if($post){
            return $this->showView("posts.edit", compact("post", "categories", "post_category_id", "tags"));
        }
        abort(404, "Post do not exist in our record");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, $id)
    {
        $post = $this->webRepo->find($this->model, $id);
        if($post){
            $post->title = $request->title;
            $post->description = $request->description;
            $post->content = $request->content;

            if($request->has("published_at")){
                $post->published_at = $request->published_at;
            }

            if($request->hasFile("image")){
                $this->model::deleteImage($post->image);
                $post->image = $request->image->store("posts");
            }

            if(!$post->isDirty() && (!$request->has("category") || !$request->has("tag"))){
                $this->flashMessage("info","You need to make changes to the post field to update");
                return $this->redirectBack();
            }
            $updatePost = $this->webRepo->update($post);
            $this->postRepo->syncCategoryPost($post, isset($request->category) ? $request->category : []);
            $this->postRepo->syncTagPost($post, isset($request->tag) ? $request->tag : []);
            if($updatePost){
                $this->flashMessage("info", "Post sucessfully updated");
                return $this->redirectToRoute("posts.index");
            }
            $this->flashMessage("info", "An error occured while trying to update post, please try again!");
            return $this->redirectBack();
        }
        abort(404, "post do not exist in our record");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = $this->webRepo->find($this->model, $id);
        if($post){
            $post = $this->webRepo->delete($post);
            if($post){
                $this->flashMessage("info", "Post successfully trashed");
                return $this->redirectBack();
            }
            $this->flashMessage("info", "An error occured while trying to trash post");
            return $this->redirectBack();
        }
        abort(404, "Post do not exist in our record");
    }

     /**
     * Retrieve all trashed posts
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
       $trashed = $this->webRepo->onlyTrashed($this->model);
       return $this->showView("posts.trashed", compact("trashed"));
    }

    /**
     * Retrieve all trashed posts
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
       $trashed = $this->webRepo->findTrashed($this->model, $id);
       if($trashed){
            $trashed = $this->webRepo->restoreTrashed($trashed);
            if($trashed){
                $this->flashMessage("info", "Post successfully restored");
                return $this->redirectBack();
            }
            $this->flashMessage("info", "An error occured while trying to restore Post");
            return $this->redirectBack();
       }
       abort(404, "Trashed Post could not be find in our record");
    }

    public function permanentDelete($id){
       $trashed = $this->webRepo->findTrashed($this->model, $id);
       if($trashed){
           $this->model::deleteImage($trashed->image);
            $trash = $this->webRepo->permanentDelete($trashed);
            $this->postRepo->detachCategoryPost($trashed);
            $this->postRepo->detachTagPost($trashed);
            if($trash){
                $this->flashMessage("info", "Post successfully deleted");
                return $this->redirectBack();
            }
            $this->flashMessage("info", "An error occured while trying to delete Post");
            return $this->redirectBack();
       }
       abort(404, "Trashed Post could not be find in our record");
    }
}
