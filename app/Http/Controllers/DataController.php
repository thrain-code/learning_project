<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataController extends Controller
{
    public function index(){
        $data = [
            "name" => "eji"
        ];
        return view("app", compact("data"));
    }
}
