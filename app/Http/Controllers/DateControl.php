<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\attitude_relation;
use App\Model\zuhe_change;

class DateControl extends Controller
{
    // public $path = 'python F:\homestead\scripy_wooght\caijing_scrapy\factory\data/';
    public $path = 'python3 /home/vagrant/www/scripy_wooght/caijing_scrapy/factory/data/';
    public function topic($id){
        $data = shell_exec($this->path."topic_attitude.py ".$id);
        return $data;
    }
    public function quotes($id){
        $data = shell_exec($this->path."quotes_data.py ".$id);
        return $data;
    }
    public function attitudes($id){
        $data = shell_exec($this->path."attitude_nums.py ".$id);
        return $data;
    }
    public function ddtj($id){
        $data = shell_exec($this->path."ddtj_data.py ".$id);
        return $data;
    }
    public function zuhe_change($id){
        $locale='en_US.UTF-8';
        setlocale(LC_ALL,$locale);
        putenv('LC_ALL='.$locale);
        $data = shell_exec($this->path."zuhe_change.py ".$id);
        return $data;
    }
    public function redian_list(){
        $m = new attitude_relation;
        $last_times = time()-24*3600;
        $last_times5 = time()-5*24*3600;
        $news = $m->selectRaw('code_id,count(code_id) as countt')->where('put_time','>',$last_times)->where('article_type','=','2')->groupby('code_id')->orderby('countt','desc')->skip(0)->take(20)->get();
        $topic = $m->selectRaw('code_id,count(code_id) as countt')->where('put_time','>',$last_times)->where('article_type','=','1')->groupby('code_id')->orderby('countt','desc')->skip(0)->take(20)->get();

        $news5 = $m->selectRaw('code_id,count(code_id) as countt')->where('put_time','>',$last_times5)->where('article_type','=','2')->groupby('code_id')->orderby('countt','desc')->skip(0)->take(20)->get();
        $topic5 = $m->selectRaw('code_id,count(code_id) as countt')->where('put_time','>',$last_times5)->where('article_type','=','1')->groupby('code_id')->orderby('countt','desc')->skip(0)->take(20)->get();

        $z = new zuhe_change;
        $zh_count = $z->selectRaw('code_id,sum(change_status) as countt')->where('updated_at','>',$last_times*1000)->groupby('code_id')->orderby('countt','desc')->skip(0)->take(30)->get();
        $zh_up5 = $z->selectRaw('code_id,sum(change_status) as countt')->where('updated_at','>',$last_times5*1000)->groupby('code_id')->orderby('countt','desc')->skip(0)->take(30)->get();
        $zh_down = $z->selectRaw('code_id,sum(change_status) as countt')->where('updated_at','>',$last_times*1000)->groupby('code_id')->orderby('countt')->skip(0)->take(30)->get();
        $zh_down5 = $z->selectRaw('code_id,sum(change_status) as countt')->where('updated_at','>',$last_times5*1000)->groupby('code_id')->orderby('countt')->skip(0)->take(30)->get();
        return view('redian_list',compact('news','topic','news5','topic5','zh_count','zh_up5','zh_down','zh_down5'));
    }
    //php python 中文通讯   python输出utf-8编码字符 phpurldecode反编码
    public function article_analyes($id){
        $data = shell_exec($this->path."semantics.py ".$id);
        $data = urldecode(str_replace('\x','%',$data));
        $data = urldecode(str_replace("b'","'",$data));
        return $data;
    }
}
