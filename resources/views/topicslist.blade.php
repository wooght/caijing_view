@extends('layouts.adminlte')
<!--后台首页,默认文章列表-->
@section('header')
    分析文章列表
    <small>爬取分析文章列表,点击情感查看情感分析</small>
@endsection
@section('bread')
    <li><a href="#"><i class="fa fa-dashboard"></i> 首页</a></li>
    <li class="active">分析文章列表</li>
@endsection
@section('content')
<section class="content container-fluid" style="background-color:#fff;">
    <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <th>ID</th>
                      <th width="20%">URL</th>
                      <th>标题</th>
                      <th>打分</th>
                      <th>时间</th>
                    </tr>
                    @foreach($list as $one)
                    <tr>
                      <td>{{$one->id}}</td>
                      <td><a href="{{$one->url}}" target="_blank">{{$one->url}}</a></td>
                      <td><span class="badge bg-blue">{{$one->title}}</span></td>
                      <td>{{$one->Attitudes()->where('article_type','=','1')->count()}}</td>
                      <td>{{date('Y-m-d',$one->put_time)}}</td>
                    </tr>
                    @endforeach
                  </table>
                  {!!$fy!!}
                </div>
</section>
@endsection
