@extends('layouts.adminlte')
<!--后台首页,默认文章列表-->
@section('header')
    管理员管理
    <small>编辑用户</small>
@endsection
@section('bread')
    <li><a href="#"><i class="fa fa-dashboard"></i> 首页</a></li>
    <li class="active">编辑用户</li>
@endsection
@section('content')
<section class="content container-fluid">
    <div class="form-group">
      <form style="width:70%; margin:auto; margin-top:20px;" method="post" action="{{URL('admin/admin/'.$admin->id)}}">
        @if(count($errors)>0)
        <div class="blog_errors">
        !!!!内容填写有误,修改失败:
        @foreach($errors->all() as $error)
        {{$error}}
        @endforeach
        </div>
        @endif
                <input type="hidden" value="{{$admin->id}}" name="id">
                <div class="form-group">
                  <label for="exampleInputEmail1">用户名</label>
                  <input name="name" class="form-control" id="exampleInputEmail1" value="{{$admin->name}}" placeholder="用户名">
                </div>
                <label>权限级别</label>
                <select name="role_id" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                  @foreach($role as $one)
                  <option value="{{$one->id}}"
                    @if(isset($admin->roles[0]))
                    @if($admin->roles[0]['id']==$one->id)
                     selected="selected"
                    @endif
                    @endif
                     >{{$one->display_name}}</option>
                  @endforeach
                </select>
                <span class="select2 select2-container select2-container--default select2-container--below" dir="ltr" style="width: 80%;"></span>
                <div class="form-group">
                  <label for="exampleInputEmail1">邮箱(登录账号)</label>
                  <input disabled type="email" class="form-control" id="exampleInputEmail1" value="{{$admin->email}}" placeholder="邮箱">
                </div>
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="PUT">
                <div class="box-footer">
                  <button type="submit" class="btn btn-default">取消</button>
                  <button type="submit" class="btn btn-info pull-right">保存更改</button>
                </div>
      </form>
    </div>
</section>
@endsection
