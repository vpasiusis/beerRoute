<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){

        $title=" Welcome to the page";

        return view('welcome',compact('title'));
    }
}