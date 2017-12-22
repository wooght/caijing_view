@extends('layouts.adminlte')
<!--后台首页,默认文章列表-->
@section('header')
    主题帖子列表
    <small>管理主题帖子</small>
@endsection
@section('bread')
    <li><a href="#"><i class="fa fa-dashboard"></i> 首页</a></li>
    <li class="active">主题列表</li>
@endsection
@section('content')
<section class="content container-fluid">
  <form method="get" action="/admin/serach">
    <div class="input-group input-group-sm">
      <input name="title" type="text" class="form-control">
      <span class="input-group-btn">
        <button type="submit" class="btn btn-info btn-flat">Go!</button>
      </span>
    </div>
  </form>
  <div class="box-body table-responsive no-padding">
    <table class="table table-hover">
      <tr>
        <th>ID</th>
        <th>发布者</th>
        <th>标题</th>
        <th>阅读数</th>
        <th>评论数</th>
        <th>时间</th>
        <th>编辑</th>
      </tr>
      @foreach($list as $one)
      <tr>
        <td>{{$one->id}}</td>
        <td>{{$one->user->name}}</td>
        <td><a href="{{URL('admin/articleview/'.$one->id)}}">{{$one->article_title}}</a></td>
        <td><span class="badge bg-red">{{$one->reads}}</span></td>
        <td><span class="badge bg-blue">{{$one->comments}}</span></td>
        <td>{{$one->created_at}}</td>
        <td><span class="label label-success"><a style="color:#fff;" href='{{URL('admin/article/'.$one->id.'/edit')}}'>Edit</a></span></td>
        <td><span class="label label-warning"><a style="color:#fff;" href="#" onclick="document.getElementById('del_fm{{$one->id}}').submit();">Dll</a></span></td>
      </tr>
      <form action="{{URL('admin/article/'.$one->id)}}" id='del_fm{{$one->id}}' style="display:none;" method="post">
        <input name='_method' type="hidden" value='DELETE'><!--DELETE大写-->
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <!--不能input传递其他参数-->
      </form>
      @endforeach
    </table>
  </div>
  {!!$fy!!}
</section>
@endsection
