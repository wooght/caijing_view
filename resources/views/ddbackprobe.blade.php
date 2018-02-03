@extends('layouts.adminlte')
@section('header')
    结果/大单/组合速率比回测
    <small>回测数据对比</small>
@endsection
@section('bread')
    <li><a href="#"><i class="fa fa-dashboard"></i> 首页</a></li>
    <li class="active">回测数据</li>
@endsection
@section('content')
<section style="margin:auto; padding-top:20px; background-color:#fff;" class="content container-fluid">
    <h1 id = 'strategy'></h1>
    <span id="total_income" style="font-size:18px; color:red;">总收益:</span>--<span id='total_jia' style="font-size:18px; color:red;">建仓数:</span>----
    <span id="total_ycome" style="font-size:18px; color:red;">盈利:</span>--<span id="total_kcome" style="font-size:18px; color:green;">亏损:</span>
  <table border='1' width="100%"><tr>
    <td align="center" valign="middle"><div id="ddbackprobe" style="width: 100%;height:3000px;"><img src="/pic/loading.gif"></div></td>
  </table>
  <script src="{{asset("js/echarts.js")}}"></script>
  <script type="text/javascript">
  $.get('{{URL('api/ddbackprobe')}}',function (data){
      ddbackprobe = echarts.init(__('ddbackprobe'));
      data = eval('('+data+')')
      d = data.probe_data
      namedata = []
      incomedata = []
      maxdata = []
      mindata = []
      __('total_income').innerHTML += data['total_income']
      __('total_jia').innerHTML += data['total_jia']
      __('strategy').innerHTML += data['strategy']
      __('total_ycome').innerHTML += data['total_ycome']
      __('total_kcome').innerHTML += data['total_kcome']
      for(i=0;i<d.length;i++){
          namedata.push([d[i]['name'], d[i]['id']])
          incomedata.push(d[i]['income'])
          maxdata.push(d[i]['max'])
          mindata.push(d[i]['min'])
      }
    option = {
        title: {
            text: 'TOP100',
            left: '2%'
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'shadow'
            }
        },
        //坐标指示器
        axisPointer: {
            link: {yAxisIndex: 'all'},
            label: {
                backgroundColor: '#777'
            }
        },
        grid: [
            {
                left: '3%',
                right: '30%',
                bottom: '3%',
                containLabel: true
            },{
                left: '70%',
                containLabel: true,
                bottom: '3%',
            }

        ],
        xAxis: [
            {
                type: 'value',
                boundaryGap: [0, 0.01],
            },{
                type: 'value',
                gridIndex: 1,
                boundaryGap: [0, 0.01],
            }
        ],
        yAxis: [{
            type: 'category',
            data: namedata,
        },{
            type: 'category',
            data: namedata,
            gridIndex: 1
        }
        ],
        series: [
            {
                name: '总收益',
                type: 'bar',
                data: incomedata,
            },{
                name: '最大',
                type: 'bar',
                data: maxdata,
                xAxisIndex: 1,
                yAxisIndex: 1,
                stack: 'right_bar'
            },{
                name: '最小',
                type: 'bar',
                data: mindata,
                xAxisIndex: 1,
                yAxisIndex: 1,
                stack: 'right_bar'
            }
        ],
    };

  ddbackprobe.setOption(option);

  //点击事件
    function eConsole(param) {
        code_id = param.name.split(',')[1]
        window.location.href = "/companyone/id/"+code_id;
    }
    var ecConfig = echarts.config
  ddbackprobe.on('click', eConsole);
});

  </script>
</section>
@endsection
