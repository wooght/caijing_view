@extends('layouts.adminlte')
@section('header')
    组合调仓排行
    <small>对组合调仓量进行排行</small>
@endsection
@section('bread')
    <li><a href="#"><i class="fa fa-dashboard"></i> 首页</a></li>
    <li class="active">组合调仓</li>
@endsection
@section('content')
<section style="margin:auto; padding-top:20px; background-color:#fff;" class="content container-fluid">
  <table border='1' width="100%"><tr>
    <tr>
        <td width='25%'><div id="zh_count" style="width: 100%;height:600px;"></div></td>
        <td width='25%'><div id="zh_up5" style="width: 100%;height:600px;"></div></td>
        <td width='25%'><div id="zh_down" style="width: 100%;height:600px;"></div></td>
        <td width='25%'><div id="zh_down5" style="width: 100%;height:600px;"></div></td>
  </tr></table>
  <script src="{{asset("js/echarts.js")}}"></script>
  <script type="text/javascript">
  var zhcountchart = echarts.init(document.getElementById('zh_count'));
  var zhupchart5 = echarts.init(document.getElementById('zh_up5'));
  var zhdownchart = echarts.init(document.getElementById('zh_down'));
  var zhdownchart5 = echarts.init(document.getElementById('zh_down5'));

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

  zh_countname = [
      @foreach($zh_count as $key)
      @if($key->companys)
      ['{{$key->companys->name}}','{{$key->companys->codeid}}'],
      @endif
      @endforeach
  ]
  zh_countvalue = [
      @foreach($zh_count as $key)
      @if($key->companys)
      '{{$key->countt}}',
      @endif
      @endforeach
  ]

  zhupname5 = [
      @foreach($zh_up5 as $key)
      @if($key->companys)
      ['{{$key->companys->name}}','{{$key->companys->codeid}}'],
      @endif
      @endforeach
  ]
  zhupvalue5 = [
      @foreach($zh_up5 as $key)
      @if($key->companys)
      '{{$key->countt}}',
      @endif
      @endforeach
  ]

  zhdownname = [
      @foreach($zh_down as $key)
      @if($key->companys)
      ['{{$key->companys->name}}','{{$key->companys->codeid}}'],
      @endif
      @endforeach
  ]
  zhdownvalue = [
      @foreach($zh_down as $key)
      @if($key->companys)
      '{{$key->countt}}',
      @endif
      @endforeach
  ]

    zhdownname5 = [
        @foreach($zh_down5 as $key)
        @if($key->companys)
        ['{{$key->companys->name}}','{{$key->companys->codeid}}'],
        @endif
        @endforeach
    ]
    zhdownvalue5 = [
        @foreach($zh_down5 as $key)
        @if($key->companys)
        '{{$key->countt}}',
        @endif
        @endforeach
    ]
  zhup = get_option('一日加仓最多',zh_countname,zh_countvalue,'#777');
  zhup5 = get_option('五日加仓最多',zhupname5,zhupvalue5,'#777');
  zhdown = get_option('一日减仓最多',zhdownname,zhdownvalue,'#797');
  zhdown5 = get_option('五日减仓最多',zhdownname5,zhdownvalue5,'#797');
  zhcountchart.setOption(zhup);
  zhupchart5.setOption(zhup5);
  zhdownchart.setOption(zhdown);
  zhdownchart5.setOption(zhdown5);
  //点击事件
    function eConsole(param) {
        code_id = param.name.split(',')[1]
        window.location.href = "/companyone/id/"+code_id;
    }
    var ecConfig = echarts.config
  zhcountchart.on('click',eConsole);
  zhupchart5.on('click',eConsole);
  zhdownchart.on('click',eConsole);
  zhdownchart5.on('click',eConsole);
  </script>
</section>
@endsection
