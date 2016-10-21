<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Conf extends Model
{
    protected $table='config';
    protected $primaryKey='conf_id';
    public $timestamps=false;
    protected $fillable = ['conf_name','conf_title','conf_content','conf_order','conf_tips','field_type','field_value'];//白名单字段
    protected $guarded = ['conf_id'];//黑名单字段
}
 