<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\Users\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Repository\Eloquent\WebRepository\WebInterface\WebInterface;
use App\Traits\WebResponser;

class UserController extends Controller
{
    use WebResponser;

    public $webRepo;
    public function __construct(WebInterface $webRepo)
    {
        $this->webRepo = $webRepo;
        $this->model = User::class;
        $this->middleware("verifyIsAdmin", [
            "only" => "index"
        ]);
    }

    public function index(){
        $users = $this->webRepo->all($this->model);
        return $this->showView("users.index", compact("users"));
    }

    public function edit(){
        return $this->showView("users.edit");
    }

   public function makeAdmin($user){
        $user = $this->webRepo->find($this->model, $user);
        if($user){
            $user->role = User::ADMIN_USER;
            $this->webRepo->update($user);
            $this->flashMessage("info", "User is now an administrator");
            return $this->redirectBack();
        }
        abort(404, "User do not exist in our record");
    }

    public function update(UpdateUserRequest $request, $user){
        $user = $this->webRepo->find($this->model, $user);
        if($user){
            $user->name = $request->name;
            $user->about = $request->about;
            if($user->isDirty()){
                $this->webRepo->update($user);
                $this->flashMessage("info", "User updated successfully");
                return $this->redirectToRoute("users.index");
            }
            $this->flashMessage("info", "You need to make changes to your profile to update");
            return $this->redirectBack();
        }
        abort(404, "User do not exist in our record");
    }
}
