<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Nav extends Model
{
    protected $table='navs';
    protected $primaryKey='nav_id';
    public $timestamps=false;
    protected $fillable = ['nav_name','nav_alias','nav_order','nav_url','nav_user','nav_password','nav_description'];//白名单字段
    protected $guarded = ['nav_id'];//黑名单字段
 
}
