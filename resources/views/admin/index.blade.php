@extends('layouts.adminlte')
<!--后台首页,默认文章列表-->
@section('header')
    数据概括
    <small>用户参与度,地区数据统计</small>
@endsection
@section('bread')
    <li><a href="#"><i class="fa fa-dashboard"></i> 首页</a></li>
    <li class="active">数据统计</li>
@endsection
@section('content')
<section style="margin:auto; padding-top:100px;" class="content container-fluid">
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
          <span class="info-box-icon bg-aqua"><i class="fa fa-envelope-o"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">文章总数</span>
            <span class="info-box-number">{{$num['articles_num']}}</span>
          </div>
    </div>
  </div>

  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-green"><i class="fa fa-flag-o"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">评论总数</span>
        <span class="info-box-number">{{$num['comments_num']}}</span>
      </div>
    </div>
  </div>

  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-red"><i class="fa fa-star-o"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">注册用户</span>
        <span class="info-box-number">{{$num['users_num']}}</span>
      </div>
    </div>
  </div>

  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-red"><i class="fa fa-star-o"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">注册地区</span>
        <span class="info-box-number">{{$area->count()}}</span>
      </div>
    </div>
  </div>
  <div style="width:80%; margin:auto;">
    <div class="col-md-4" style="width:100%;margin-top:50px;">
      <p class="text-center">
        <strong>地区用户及比例</strong>
      </p>
      @foreach($area as $one)
      <div class="progress-group">
        <span class="progress-text">{{$one->area_name}}</span>
        <span class="progress-number"><b>{{$one->user->count()}}/</b>{{$num['users_num']}}</span>
        <div class="progress sm">
          <div class="progress-bar progress-bar-{{$color[rand(0,3)]}}" style="width: {{($one->user->count()/$num['users_num'])*100}}%"></div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endsection
