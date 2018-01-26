@extends('layouts.adminlte')
@section('header')
    热点排名
    <small>舆论,新闻报道量排名</small>
@endsection
@section('bread')
    <li><a href="#"><i class="fa fa-dashboard"></i> 首页</a></li>
    <li class="active">数据统计</li>
@endsection
@section('content')
<section style="margin:auto; padding-top:20px; background-color:#fff;" class="content container-fluid">
  <table border='1' width="100%"><tr>
    <td width='25%'><div id="news" style="width: 100%;height:600px;"></div></td>
    <td  width='25%'><div id="news5" style="width: 100%;height:600px;"></div></td>
    <td  width='25%'><div id="topic" style="width: 100%;height:600px;"></div></td>
    <td  width='25%'><div id="topic5" style="width: 100%;height:600px;"></div></td>
  </table>
  <script src="{{asset("js/echarts.js")}}"></script>
  <script type="text/javascript">
  var topicchart = echarts.init(document.getElementById('topic'));
  var newchart = echarts.init(document.getElementById('news'));
  var topicchart5 = echarts.init(document.getElementById('topic5'));
  var newchart5 = echarts.init(document.getElementById('news5'));

  function get_option(tname,namedata,valuedata,barcolor){
    option = {
        title: {
            text: tname,
            left: '2%'
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'shadow'
            }
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis: {
            type: 'value',
            boundaryGap: [0, 0.01],
        },
        yAxis: {
            type: 'category',
            data: namedata,
        },
        series: [
            {
                name: '关注',
                type: 'bar',
                data: valuedata,
            },
        ],
        itemStyle :{
            normal:{
                color: barcolor
            }
        },
    };
    return option;
  }
  topicname = [
    @foreach($topic as $key)
    ['{{$key->companys->name}}','{{$key->companys->codeid}}'],
    @endforeach
  ]
  topicvalue = [
    @foreach($topic as $key)
    '{{$key->countt}}',
    @endforeach
  ]

  newsname = [
    @foreach($news as $key)
    ['{{$key->companys->name}}','{{$key->companys->codeid}}'],
    @endforeach
  ]
  newsvalue = [
    @foreach($news as $key)
    '{{$key->countt}}',
    @endforeach
  ]

  newsname5 = [
    @foreach($news5 as $key)
    ['{{$key->companys->name}}','{{$key->companys->codeid}}'],
    @endforeach
  ]
  newsvalue5 = [
    @foreach($news5 as $key)
    '{{$key->countt}}',
    @endforeach
  ]

  topicname5 = [
    @foreach($topic5 as $key)
    ['{{$key->companys->name}}','{{$key->companys->codeid}}'],
    @endforeach
  ]
  topicvalue5 = [
    @foreach($topic5 as $key)
    '{{$key->countt}}',
    @endforeach
  ]
  topicoption = get_option('一日舆论',topicname,topicvalue,'#f77');
  newsoption = get_option('一日报道',newsname,newsvalue,'#9c9');
  topicoption5 = get_option('五日舆论',topicname5,topicvalue5,'#f77');
  newsoption5 = get_option('五日报道',newsname5,newsvalue5,'#9c9');

  topicchart.setOption(topicoption);
  newchart.setOption(newsoption);
  topicchart5.setOption(topicoption5);
  newchart5.setOption(newsoption5);

  //点击事件
    function eConsole(param) {
        code_id = param.name.split(',')[1]
        window.location.href = "/companyone/id/"+code_id;
    }
    var ecConfig = echarts.config
  newchart5.on('click', eConsole);
  topicchart5.on('click',eConsole);
  topicchart.on('click',eConsole);
  newchart.on('click', eConsole);

  </script>
</section>
@endsection
