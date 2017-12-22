<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class zuhe_change extends Model
{
    public $table = 'zuhe_change';
    public function companys(){
        return $this->hasOne('App\Model\listed_company','codeid','code_id');
    }
}
