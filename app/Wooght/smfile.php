<?php
namespace App\Wooght;
/*
+----------------------------+
|    WooghtPHP 基础实现类     |
+----------------------------+
|    缩略图生成类,图片生成类    |
+----------------------------+
*/
class smfile
{
	//最大高度
	private $height;
	//最大宽度
	private $width;
	//图片地址
	private $file_dir;

	//图片的真实高度
	private $f_h;
	//图片的真实宽度
	private $f_w;
	//图片的类型
	private $f_type;
	//图片的后缀名
	private $_type_;

	//图片的新高度
	private $n_h;
	//图片的新宽度
	private $n_w;

	//打开图像使用方法
	private $imagecreat;
	//返回状态
	public $sm_turn="";

	public function __construct($width,$height,$file_dir,$new_dir="")
	{
		$this->width=$width;
		$this->height=$height;
		$this->file_dir=$file_dir;
		$this->new_dir=($new_dir=="") ? $file_dir:$new_dir;
		//直接调用生成图像
		$this->make_file();
	}

	/*
	+----------------------------+
	|  生成图片函数               |
	+----------------------------+
	|  根据判断生成相应格式的图片   |
	+----------------------------+
	*/
	private function make_file()
	{
		$this->get_type();
		if($this->get_new_size()){
			$img_1=imagecreatetruecolor($this->n_w,$this->n_h);
			$img_2=imagecopyresized($img_1,$this->imagecreat,0,0,0,0,$this->n_w,$this->n_h,$this->f_w,$this->f_h);
			switch($this->f_type)
			{
				//根据不同图片类型,保存相应类型图片
				case "image/jpeg":
				case "image/pjpeg":imagejpeg($img_1,$this->new_dir);break;
				case "image/gif":imagegif($img_1,$this->new_dir);break;
				case "image/png":imagepng($img_1,$this->new_dir);break;
			}
			return true;
		} else return false;
	}

	//获取图片详细信息
	private function get_type()
	{
		if($type_arr=getimagesize($this->file_dir))
		{
			$this->f_w=$type_arr[0];
		    $this->f_h=$type_arr[1];
		    $this->f_type=$type_arr['mime'];
			return ($this->get_h())?true : false;
		}
		else {
		    $this->sm_turn=$GLOBALS['false_turn']['not_file'];
		    return false;//没有找到文件
		}
	}

	//获取后缀名
	private function get_h()
	{
		switch($this->f_type)
		{
			//根据图片类型,打开相应类型图片
			case "image/jpeg":
			case "image/pjpeg": $this->_type_=".jpg";$this->imagecreat=imagecreatefromjpeg($this->file_dir); break;
			case "image/gif": $this->_type_=".gif";$this->imagecreat=imagecreatefromgif($this->file_dir); break;
			case "image/png": $this->_type_=".png";$this->imagecreat=imagecreatefrompng($this->file_dir); break;
			default : $this->_type_="";break;
		}
		if($this->_type_==""){
		    $this->sm_turn=$GLOBALS['false_turn']['mime'];
			return false;//不支持的文件类型
		}else return true;
	}
	/*
	+--------------------------+
	|  返回图片的新高度和宽度     |
	+--------------------------+
	|  比例以最大的为准          |
	+--------------------------+
	*/
	private function get_new_size()
	{
		//只有宽或者高有大于规定值时才生成缩略图
		if($this->f_w > $this->width or $this->f_h > $this->height)
		{
			//生成的缩略图的缩放比例以宽,高中最大的比例来算
			$w_n=$this->f_w/$this->width;
			$h_n=$this->f_h/$this->height;
			if($w_n >= $h_n)
			{
				$this->n_w=intval($this->f_w/$w_n);//尺寸为整数
				$this->n_h=intval($this->f_h/$w_n);
			}
			else
			{
				$this->n_h=intval($this->f_h/$h_n);
				$this->n_w=intval($this->f_w/$h_n);
			}
			return true;
		}
		else{
		    $this->sm_turn=$GLOBALS['false_turn']['not_do'];
			return false;//规定尺寸大于图片尺寸
		}
	}
}//类定义结束
