<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table='category';
    protected $primaryKey='cate_id';
    public $timestamps=false;
    protected $fillable = ['cate_name','cate_title','cate_description','cate_order','cate_pid'];//白名单字段
    protected $guarded = ['cate_id'];//黑名单字段

}
