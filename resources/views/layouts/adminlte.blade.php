<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.name', 'WOOGHT_STOCK') }}</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{asset("adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css")}}">
  <link rel="stylesheet" href="{{asset("adminlte/bower_components/font-awesome/css/font-awesome.min.css")}}">
  <link rel="stylesheet" href="{{asset("adminlte/bower_components/Ionicons/css/ionicons.min.css")}}">
  <link rel="stylesheet" href="{{asset("adminlte/dist/css/AdminLTE.min.css")}}">
  <link rel="stylesheet" href="{{asset("adminlte/dist/css/skins/skin-blue.min.css")}}">
  <link rel="stylesheet" href="{{asset("css/wooght.css")}}">
  <link href="{{asset('css/wooght.css')}}" rel="stylesheet" type="text/css">
  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <script src="{{asset("js/_ajax.js")}}"></script>
  <!-- jQuery 3 -->
  <script src="{{asset("adminlte/bower_components/jquery/dist/jquery.min.js")}}"></script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!--头部状态栏-->
  @include('layouts.admheader')
  <!--头部状态结束-->

  <!--左边菜单栏-->
  @include('layouts.admnav')
  <!--左边菜单栏节结束-->

  <!--主题内容-->
  <div class="content-wrapper" style="background-color:#eee;">
    <section class="content-header">
      <h1>
        @yield('header')
      </h1>
      <ol class="breadcrumb">
        <script type="text/javascript">
         id_input = document.getElementById('codeid');
         function go(){
           var codeid = id_input.value;
           window.location.href="/companyone/id/"+codeid;
         }
        </script>
      </ol>
    </section>
    <!-- Main content -->

      <!--主题内容-->
      @yield('content')
    <!-- /.content -->
  </div>
  <!--主题内容结束-->

  <!--页脚-->
  @include('layouts.admboot')
  <!--页脚结束-->
</div>

<!-- REQUIRED JS SCRIPTS -->
<!-- Bootstrap 3.3.7 -->
<script src="{{asset("adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js")}}"></script>
<!-- AdminLTE App -->
<script src="{{asset("adminlte/dist/js/adminlte.min.js")}}"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
</body>
</html>
