<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[
        	[
        		'link_name'=>'百度',
        		'link_title'=>'国内最大的搜索网站',
        		'link_url'=>'www.baidu.com',
        		'link_order'=>1
        	],
        	[
        		'link_name'=>'谷歌',
        		'link_title'=>'世界最大的搜索网站',
        		'link_url'=>'www.google.com',
        		'link_order'=>2
        	]
        ];

        DB::table('links')->insert($data);
    }
}
