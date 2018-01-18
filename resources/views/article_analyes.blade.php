@extends('layouts.adminlte')
<!--后台首页,默认文章列表-->
@section('header')
    文章分析详情
    <small></small>
@endsection
@section('bread')
    <li><a href="#"><i class="fa fa-dashboard"></i> 首页</a></li>
    <li class="active">文章分析详情</li>
@endsection
@section('content')
<section class="content container-fluid" style="background-color:#fff;">
    <div id = 'article_title'></div>
    <table border="1" width="100%">
        <tr><td width="20%"><div id='article_zf'></div></td>
            <td width="20%"><div id="article_key"></div></td>
            <td><div id="article_body"></div></td>
        </tr>
    </table>
    <table width="100%" border="1" id="article_ju">
        <td width="70%"></td><td></td>
    </table>
    <table id="words">
        <tr>
            <td></td><td></td><td></td><td></td>
        </tr>
    </table>
    <script type="text/javascript">
    url = "{{URL('api/article_analyes/'.$id.'?12321')}}"
    _ajax.get('',url,function (data){
        //eval 对json格式的应用
        listdata = eval('('+data+')')
        __('article_title').innerHTML=listdata.title;
        __('article_body').innerHTML = listdata.body;
        for(i=0;i<listdata.ju.length;i++){
            __('article_ju').innerHTML+='<tr><td>'+listdata.ju[i][0]+'</td><td>打分:'+listdata.ju[i][1]+'</td></tr>'
        }
        for(i=0;i<listdata.keywords.length;i++){
            __('article_key').innerHTML+=listdata.keywords[i][0]+',词性:'+listdata.keywords[i][1]+',权重:'+listdata.keywords[i][2]+'<br />'
        }
        for(i=0;i<listdata.zf.length;i++){
            __('article_zf').innerHTML+=listdata.zf[i][0]+',权重:'+listdata.zf[i][1]+',总分:'+listdata.zf[i][2]+'<br />'
        }
        for(i=0;i<listdata.words.length;i++){
            __('words').innerHTML+='<tr><td>'+listdata.words[i][0]+'</td><td>词性:'+listdata.words[i][1]+'</td><td>情感pos频率:'+listdata.words[i][2]+'</td><td>情感neg频率:'+listdata.words[i][3]+'</tr>';
        }
    })
    </script>
</section>
@endsection
