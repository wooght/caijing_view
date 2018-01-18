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

class HomeController extends Controller
{
    public function index(){
      $companys = listed_company::count();
      $plates = listed_plate::all()->count();
      $region = listed_region::count();
      $quotes = quotes_item::get(array('id'))->count();
      $model_news = news::get(['url']);
      $news = $model_news->count();
      $model_topic = topics::get(['url']);
      $topic = $model_topic->count();
      $notices = company_notice::count();
      //调用python 生成统计图片
      // $total_pic_arr = shell_exec("python F:\homestead\scripy_wooght\caijing_scrapy\caijing_scrapy/factory/pic/total_classfaly_pic.py ");
      $topic_classfaly = $this->total_classfaly($model_topic);
      $news_classfaly = $this->total_classfaly($model_news);
      return view('welcome',compact('companys','plates','region','quotes','news','topic','notices','topic_classfaly','news_classfaly'));
    }

    public function total_classfaly($table){
      $domains = $this->select_domains();
      $url = array();
      foreach($table as $item){
        foreach($domains as $key){
          if(strpos($item,$key)){
            if(!array_key_exists($key,$url)){
              $url[$key] = 1;
            }else{
              $url[$key]++;
            }
          }
        }
      }
      return $url;
    }
    public function select_domains(){
      $dom = domains::all();
      $arr = array();
      foreach($dom as $val){
        $arr[] = $val->name;
      }
      return $arr;
    }

    //默认股票列表
    public function companyslist(Request $request,$page=1){
      $this->select_plate();
      $at = new listed_company;
      $atnum = listed_company::all();
      $at_list = $at->orderBy('id','desc')->skip($page*20-20)->take(20)->get();
      $fyobj = new wfanye($page,$atnum->count(),'/companyslist',20,10);
      $fy = $fyobj->show();
      $plates = $this->plates;
      $region = $this->region;
      return view('companylist',compact('fy','plates','region'))->withList($at_list);
    }

    //股票详情
    public function companyone($id){
      $s = new listed_company;
      $comp = $s->where('codeid','=',$id)->get();
      $comp[0]->shsz=$this->allcodeid($comp[0]);
      $company =  $comp[0];
      // #读取行情数据
      // $pic = shell_exec("python F:\homestead\scripy_wooght\caijing_scrapy\caijing_scrapy/factory/pic/quote_pic.py ".$id);
      // $jsondata = json_decode($pic);
      // $quotes = '';
      // foreach(array_reverse($jsondata) as $value){
      //   $quotes .= '["'.$value->datatime.'",'.$value->kai.','.$value->shou.','.$value->di.','.$value->gao.'],';
      // }
      #分析相关图片生产
      // $attitude_topic_pic = shell_exec("python F:\homestead\scripy_wooght\caijing_scrapy\caijing_scrapy/factory/pic/topic_attitude_pic.py ".$id);
      // 概念板块查询
      $concept_s = $company->concept_id;
      $concept_arr = explode(',',$concept_s);
      $code_id = $id;
      return view('companyone',compact('code_id','concept_arr'))->withCompany($company);
    }

    //通过板块查询
    public function plate_list($id=1001,$page=0){
      $pt = 20;
      $s = new listed_plate;
      $platelist = $s->where('father_id','!=','0')->get();
      $at = $this->select_company(0,$id,0,$page,$pt);
      $fyobj = new wfanye($page,$at['atnum']->count(),'/plate_list/id/'.$id,$pt,10);
      $fy = $fyobj->show();
      $plates = $this->plates;
      $region = $this->region;
      return view('plate_index',compact('id','platelist','fy','plates','region'))->withList($at['at_list']);
    }
    //概念股列表
    public function concept_list($id=21029,$page=0){
      $pt = 20;
      $s = new listed_concept;
      $platelist = $s->get();
      $at = $this->select_company(0,0,$id,$page,$pt);
      $fyobj = new wfanye($page,$at['atnum']->count(),'/concept_list/id/'.$id,$pt,10);
      $fy = $fyobj->show();
      $plates = $this->plates;
      $region = $this->region;
      return view('concept_index',compact('id','platelist','fy','plates','region'))->withList($at['at_list']);
    }

    //查询上市公司列表
    public function select_company($regionid=0,$plateid=0,$conceptid=0,$page=0,$pt){
      $this->select_plate();
      $at = new listed_company;
      if($regionid!=0){
        $atobj = $at->where('region_id','=',$regionid);
      }
      else if($plateid!=0){
        $atobj = $at->where('plate_id','=',$plateid);
      }else if($conceptid){
        $atobj = $at->where('concept_id','like','%'.$conceptid.'%');
      }else{
        $atobj = $at;
      }
      $atnum = $atobj->get();
      $at_list = $atobj->orderBy('id','desc')->skip($page*$pt-$pt)->take($pt)->get();
      foreach($at_list as $key=>$item){
        $at_list[$key]['szshcode'] = $this->allcodeid($item);
      }
      return array('atnum'=>$atnum,'at_list'=>$at_list);
    }

    //代码全写
    public function allcodeid($item){
      $str = (string)$item->codeid;
      if(strlen($str)<5){
        while(strlen($str)<6){
          $str='0'.$str;
        }
      }
      return $item->shsz.$str;
    }

    //查询地域和板块
    public function select_plate(){
      $p = listed_plate::all();
      $plates=array();
      foreach($p as $ps){
        $plates[$ps['plateid']] = $ps['name'];
      }
      $reg = listed_region::all();
      $region = [];
      foreach($reg as $regs){
        $region[$regs['id']] = $regs['name'];
      }
      $this->plates = $plates;
      $this->region = $region;
    }
}
