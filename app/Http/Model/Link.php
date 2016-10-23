<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $table='links';
    protected $primaryKey='link_id';
    public $timestamps=false;
    protected $fillable = ['link_name','link_title','link_order','link_url','link_user','link_password','link_myproject','link_description'];//白名单字段
    protected $guarded = ['link_id'];//黑名单字段

}
