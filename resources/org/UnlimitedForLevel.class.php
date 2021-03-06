<?php
 
Class unlimitedLevel{
    //组合一维数组
    static public function unlimitedForLevel($cate,$html='═',$pid=0,$level=0){
        $arr=array();
        foreach($cate as $v){
            if($v['cate_pid']==$pid){
                $v['level']=$level+1;
                if($level==0){
                    $v['html']="╔";
                }else{
                    $v['html']="╬".str_repeat($html,$level);
                }
                $arr[]=$v;
                $arr=array_merge($arr,self::unlimitedForLevel($cate,$html,$v['cate_id'],$level+1));
            }
        }
        return $arr;
    }
    //组合多维数组
    Static public function unlimitedForLayer($cate, $name='child',$pid=0){
        $arr=array();
        foreach ($cate as $v){
            if ($v['pid']==$pid){
                $v[$name]=self::unlimitedForLayer($cate,$name,$v['id']);
                $arr[]=$v;
            }
        }
        return $arr;
    }
    //传递一个子分类ID返回所有的父级分类
    Static public function getParents($cate,$id){
        $arr=array();
        foreach($cate as $v){
            if($v['cate_id']==$id){
                $arr[]=$v;
                $arr=array_merge(self::getParents($cate,$v['cate_pid']),$arr);
            }
        }
        return $arr;
    }
    //传递一个父级ID返回所有子级ID
    Static public function getChildsId($cate,$pid){
        $arr=array();
        foreach($cate as $v){
            if($v['pid']==$pid){
                $arr[]=$v['id'];
                $arr=array_merge($arr,self::getChildsId($cate,$v['id']));
            }
        }
        return $arr;
    }
    //传递一个父ID返回所有子级类
    Static public function getChilds($cate,$pid){
        $arr=array();
        foreach($cate as $v){
            if($v['cate_pid']==$pid){
                $arr[]=$v;
                $arr=array_merge($arr,self::getChilds($cate,$v['cate_id']));
            }
        }
        return $arr;
    }
}

