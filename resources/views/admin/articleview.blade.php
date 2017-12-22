@extends('layouts.adminlte')
<!--后台首页,默认文章列表-->
@section('header')
    帖子预览
    <small>帖子预览</small>
@endsection
@section('bread')
    <li><a href="#"><i class="fa fa-dashboard"></i> 首页</a></li>
    <li class="active">帖子预览</li>
@endsection
@section('content')
<section class="content container-fluid">
  <div class="col-md-6" style="width:80%; margin-top:50px; margin-left:100px;">
            <!-- Box Comment -->
            <div class="box box-widget">
              <div class="box-header with-border">
                <div class="user-block">
                  <img class="img-circle" src="/adminlte/dist/img/user1-128x128.jpg" alt="User Image">
                  <span class="username"><a href="#">{{$art->article_title}}</a></span>
                  <span class="description">{{$art->user->name}} - {{$art->created_at}}</span>
                </div>
              </div>
              <div class="box-body">
                {!!$art->article_body!!}
                <div class="attachment-block clearfix">
                  <img class="attachment-img" src="/adminlte/dist/img/photo1.png" alt="Attachment Image">
                  <div class="attachment-pushed">
                    <h4 class="attachment-heading"><a href="http://www.lipsum.com/">Lorem ipsum text generator</a></h4>
                    <div class="attachment-text">
                      Description about the attachment can be placed here.
                      Lorem Ipsum is simply dummy text of the printing and typesetting industry... <a href="#">more</a>
                    </div>
                  </div>
                </div>

                <!-- Social sharing buttons -->
                <button type="button" class="btn btn-default btn-xs"><i class="fa fa-share"></i> Share</button>
                <button type="button" class="btn btn-default btn-xs"><i class="fa fa-thumbs-o-up"></i> Like</button>
                <span class="pull-right text-muted">{{$art->reads}} 阅读 - {{$art->comments}} 评论</span>
              </div>
              <!-- /.box-body -->
              <div class="box-footer box-comments">
                @foreach($comts as $one)
                <div class="box-comment">
                  <!-- User image -->
                  <img class="img-circle img-sm" src="/adminlte/dist/img/user3-128x128.jpg" alt="User Image">

                  <div class="comment-text">
                        <span class="username">
                          {{$one->user->name}}
                          <span class="text-muted pull-right">{{$one->created_at}}</span>
                        </span>
                        {{$one->comment_body}}
                  </div>
                </div>
                @endforeach
              </div>
              <!-- /.box-footer -->
              <div class="box-footer">
                <form action="#" method="post">
                  <img class="img-responsive img-circle img-sm" src="/adminlte/dist/img/user4-128x128.jpg" alt="Alt Text">
                  <!-- .img-push is used to add margin to elements next to floating images -->
                  <div class="img-push">
                    <input type="text" class="form-control input-sm" placeholder="Press enter to post comment">
                  </div>
                </form>
              </div>
              <!-- /.box-footer -->
            </div>
            <!-- /.box -->
          </div>
</section>
@endsection
