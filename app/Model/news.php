<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class news extends Model
{
    public $table = 'news';
    public function Attitudes(){
        //一对多 指定对应关系 id->article_id
        return $this->hasMany('App\Model\attitude_relation','article_id');
    }
}
