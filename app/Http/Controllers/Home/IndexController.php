<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;

class IndexController extends CommonController
{
    public function index()
    {
    	return view('home.index');
    }

    public function article()
    {
    	return view('home.new');
    }
    public function articleList()
    {
    	return view('home.list');
    }
}
