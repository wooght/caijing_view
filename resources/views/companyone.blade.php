@extends('layouts.adminlte')
<!--后台首页,默认文章列表-->
@section('header')
<div class="one_top">
    {{$company['name']}}[{{$company->codeid}}]&nbsp;&nbsp;<span class="font_12 left_20">当前价:<span id='nowprices'></span> 涨跌:<span id='zd_range'></span> 今开:<span id='kaiprices'></span> 昨收:<span id='shouprices'></span></span>
</div>
@endsection
@section('content')
<section class="content container-fluid" style="background-color:#fff;">
  <div style="text-align:center;">
    <div id="quotes" style="width: 50%;height:400px; float:left;"><img src="/pic/loading.gif"></div>
    <div id="topic" style="width:50%;height:400px; float:left;"><img src="/pic/loading.gif"></div>
    <div id="ddtj" style="width:50%;height:400px; float:left; margin-top:10px;"><img src="/pic/loading.gif"></div>
    <div id="ddhc" style="width:50%;height:400px; float:left; margin-top:10px;"><img src="/pic/loading.gif"></div>
    <div id="concept" style="width:50%;height:400px; float:left; margin-top:10px;"><img src="/pic/loading.gif"></div>
    <div id="attitudes" style="width:50%;height:400px; float:left; margin-top:10px;"><img src="/pic/loading.gif"></div>
    <div id="zuhe" style="width:50%;height:400px; float:left; margin-top:10px;"><img src="/pic/loading.gif"></div>
  </div>
  <script src="{{asset("js/echarts.js")}}"></script>
  <script src="{{asset("js/quotes.js")}}"></script>
  <script src="{{asset("js/attitude.js")}}"></script>
  <script src="{{asset("js/attitudes.js")}}"></script>
  <script src="{{asset("js/ddtj.js")}}"></script>
  <script src="{{asset("js/zuhe_change.js")}}"></script>
  <script type="text/javascript">
  if(get_quotes('{{URL('api/attitudedata/quotes/'.$code_id)}}')){
      if(get_attitude('{{URL('api/attitudedata/topic/'.$code_id)}}')){
          if(get_attitudes('{{URL('api/attitudedata/attitudes/'.$code_id)}}')){
              if(get_ddtj('{{URL('api/ddtj/'.$code_id)}}')){
                  get_zhchange('{{URL('api/zuhe_change/'.$code_id)}}');
                  get_concept();
              }
          }
      }
  }
    function get_concept(){
        option = {
            title:{
                text:'概念关系',
                textStyle:{
                    fontSize:16,
                    textBorderColor:'#ccc', //文本描边颜色
                    textBorderWidth:2   //文本描边宽度
                },
            },
            tooltip: {},
            animationDurationUpdate: 100,
            animationEasingUpdate: 'quinticInOut',
            series : [
                {
                    type: 'graph',
                    layout: 'circular', //环形布局 none只采用x,y坐标进行布局
                    symbolSize: [60,40], //节点大小 可以是[单个数字],也可以是[宽,高]这样的数字
                    roam: true, //开启鼠标点击
                    label: {
                        normal: {
                            show: true
                        }
                    },
                    //edge 节点关系控制
                    edgeSymbol: ['circle', 'arrow'],
                    edgeSymbolSize: [1, 1], //连接线两端大小
                    edgeLabel: {
                        normal: {
                            textStyle: {
                                fontSize: 12
                            }
                        }
                    },
                    data: [
                        {
                            name:'{{$company->name}}',
                            itemStyle:{
                                normal:{
                                    color:'#f33'
                                }
                            },
                            layout:'circular',
                            circular:{
                                rotateLabel:true
                            }
                        },

                        @foreach($concept_arr as $a)
                        {
                            name:'{{$a}}',
                            itemStyle:{
                                normal:{
                                    color:'#c79'
                                }
                            }
                        },
                        @endforeach
                    ],
                    links: [
                        @foreach($concept_arr as $a)
                        {
                            source:'{{$company->name}}',
                            target:'{{$a}}'
                        },
                        @endforeach
                    ],
                    lineStyle: {
                        normal: {
                            opacity: 0.2,   //透明度
                            width: 1,   //线宽
                            curveness: 0.5, //曲度
                            color:{
                                //线性渐变
                                type: 'linear',
                                x: 0,
                                y: 0,
                                x2: 1,
                                y2: 1,
                                colorStops: [{
                                    offset: 0, color: '#c79' // 0% 处的颜色
                                }, {
                                    offset: 1, color: '#f33' // 100% 处的颜色
                                }],
                                globalCoord: false // 缺省为 false
                            }
                        }
                    }
                }
            ]
        };
        concept = echarts.init(__('concept'));
        concept.setOption(option);
    }
  </script>
  <script id="ifload" type="text/javascript" src="http://hq.sinajs.cn/list={{$company->shsz}}" charset="gb2312"></script>
  <script type="text/javascript">
  var a = hq_str_{{$company->shsz}}.split(',');
  __('kaiprices').innerHTML = a[1]
  __('nowprices').innerHTML = a[3]
  __('shouprices').innerHTML = a[2]
  zd_range = parseFloat((a[3]-a[2])/a[2]).toFixed(4)*100
  if(zd_range<0){
      zd_range_html = "<span style='color:#393'>"
  }else{
      zd_range_html = "<span style='color:#f00'>"
  }
  zd_range_html+=zd_range+"</span>"
  __('zd_range').innerHTML = zd_range_html
  </script>
</section>
@endsection
