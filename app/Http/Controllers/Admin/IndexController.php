<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Crypt;
use App\Http\Model\User;

class IndexController extends CommonController
{
    public function index(){
    	return view('admin.index');
    }
    public function info(){
    	return view('admin.info');
    }
    
    public function pass(){
    	if(!$input=Input::all())return view('admin.pass');
    }
}
