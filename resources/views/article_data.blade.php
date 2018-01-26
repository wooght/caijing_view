@extends('layouts.adminlte')
<!--后台首页,默认文章列表-->
@section('header')
    上证指数-舆情状态
@endsection
@section('content')
<section class="content container-fluid" style="background-color:#fff;">
  <div style="text-align:center;">
    <div id="topic" style="width:100%;height:600px; float:left;"><img src="/pic/loading.gif"></div>
  </div>
  <script src="{{asset("js/echarts.js")}}"></script>
  <script src="{{asset("js/attitude.js")}}"></script>
  <script type="text/javascript">
  get_attitude('{{URL('api/attitudedata/topic/1000001')}}')
  </script>
</section>
@endsection
