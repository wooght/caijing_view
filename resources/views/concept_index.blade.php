@extends('layouts.adminlte')
@section('header')
    概念股列表
@endsection
@section('content')
<section class="content container-fluid" style="background-color:#fff;">
  <div class="box-body table-responsive no-padding">
  @foreach($platelist as $one)
  <a href="/concept_list/id/{{$one->conceptid}}"><span
    @if($one->conceptid==$id)
    class="badge bg-red"
    @else
    class="badge bg-blue"
    @endif
    >{{$one->name}}{{$one->conceptid}}</span></a>
  @endforeach
  <hr />
  <table class="table table-hover">
    <tr>
      <th>代码</th>
      <th>名称</th>
      <th>地域</th>
      <th>板块</th>
      <th>今开</th>
      <th>当前</th>
      <th>涨幅</th>
      <th>昨收</th>
      <th>今高</th>
      <th>今底</th>
    </tr>
    @foreach($list as $one)
    <tr>
      <td><a href="{{URL('companyone/id/'.$one->codeid)}}"><span class="badge bg-red">{{$one->szshcode}}</span></a></td>
      <td><span class="badge bg-blue">{{$one->name}}</span></td>
      <td>{{$region[$one->region_id]}}</td>
      <td>{{$plates[$one->plate_id]}}</td>
      <td id='kai{{$one->codeid}}'></td>
      <td id='now{{$one->codeid}}'></td>
      <td id='zd_range{{$one->codeid}}'></td>
      <td id='before{{$one->codeid}}'></td>
      <td id='gao{{$one->codeid}}'></td>
      <td id='di{{$one->codeid}}'></td>
    </tr>
    @endforeach
  </table>
  {!!$fy!!}
</section>
<script id="ifload" type="text/javascript" src="http://hq.sinajs.cn/list=
@foreach($list as $one)
{{$one->szshcode}},
@endforeach
" charset="gb2312"></script>
<script type="text/javascript">
@foreach($list as $one)
var a = hq_str_{{$one->szshcode}}.split(',');
__('kai{{$one->codeid}}').innerHTML = a[1]
__('now{{$one->codeid}}').innerHTML = a[3]
__('before{{$one->codeid}}').innerHTML = a[2]
zd_range = parseFloat((a[3]-a[2])/a[2]).toFixed(4)*100
if(zd_range<0){
    zd_range_html = "<span style='color:#393'>"
}else{
    zd_range_html = "<span style='color:#f00'>"
}
zd_range_html+=zd_range+"</span>"
__('zd_range{{$one->codeid}}').innerHTML = zd_range_html
__('gao{{$one->codeid}}').innerHTML = a[4]
__('di{{$one->codeid}}').innerHTML = a[5]
@endforeach
</script>
<!-- <script type="text/javascript">
_ajax.get("","http://hq.sinajs.cn/list=sh601006",function(date){
  alert('aa')
});

</script> -->
@endsection
