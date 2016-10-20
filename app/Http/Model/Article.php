<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table='article';
    protected $primaryKey='art_id';
    public $timestamps=false;
    protected $fillable = ['art_title','art_tag','art_description','art_thumb','art_content','art_time','art_editor','art_view','art_recommend','art_open','cate_id'];//白名单字段
    protected $guarded = ['art_id'];//黑名单字段

}
