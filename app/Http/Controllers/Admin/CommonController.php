<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
class CommonController extends Controller
{
	//文章缩略图上传
    public function upload(){
    	$file=Input::file('Filedata');
    	if($file->isValid()){
    		$realPath = $file -> getRealPath();//获取临时文件的位置
    		$entension = $file -> getClientOriginalExtension();//获取图片的格式
    		$newName=date('YmdHis').mt_rand(100,999).'.'.$entension;
    		$path=$file->move(base_path().'/storage/uploads',$newName);//文件存储地址
    		$filePath='/storage/uploads/'.$newName;
    		return $filePath;
    	}
    }
}
