<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Crypt;
use App\Http\Model\User;
require_once('resources/org/code/Code.class.php');
class LoginController extends CommonController
{
    public function login()
    {
        //判断是否为post表单提交
    	if(!$input=Input::all()){
            return view('admin.login');
        }
		//检查验证码
        if(strtoupper($input['code'])!=$_SESSION['code'])return back()->with('msg','验证码错误');//back函数将返回的变量存入了session中

        $user=User::where('user_name',$input['user_name'])->first();
        if(!$user)return back()->with('msg','用户名不存在');
        $user_pass=Crypt::decrypt($user->user_pass);
        if($user_pass!=$input['user_pass'])return back()->with('msg','密码错误');

        session(['user'=>$user]);
        return redirect('admin/index');
    }

    public function code(){
    	$code=new \Code();
    	$code->make();
    }

    public function quit(){
        session(['user'=>null]);
        return redirect('admin/login');
    }
    
    public function encrypt(){
        $str=123456;
        echo Crypt::encrypt($str);
    }
}
