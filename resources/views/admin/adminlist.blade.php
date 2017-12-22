@extends('layouts.adminlte')
<!--后台首页,默认文章列表-->
@section('header')
    用户管理
    <small>用户列表查看</small>
@endsection
@section('bread')
    <li><a href="#"><i class="fa fa-dashboard"></i> 首页</a></li>
    <li class="active">用户列表</li>
@endsection
@section('content')
<section class="content container-fluid">
  <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                  <tr>
                    <th>ID</th>
                    <th>用户名</th>
                    <th>email</th>
                    <th>管理分组</th>
                    <th>编辑时间</th>
                    <th>注册时间</th>
                    <th>编辑</th>
                  </tr>
                  @foreach($admin as $one)
                  <tr>
                    <td>{{$one->id}}</td>
                    <td>{{$one->name}}</td>
                    <td>{{$one->email}}</td>
                    <td><span class="badge bg-red">
                    @if(isset($one->roles[0]))
                    {{$one->roles[0]->display_name}}<!--正确访问方法为user->roles->display_name ?-->
                    @else
                    --------
                    @endif
                    <!--[{"id":12,"name":"admins","display_name":"\u7ba1\u7406\u5458","description":"\u7ba1\u7406\u5458","created_at":"2017-10-19 00:37:29","updated_at":"2017-10-19 00:37:29","pivot":{"user_id":3,"role_id":12}}]	-->
                    </span></td>
                    <td><span class="badge bg-blue">{{$one->updated_at}}</span></td>
                    <td>{{$one->created_at}}</td>
                    <td><span class="label label-success"><a style="color:#fff;" href='{{URL('/admin/admin/'.$one->id.'/edit')}}'>编辑</a></span></td>
                  </tr>
                  <form action="{{URL('admin/article/'.$one->id)}}" id='del_fm{{$one->id}}' style="display:none;" method="post">
                    <input name='_method' type="hidden" value='DELETE'><!--DELETE大写-->
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <!--不能input传递其他参数-->
                  </form>
                  @endforeach
                </table>
              </div>
</section>
@endsection
