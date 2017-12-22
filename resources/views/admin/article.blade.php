@extends('layouts.adminlte')

@section('header')
    编辑主题
    <small>编辑主题帖子</small>
@endsection
@section('bread')
    <li><a href="{{URL('admin')}}"><i class="fa fa-dashboard"></i> 主题管理</a></li>
    <li class="active">编辑帖子</li>
@endsection
@section('content')
<section class="content container-fluid">
      @if(count($errors)>0)
      <div class="blog_errors">
      !!!!内容填写有误,修改失败:
      @foreach($errors->all() as $error)
      {{$error}}
      @endforeach
      </div>
      @endif
      @if(session('ok'))
      {!!alert(session('ok'))!!}
      @endif
    <form method="post" action="{{URL('admin/article/'.$arts->id)}}">
      <div class="form-group">
        <label for="exampleInputEmail1">主题标题</label>
        <input type="" name="title" value="{{$arts->article_title}}" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
      </div>
      <div id="ueditor" name='body' class="edui-default">
        <label>正文:</label>
        @include('UEditor::head')
      </div>

      <input type="hidden" name="id" value="{{$arts->id}}" />
      <input type="hidden" name="_token" value="{{ csrf_token() }}"><!--Laravel通过post提交的表单必须有csrf-->
      <input name="_method" type="hidden" value="PUT">
      <div class="box-footer">
                <button type="submit" class="btn btn-primary">提交</button>
      </div>
    </form>
  </div>
</section>
<script id="ueditor"></script>
<script>
  var ue=UE.getEditor("ueditor",{
    //toolbars:[
    //  ['Undo','Bold','Image']
    //],
    initialFrameHeight:200,
    autoClearinitialContent:true
  });
  ue.ready(function(){
       //因为Laravel有防csrf防伪造攻击的处理所以加上此行
       ue.execCommand('serverparam','_token','{{ csrf_token() }}');
       ue.setContent("{!!$arts->article_body!!}");
  });
</script>
@endsection
