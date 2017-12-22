@extends('layouts.adminlte')
<!--后台首页,默认文章列表-->
@section('header')
    股票列表
    <small>股票列表点击查看行情</small>
@endsection
@section('bread')
    <li><a href="#"><i class="fa fa-dashboard"></i> 首页</a></li>
    <li class="active">用户列表</li>
@endsection
@section('content')
<section class="content container-fluid" style="background-color:#fff;">
  <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                  <tr>
                    <th>ID</th>
                    <th>代码</th>
                    <th>名称</th>
                    <th>地域</th>
                    <th>板块</th>
                    <th>注册</th>
                  </tr>
                  @foreach($list as $one)
                  <tr>
                    <td>{{$one->id}}</td>
                    <td><a href="{{URL('companyone/id/'.$one->codeid)}}"><span class="badge bg-red">{{$one->codeid}}</span></a></td>
                    <td><span class="badge bg-blue">{{$one->name}}</span></td>
                    <td>{{$region[$one->region_id]}}</td>
                    <td>{{$plates[$one->plate_id]}}</td>
                    <td><span class="label label-success"><a style="color:#fff;" href='{{URL('/admin/admin/'.$one->id.'/edit')}}'>编辑</a></span></td>
                  </tr>
                  @endforeach
                </table>
                {!!$fy!!}
              </div>
</section>
@endsection
