<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\WebResponser;
use App\Repository\Eloquent\WebRepository\WebInterface\WebInterface;
use App\Http\Requests\categories\CreateCategoryRequest;
use App\Http\Requests\Categories\UpdateCategoryRequest;
use App\Repository\Eloquent\CategoryRepository\CategoryInterface\CategoryInterface;

class CategoriesController extends Controller
{
    use WebResponser;

    public $webRepo;
    public $categoryRepo;
    public function __construct(WebInterface $webRepo, CategoryInterface $categoryRepo)
    {
        $this->webRepo = $webRepo;
        $this->categoryRepo = $categoryRepo;
        $this->model = Category::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categoryRepo->allCategoryWithPost($this->model);
        return $this->showView("categories.index", compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->showView("categories.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $data = [
            "name" => $request->name
        ];

        $category = $this->webRepo->create($this->model, $data);
        if($category){
            $this->flashMessage("info", "Category Created Successfully");
            return $this->
            redirectToRoute("categories.index");
        }
        abort(500, "An error occured while trying to create Category, Please try again");
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
        $category = $this->webRepo->find($this->model, $id);
        if($category){
            return $this->showView("categories.edit", compact("category"));
        }
        abort(404, "Category do not exist in our record");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = $this->webRepo->find($this->model, $id);

        if($category->count() > 0){
            $category->name = $request->name;
            if($category->isDirty()){
                $updateCategory = $this->webRepo->update($category);
                if($updateCategory){
                    $this->flashMessage("info", 'Category updated successfully');
                    return $this->redirectToRoute("categories.index");
                }
                else{
                    $this->flashMessage("info", 'Category could not be updated');
                    return $this->redirectBack();
                }
            }
            else
            {
                $this->flashMessage("info", 'You need to make changes to category to update');
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
        $category = $this->webRepo->find($this->model, $id);
        if($category->count() > 0){
            $deleteCategory = $this->webRepo->delete($category);
            $this->categoryRepo->detachCategoryPost($category);
            if($deleteCategory){
                $this->flashMessage("info", "Category deleted successfully");
                return $this->redirectToRoute("categories.index");
            }
            $this->flashMessage("info", "An error occured while deleting user");
            return $this->redirectBack();
        }
        abort(404, "Category could not be found in our record");
    }
}
