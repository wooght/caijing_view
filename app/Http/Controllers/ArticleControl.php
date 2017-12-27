<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\listed_company;
use App\Model\listed_plate;
use App\Model\listed_region;
use App\Model\quotes_item;
use App\Model\news;
use App\Model\topics;
use App\Model\company_notice;
use App\Model\domains;
use App\Wooght\wfanye;
use App\Model\listed_concept;
use App\Model\attitude_relation;

class ArticleControl extends HomeController
{
    public function news_list($pageid=1){
        list($fy,$newslist) = $this->select_article($pageid,new news,'/news_list');
        return view('newslist',compact('fy'))->withList($newslist);
    }
    public function topics_list($pageid=1){
        list($fy,$newslist) = $this->select_article($pageid,new topics,'/topics_list');
        return view('topicslist',compact('fy'))->withList($newslist);
    }
    public function select_article($pageid,$models,$url){
        $pt = 20;
        $idlist = $models->get(['id']);
        $fyobj = new wfanye($pageid,$idlist->count(),"$url",$pt,10);
        $fy = $fyobj->show();
        $newslist = $models->orderBy('put_time','desc')->skip($pageid*$pt-$pt)->take($pt)->get();
        return array($fy,$newslist);
    }
    //文章分析详情展示页
    public function article_analyes($id){
        return view('article_analyes')->withId($id);
    }
}
