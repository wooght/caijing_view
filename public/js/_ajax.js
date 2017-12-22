// JavaScript Document
//js ->ajax
//by wooght 2013
//get,post
	function __(str){
		return document.getElementById(str);
	}
	var _ajax={
	//采用json数据结构
	//ajax构造函数
	"createXMLHTTP":function(){
		if(window.ActiveXObject){
			var xhttp = new ActiveXObject("Microsoft.XMLHTTP");//ie6
		}else if(window.XMLHttpRequest){
			var xhttp=new XMLHttpRequest();//ie7+,ff,chrome
		}else{
			var xhttp = null;
		}
		return xhttp;
	},
	"xp":Object(),
	//get传值
	"get":function(str,url,callback){
		_ajax.xp = _ajax.createXMLHTTP();
		//函数的参数也可以是函数
		url=url+"?"+str;
		_ajax.xp.open("get",url,true);
		//get需要send发送null来开启异步
		_ajax.xp.send(null);
		_ajax.send(callback);
	},
	//post传值
	"post":function(str,url,callback){
		_ajax.xp = _ajax.createXMLHTTP();
		_ajax.xp.open("post",url,true);
		//发送post头信息
		_ajax.xp.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=utf-8");
		_ajax.xp.send(str);
		_ajax.send(callback);
	},
	"send":function(callback){
		_ajax.xp.onreadystatechange=function(){
			if(_ajax.xp.readyState==4){
				//readyState在ie中的顺序是1234,在ff中的顺序是1234,在chrome中的顺序是234
				if(_ajax.xp.status==200){
					callback(_ajax.xp.responseText);
				}
			}
		}
	}
}
/*_ajax.post("a=1&b=2","1123.php",function(date){
	alert(date);
});*/
