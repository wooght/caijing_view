<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class topics extends Model
{
    public $table = 'topic';
    public function Attitudes(){
        return $this->hasMany('App\Model\attitude_relation','article_id');
    }
}
