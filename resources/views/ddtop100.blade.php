@extends('layouts.adminlte')
@section('header')
    TOP50末日状态
    <small>热点之大单TOP末日状态</small>
@endsection
@section('bread')
    <li><a href="#"><i class="fa fa-dashboard"></i> 首页</a></li>
    <li class="active">热点统计</li>
@endsection
@section('content')
<section style="margin:auto; padding-top:20px; background-color:#fff;" class="content container-fluid">
  <table border='1' width="100%"><tr>
    <td align="center" valign="middle"><div id="ddtop100" style="width: 100%;height:1200px;"><img src="/pic/loading.gif"></div></td>
  </table>
  <script src="{{asset("js/echarts.js")}}"></script>
  <script type="text/javascript">
  $.get('{{URL('api/ddtop100')}}',function (data){
      ddtop100 = echarts.init(__('ddtop100'));
      d = eval(data)
      namedata = []
      valuedata = []
      statusdata = []
      pctdata = []
      for(i=0;i<d.length;i++){
          namedata.push([d[i][1], d[i][0]])
          valuedata.push(d[i][3])
          statusdata.push(d[i][2])
          pctdata.push(d[i][4])
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
        }],
        //坐标指示器
        axisPointer: {
            link: {yAxisIndex: 'all'},
            label: {
                backgroundColor: '#777'
            }
        },
        series: [
            {
                name: '末日',
                type: 'bar',
                data: valuedata,
                itemStyle: {
                    normal:{
                        color: 'red'
                    }
                }
            },{
                name: '状态',
                type: 'bar',
                data: statusdata,
                xAxisIndex: 1,
                yAxisIndex: 1
            },{
                name: '平均',
                type: 'bar',
                data: pctdata,
                itemStyle:{
                    normal: {
                        color: '#777'
                    }
                }
            }
        ],
    };

  ddtop100.setOption(option);

  //点击事件
    function eConsole(param) {
        code_id = param.name.split(',')[1]
        window.location.href = "/companyone/id/"+code_id;
    }
    var ecConfig = echarts.config
  ddtop100.on('click', eConsole);
});

  </script>
</section>
@endsection
