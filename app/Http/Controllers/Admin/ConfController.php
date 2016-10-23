<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
  
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use App\Http\Model\Conf;

class ConfController extends CommonController
{
    /**
     *  
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $confs=Conf::orderBy('conf_order','asc')->get();
        foreach($confs as $k => $v){
            switch ($v->field_type) {
                case 'radio':
                    if($v['field_value']==1){
                        $confs[$k]['conf_content']="<input type='radio' name='field_value+{$v['conf_id']}' value='1' checked='checked'/>开启&nbsp;&nbsp;&nbsp;&nbsp;";
                        $confs[$k]['conf_content'].="<input type='radio' name='field_value+{$v['conf_id']}' value='0'>关闭";
                    }else{
                        $confs[$k]['conf_content']="<input type='radio' name='field_value+{$v['conf_id']}' value='1' >开启&nbsp;&nbsp;&nbsp;&nbsp;";
                        $confs[$k]['conf_content'].="<input type='radio' name='field_value+{$v['conf_id']}' value='0' checked='checked' >关闭";
                    }
                    break;
                case 'text':
                    $confs[$k]['conf_content']="<input type='text' style='width:300px;' name='conf_content+{$v['conf_id']}' value='{$v['conf_content']}'";
                    break;
                case 'file':
                    $confs[$k]['conf_content']="<input type='text'  style='width:300px;' name='conf_content+{$v['conf_id']}' value='{$v['conf_content']}' disabled='disabled'>";
                    break;
                case 'textarea':
                    $confs[$k]['conf_content']="<textarea name='conf_content+{$v['conf_id']}'>{$v['conf_content']}</textarea>";
                    break;

            }
        }
        return view('admin.listConf',compact('confs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.addConf');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input=$request->input(); 
        $input['field_value']=isset($input['field_value'])? $input['field_value']:'';
        $input['conf_content']=isset($input['conf_content'])? $input['conf_content']:'';
        $rules=[
            'conf_name'=>'required|between:2,20',
            'conf_title'=>'required',
            'conf_order'=>'required',
            'field_type'=>'required'
        ];
        $message=[
            'conf_name.required'=>'配置名称不能为空',
            'conf_name.between'=>'配置名称在2-20字之间',
            'conf_title.required'=>'配置标题必填',
            'conf_order.required'=>'排序不能为空',
            'field_type.required'=>'配置显示类型不能为空',
        ];

        $validator=Validator::make($input,$rules,$message);
        if($validator->passes()){
            if(isset($input['conf_id'])&&$input['conf_id']!=''){//更新
                $data=Input::except('_token','conf_id');
                $old_image=Conf::find($input['conf_id'])->conf_content;
                 if(is_file($old_image)&&is_file(base_path().$data['conf_content'])){//若配置内容是文件， 图片地址存在差异应删除旧图片
                    if($data['conf_content']!=$old_image)unlink(base_path().$old_image);
                }
                Conf::where('conf_id',$input['conf_id'])->update($data);
                $msg='修改配置成功';
                $this->putFile();//更新配置项到文件夹
            }else{
                Conf::create($input);
                $msg='添加配置成功';
            }
            return redirect('admin/conf')->with('msg',$msg);
        }else{
            return back()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $confs=Conf::orderBy('conf_order','asc')->get();
        $confEdit=Conf::find($id);
        return view('admin.addConf',compact('confEdit','confs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conf=Conf::find($id);
            $re=$conf->delete();
            if($re){
                $this->putFile();//更新配置项到文件夹
                $data=[
                    'status'=>0,
                    'msg'=>'删除成功'
                ];
            }else{
                $data=[
                    'status'=>1,
                    'msg'=>'删除失败'
                ];
            }
        return $data;
    }

    public function order()
    {
        $input=Input::all();
        $conf=Conf::find($input['conf_id']);
        $conf->conf_order=$input['conf_order'];
        $re=$conf->update();
        if($re){
            $data=[
                'status'=>0,
                'msg'=>'排序成功'
            ];
        }else{
            $data=[
                'status'=>1,
                'msg'=>'排序失败'
            ];
        }

        return $data;
    }
    public function confUpdate()
    {//更新配置项内容
        $input=Input::except('_token');
        foreach($input as $k=>$v){
            $tmp=explode('+', $k);
            $conf=Conf::find($tmp[1]);
            $conf->$tmp[0]=$v;
            $conf->update();
        }
        $this->putFile();//更新配置项到文件夹
        return back()->with('msg','配置内容更新成功');

    }
    public function putFile()
    {
        $config=Conf::pluck('conf_content','conf_name')->all();
        $content=var_export($config,true);
        $webConfPath=base_path().'/config/web.php';//配置文件路径
        $str="<?php return ".$content.';';
        file_put_contents($webConfPath, $str);
        echo Config::get('web.web_count');

    }
    //文章缩略图上传
    public function upload()
    {
        $file=Input::file('Filedata');
        if($file->isValid()){
            $realPath = $file -> getRealPath();//获取临时文件的位置
            $entension = $file -> getClientOriginalExtension();//获取图片的格式
            $newName=md5_file($realPath).'.'.$entension;
            $path=$file->move(base_path().'/resources/views/home/images/',$newName);//文件存储地址
            $filePath='/resources/views/home/images/'.$newName;
            return $filePath;
        }
    }
}
