<?php
namespace App\Wooght;
/*-------------------------------------

 基础实现类：翻页
 by wooght 2010-10-16

--------------------------------------*/
class wfanye {
	var $page;//当前第几页
	var $num;//信息总条数
	var $area_name;//页面名称
	var $tar;//输出翻页的字符串——需要翻页的页面最终显示
	var $web_num;//页面显示条数
	var $center_num;//显示页码个数

	public function __construct($page,$num,$area_name,$web_num,$center_num){
		$this->page=$page;
		$this->num=$num;
		$this->area_name=$area_name;
		//$this->area_leixing=$area_leixing;
		//$this->area_num=$area_num;
		$this->web_num=(isset($web_num) ? $web_num:10);
		$this->center_num=(isset($center_num) ? $center_num:5);
		if($this->center_num%2===0){
			$this->center_num-=1;
		}
		$this->tar="";
		$this->tar.="<div class=\"fanye\"><span class=\"kuan\">".$this->chu()."</span><a href=\"".$this->area_name."/page/1\">首页</a><a ".$this->yemian_shang().">上一页</a>";
	}

	//上一页
	private function yemian_shang(){
		if($this->page==1){
		return "";
		}
		else{
		return "href=\"".$this->area_name."/page/".($this->page-1)."\"";}
	}
	//下一页
	private function yemian_xia(){
		if($this->page==$this->chu()){
		return "";}
		else{
		return "href=\"".$this->area_name."/page/".($this->page+1)."\"";}
	}
	//计算总数
	private function chu(){
		//$this->page_chu=$this->num/18;
		if($this->num%$this->web_num==0){
			$page_num = $this->num/$this->web_num;
		}
		else{
			$page_num=intval($this->num/$this->web_num)+1;
		}
		return $page_num;//总页面数
	}

	//显示中间页码
	private function xianshi_ji(){
		$this->page_zhong=$this->chu();
		//总数小于页码个数
		if($this->page_zhong <= $this->center_num){
			$shuz=1;
			while($shuz<=$this->page_zhong){
				$this->tar.="<a href=\"".$this->area_name."/page/".$shuz."\"".$this->a_class($shuz).">".$shuz."</a>";
				$shuz+=1;
			}
		}
		//总数大于页码总数，但当前页面 小于 页码总数的一半
		if($this->page_zhong > $this->center_num and $this->page <= $this->foword()){
			$shuz=1;
			while($shuz <= $this->center_num)
			{
				$this->tar.="<a href=\"".$this->area_name."/page/".$shuz."\"".$this->a_class($shuz).">".$shuz."</a>";
				$shuz+=1;
			}
		}
		//总数大约页面总数，当前页面大于页码总数的一半但 小于 总数减页码总数一半
		if($this->page_zhong > $this->center_num and $this->page >$this->foword() and $this->page < $this->page_zhong-$this->endword()){
			$shuz=$this->page-$this->endword();
			while ($shuz<=$this->page+$this->endword()){
				$this->tar.="<a href=\"".$this->area_name."/page/".$shuz."\"".$this->a_class($shuz).">".$shuz."</a>";
				$shuz+=1;
			}
		}
		//总数大于页码总数，但当前页面 大于 页面总数减去页码总数一半
		if($this->page_zhong > $this->center_num and $this->page >$this->foword() and $this->page >= $this->page_zhong-$this->endword()){
			$shuz=$this->page_zhong-$this->center_num-1;
			while($shuz<=$this->page_zhong){
				$this->tar.="<a href=\"".$this->area_name."/page/".$shuz."\"".$this->a_class($shuz).">".$shuz."</a>";
				$shuz+=1;
			}
		}
	}
	//中间页码前面显示个数 大半
	private function foword(){
		return intval($this->center_num/2)+1;
	}
	//中间页码后面显示个数 小半
	private function endword(){
		return intval($this->center_num);
	}
	private function a_class($shuz){
		if($shuz==$this->page){
			return "class=\"c\"";
		}
	}
	//输出下一页和最后一页
	private function mowei_say(){
		//获取最后一页的条码
		if($this->num==0) $last_num = 1;
		else $last_num = $this->chu();
		$this->tar.="<a ".$this->yemian_xia().">下一页</a><a href=\"".$this->area_name."/page/".$last_num."\">末页</a></div>";
	}
	//输出页码条
	public function show(){
		$this->xianshi_ji();
		$this->mowei_say();
		return $this->tar;
	}
}
