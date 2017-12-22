@extends('layouts.adminlte')
<!--后台首页,默认文章列表-->
@section('header')
    评论列表
    <small>评论列表</small>
@endsection
@section('bread')
    <li><a href="#"><i class="fa fa-dashboard"></i> 首页</a></li>
    <li class="active">评论列表</li>
@endsection
@section('content')
<section class="content container-fluid">
  @if(session('ok'))
  {!!alert(session('ok'))!!}
  @endif
  <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                  <tr>
                    <th>ID</th>
                    <th>发布者</th>
                    <th>内容</th>
                    <th>时间</th>
                    <th>编辑</th>
                  </tr>
                  @foreach($comts as $one)
                  <tr>
                    <td>{{$one->id}}</td>
                    <td><span class="badge bg-blue" style="font-size:10px; display:hidden;">{{$one->user->name}}</span></td>
                    <td>{{$one->comment_body}}</td>
                    <td>{{$one->created_at}}</td>
                    <td><span class="label label-warning"><a style="color:#fff;" href="#" onclick="document.getElementById('del_fm{{$one->id}}').submit();">Dll</a></span></td>
                  </tr>
                  <form action="{{URL('admin/comment/'.$one->id)}}" id='del_fm{{$one->id}}' style="display:none;" method="post">
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
