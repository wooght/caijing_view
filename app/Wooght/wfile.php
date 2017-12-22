<?php
namespace App\Wooght;
/*
+--------------------------------------+
|  WooghtPHP 基础实现类                  |
+--------------------------------------+
|  文件上传,生成缩略图                    |
+--------------------------------------+
*/
/*
1.接收图片,判断文件类型
2.判断图片大小
3.保存图片到指定位置
4.生成缩略图并且保存到指定位置
 -1.判断目录是否存在,不存在根据条件判断是否可以创建文件夹
 -2.生成以时间命名的文件名
 -3.保存文件
/5.json返回数据
*/
use App\Wooght\smfile;
class wfile
{
	//文件实体
	private $file;
	//文件类型
	public $f_type;
	//文件类型后缀
	public $_type_;
	//文件size
	public $f_size;
	//文件保存名称
	public $f_name;
	//保存目录
	public $f_dir;
	//当目录不存在时,是否创建目录
	private $f_mk_dir=false;
	//允许的最大size=512
	private $f_mx_s=512;
	//允许的最大宽度
	private $f_mx_w=800;
	//允许的最大高度
	private $f_mx_h=600;
	//图片原始宽度
	private $f_width;
	//图片原始高度
	private $f_height;
	//返回状态
	public $f_turn="";

	public function __construct($file)
	{
		$this->file=$file;
		//错误及结果报告
		$this->file_turn = array('size'=>'文件太大','ok_file'=>'true','up_file'=>'false','mime'=>'类型不对');
		//$this->f_name=date("YmdHis",time());
	}
	//修改配置变量接口
	public function set_size($type,$size)
	{
		//$list=func_num_args();读取函数参数
		switch($type){
			case "width":$this->f_mx_w=$size;break;
			case "height":$this->f_mx_h=$size;break;
			case "size":$this->f_mx_s=$size;break;
			default :return false;break;
		}
	}
	//获取图片类型
	public function file_type()
	{
		$this->f_type=$this->file['type'];
		switch($this->f_type)
		{
			case "image/jpeg":
			case "image/pjpeg": $this->_type_=".jpg"; break;//pjpeg同jpeg格式
			case "image/gif": $this->_type_=".gif"; break;
			case "image/png": $this->_type_=".png"; break;
			default : $this->_type_="";break;
		}
		return (empty($this->_type_))?false:true;
	}
	//获取图片大小
	public function file_size()
	{
		$size=$this->file['size'];
		return ceil($size/1024);
	}
	//获取图片尺寸
	private function file_wh()
	{
		//获取图片的宽,高并返回
		$wh_arr=getimagesize($this->f_dir.$this->f_name);
		$this->f_width=$wh_arr[0];
		$this->f_height=$wh_arr[1];
	}

	/*
	+----------------------------+
	|  判断目录是否存在,调用保存函数 |
	+----------------------------+
	|  上传文件接口                |
	+----------------------------+
	*/
	public function file_save($dir)
	{
		//判断目录是否存在
		if(!is_dir($dir))
		{
			if($this->f_mk_dir)
			{
				if($this->mk_dir($dir)){
					$this->f_dir=$dir;
					return $this->f_save($dir);
				}
			}
			else
			{
				$this->f_turn="文件夹不存在";
				return false;//文件夹不存在
			}
		}
		else
		{
			$this->f_dir=$dir;
			return $this->f_save($dir);
		}
	}
	/*
	+---------------------------------+
	|  判断文件夹是否存在,创建目录       |
	+---------------------------------+
	|  实例化图像,并保存                |
	+---------------------------------+
	*/
	public function file_smail($s_dir,$f_x,$f_y)
	{
		if(!file_exists($s_dir))
		{
			if($this->f_mk_dir)
			{
				if($this->mk_dir($s_dir))
				{
					return ($new_file=new smfile($f_x,$f_y,$s_dir)) ? true : false;
				} else{
				    $this->f_turn=$GLOBALS['false_turn']['not_dir'];
				    return false;//指定文件夹不存在
				}
			}
			else
			{
				return false;
			}
		}
		else
		{
			//生成图片,保存图片,返回每个文件都可以通过地址访问的地址
			return ($new_file=new smfile($f_x,$f_y,$s_dir))? true : false;
		}
	}
	//创建目录
	private function mk_dir($dir)
	{
		//创建0777目录
		if(mkdir($dir,0777)) return true;
		else return false;
	}
	/*
	+-----------------------------+
	|  保存图像函数,实例化图像,并保存 |
	+-----------------------------+
	*/
	private function mk_file($f_w=0,$f_h=0)
	{
		//生成图片,并返回图片
		$f_w=($f_w!=0)?$f_w:$this->f_mx_w;
		$f_h=($f_h!=0)?$f_h:$this->f_mx_h;
		if($new_file=new smfile($f_w,$f_h,$this->f_dir.$this->f_name))
		{
		    return true;
		}else{
		    $this->f_turn=$new_file->sm_turn;
			return false;
		}
		//return $new_file;
	}
	/*
	+-------------------------------------+
	|  上传图像,判断大小,尺寸.根据条件保存图片 |
	+-------------------------------------+
	*/
	private function f_save($dir)
	{
		$this->f_size=$this->file_size();
		if($this->f_size > $this->f_mx_s)
		{
			$this->f_turn=$this->file_turn['size'];
			return false;//上传文件太大
		}
		else
		{
			if($this->file_type()){
				$this->f_name=date("YmdHis",time()).rand(1,10000).$this->_type_;//一时间+随机数做文件名
				if(move_uploaded_file($this->file['tmp_name'],$dir.$this->f_name)){
					$this->file_wh();
					if($this->f_width > $this->f_mx_w or $this->f_height > $this->f_mx_h)
					{
						//图片尺寸太大,调用缩略函数
						return ($this->mk_file()) ? true : false;
					}
					else{
						$this->f_turn=$this->file_turn['ok_file'];
						return true;//文件上传成功
					}
				}
				else{
					$this->f_turn=$this->file_turn['up_file'];
					return false;//文件上传失败
				}
			}
			else
			{
				$this->f_turn=$this->file_turn['mime'];
				return false;//文件类型不支持
			}
		}
	}
}//类定义结束
