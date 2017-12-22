<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class attitude_relation extends Model
{
    public $table = 'attitude_relation';
    public function companys(){
        //一对多 指定对应关系 id->article_id
        return $this->hasOne('App\Model\listed_company','codeid','code_id');
    }
}
