<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tags\CreateTagRequest;
use App\Http\Requests\Tags\UpdateTagRequest;
use App\Models\Tag;
use App\Repository\Eloquent\TagRepository\TagInterface\TagInterface;
use Illuminate\Http\Request;
use App\Traits\WebResponser;
use App\Repository\Eloquent\WebRepository\WebInterface\WebInterface;

class TagController extends Controller
{
    use WebResponser;

    public $webRepo;
    public $tagRepo;
    public function __construct(WebInterface $webRepo, TagInterface $tagRepo)
    {
        $this->webRepo = $webRepo;
        $this->tagRepo = $tagRepo;
        $this->model = Tag::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = $this->tagRepo->allTagsWithPost($this->model);
        return $this->showView("tags.index", compact("tags"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->showView("tags.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTagRequest $request)
    {
        $data = [
            "name" => $request->name
        ];

        $tag = $this->webRepo->create($this->model, $data);
        if($tag){
            $this->flashMessage("info", "Tag Created Successfully");
            return $this->
            redirectToRoute("tags.index");
        }
        abort(500, "An error occured while trying to create Tag, Please try again");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag = $this->webRepo->find($this->model, $id);
        if($tag){
            return $this->showView("tags.edit", compact("tag"));
        }
        abort(404, "Tag do not exist in our record");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTagRequest $request, $id)
    {
        $tag = $this->webRepo->find($this->model, $id);

        if($tag){
            $tag->name = $request->name;
            if($tag->isDirty()){
                $updateTag = $this->webRepo->update($tag);
                if($updateTag){
                    $this->flashMessage("info", 'Tag updated successfully');
                    return $this->redirectToRoute("tags.index");
                }
                else{
                    $this->flashMessage("info", 'Tag could not be updated');
                    return $this->redirectBack();
                }
            }
            else
            {
                $this->flashMessage("info", 'You need to make changes to tag to update');
                return $this->redirectBack();
            }
        }
        abort(404, 'Category could not be found');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = $this->webRepo->find($this->model, $id);
        if($tag){
            $deleteTag = $this->webRepo->delete($tag);
            $this->tagRepo->detachTagPost($tag);
            if($deleteTag){
                $this->flashMessage("info", "Tag deleted successfully");
                return $this->redirectToRoute("tags.index");
            }
            $this->flashMessage("info", "An error occured while deleting user");
            return $this->redirectBack();
        }
        abort(404, "Tag could not be found in our record");
    }
}
