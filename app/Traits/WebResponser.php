<?php

namespace App\Traits;

trait WebResponser{
    public function showView(string $view_name, array $data = []){
        return view($view_name, $data);
    }

    public function redirect(string $path, array $data = []){
        return redirect($path)-with("data", $data);
    }

    public function redirectBack(){
        return redirect()->back();
    }

    public function flashMessage($key, $msg){
        return session()->flash($key, $msg);
    }

    public function redirectToRoute(string $route_name){
        return redirect()->route($route_name);
    }
}
