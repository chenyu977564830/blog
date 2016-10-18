<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
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
    	
    	//自动验证
    	$rules=[
    		'password'=>'required|between:6,20|confirmed'
    	];
    	$msg=[
    		'password.required'=>'新密码不能为空',
    		'password.between'=>'密码必须在6-20字符之间',
    		'password.confirmed'=>'密码两次输入密码不一致'
    	];
    	$validator=Validator::make($input,$rules,$msg);
    	if($validator->passes()){//验证通过后 数据库操作
    		$user=User::where("user_id",session('user')->user_id)->first();
    		$_password=$user->user_pass;
    		if($input['password_o']!=Crypt::decrypt($_password))return back()->with('msg','密码错误');
    		//数据库更新
    		$password=Crypt::encrypt($input['password']);
    		$user->user_pass=$password;
    		$user->update();
    		return back()->with('msg','修改密码成功');
    	}else{
    		//dd($validator->errors()->all());
    		return back()->withErrors($validator);
    	}
    }
}
