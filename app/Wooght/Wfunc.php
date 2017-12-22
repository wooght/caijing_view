<?php
//wooght扩展
//js alert()输出内容
function alert($str){
  return script_l()."alert('".$str."');".script_r();
}
function script_l(){
  return "<script type='text/javascript'>";
}
function script_r(){
  return "</script>";
}
//截取字符串(utf-8)
function wsubstr($str,$num,$is_zh="en")
{
    //截取中文字符
    if($is_zh=="zh")
  {
      $length=strlen($str);
    $result="";
    if($length > $num)
    {
        for($i=0;$i < $num;$i++)
      {
          if(ord($str[$i])>127)
        {
            $result.=$str[$i].$str[++$i].$str[++$i];//utf-8编码下,一个汉字为三个ASCII码
        }
        else $result.=$str[$i];
      }
      return $result;
    }
    else return $str;
  }
  //截取英文字符
  else {
      if(strlen($str) <= $num)
      return $str;
    else
    return substr($str,0,$num);
  }
}
