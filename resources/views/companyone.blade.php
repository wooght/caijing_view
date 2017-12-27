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
    <div id="ddtj" style="width:50%;height:400px; float:left; margin-top:10px;"><img src="/pic/loading.gif"></div>
    <div id="topic" style="width:50%;height:400px; float:left;"><img src="/pic/loading.gif"></div>
    <div id="concept" style="width:50%;height:400px; float:left; margin-top:10px;"><img src="/pic/loading.gif"></div>
    <div id="attitudes" style="width:50%;height:400px; float:left; margin-top:10px;"><img src="/pic/loading.gif"></div>
    <div id="zuhe" style="width:50%;height:400px; float:left; margin-top:10px;"><img src="/pic/loading.gif"></div>
  </div>
  <script src="{{asset("js/echarts.js")}}"></script>
  <script type="text/javascript">
  attitudes = _ajax;
  //数据处理
  function splitData(rawData) {
      var categoryData = [];
      var values = [];
      var volumns = [];
      for (var i = 0; i < rawData.length; i++) {
          categoryData.push(rawData[i].splice(0, 1)[0]);
          values.push(rawData[i]);
          volumns.push(rawData[i][4]);
      }
      return {
          categoryData: categoryData,
          values: values,
          volumns: volumns
      };
  }
  //求均线
  function calculateMA(dayCount,data) {
      var result = [];
      for (var i = 0, len = data.values.length; i < len; i++) {
          if (i < dayCount) {
              result.push('-');
              continue;
          }
          var sum = 0;
          for (var j = 0; j < dayCount; j++) {
              sum += parseFloat(data.values[i - j][1]);
          }
          this_num = (sum/dayCount).toFixed(2);
          result.push(this_num);
      }
      return result;
  }

  /**
   * 获取行情数据
   *
   * @method get_quotes
   * @return [type]     [description]
   * [date]
   */
  function get_quotes(){
      url = "{{URL('api/attitudedata/quotes/'.$code_id)}}"
      _ajax.get('',url,function (data){
          var myChart = echarts.init(__('quotes'));
          var upColor = '#ec0000';
          var upBorderColor = '#8A0000';
          var downColor = '#00da3c';
          var downBorderColor = '#008F28';
          str_start = data.indexOf('========>>>>>>>>>>')
          if(str_start>0){
              data1 = data.split('========>>>>>>>>>>')
              data = data1[1]
          }
          // 数据意义：开盘(open)，收盘(close)，最低(lowest)，最高(highest)
          quotes = eval(data)
          data0 = splitData(quotes)
          //style,bar设定
          var quotes_option = {
              title: {
                  text: '行情',
                  left: '2%'
              },
              backgroundColor: '#eeebf0',
              //提示框组件。
              tooltip: {
                  trigger: 'axis',//触发类型 item 是指在散点图,饼图中触发,axis指在柱状图,折线图中触发,none指不触发
                  axisPointer: {
                      type: 'cross'//自动显示label
                  }
              },
              //需操作的图例组件
              legend: {
                  data: ['MA5', 'MA10', 'MA20', 'MA30'],
                  top: '2%'
              },
              //坐标指示器
              axisPointer: {
                  link: {xAxisIndex: 'all'},
                  label: {
                      backgroundColor: '#777'
                  }
              },
              // 用户交互图标工具栏
              // toolbox: {
              //     feature: {
              //         dataZoom: {
              //             yAxisIndex: false
              //         },
              //         brush: {
              //             type: ['lineX', 'clear']
              //         }
              //     }
              // },
              //直角坐标系绘图网格x,x1
              grid: [
                  {
                      left: '5%',
                      right: '2%',
                      height: '62%',
                      top: '10%'
                  },
                  {
                      left: '5%',
                      right: '2%',
                      bottom: '2%',
                      height: '20%'
                  }
              ],
              xAxis: [
                  {
                      type: 'category',
                      data: data0.categoryData,
                      scale: true,  //是否脱离0值比例
                      boundaryGap : false, //坐标轴留白
                      axisLine: {onZero: false}, //坐标轴线相关设置
                      splitLine: {show: false}, //是否显示分割标线
                      splitNumber: 20, //坐标轴的分割段数
                      min: 'dataMin',
                      max: 'dataMax',
                  },
                  {
                      type: 'category',
                      gridIndex: 1,
                      data: data0.categoryData,
                      scale: true,
                      boundaryGap : false,
                      axisLine: {onZero: false},
                      axisTick: {show: false},
                      splitLine: {show: false},
                      axisLabel: {show: false},
                      splitNumber: 20,
                      min: 'dataMin',
                      max: 'dataMax',
                  }
              ],
              yAxis: [
                  {
                      scale: true,
                      boundaryGap:false,
                      splitNumber:4,
                      min: 'dataMin',
                      max: 'dataMax',
                      splitArea: {
                          show: false   //在grid中的分割区域
                      }
                  },
                  {
                      scale: true,
                      gridIndex: 1,
                      splitNumber: 2,
                      axisLabel: {show: false},
                      axisLine: {show: false},
                      axisTick: {show: false},
                      splitLine: {show: false}
                  }
              ],
            //区域缩放组件x,x1
            dataZoom: [
                {
                    type: 'inside',
                    xAxisIndex: [0, 1],
                    start: 70,
                    end: 100
                },
                {
                    show: true,
                    xAxisIndex: [0, 1],
                    type: 'slider',
                    top: '95%',
                    start: 70,
                    end: 100
                }
            ],
              series: [
                  {
                      name: 'K线',
                      type: 'candlestick',  //candlestick 指K线图
                      dimensions: ['date', '开', '收', '底', '高'],
                      data: data0.values,
                      //元素样式
                      itemStyle: {
                          normal: {
                              //后面有0的未阴线颜色
                              color: upColor,
                              color0: downColor,
                              borderColor: upBorderColor,
                              borderColor0: downBorderColor
                          }
                      },
                      // 标线
                      // markLine: {
                      //     symbol: ['none', 'none'],
                      //     data: [
                      //         [
                      //             {
                      //                 name: 'from lowest to highest',
                      //                 type: 'min',
                      //                 valueDim: 'lowest',
                      //                 symbol: 'circle',
                      //                 symbolSize: 10,
                      //                 label: {
                      //                     normal: {show: false},
                      //                     emphasis: {show: false}
                      //                 }
                      //             },
                      //             {
                      //                 type: 'max',
                      //                 valueDim: 'highest',
                      //                 symbol: 'circle',
                      //                 symbolSize: 10,
                      //                 label: {
                      //                     normal: {show: false},
                      //                     emphasis: {show: false}
                      //                 }
                      //             }
                      //         ],
                      //     ]
                      // }
                  },
                  {
                      name: 'MA5',
                      type: 'line',
                      data: calculateMA(5,data0),
                      smooth: true,
                      lineStyle: {
                          normal: {opacity: 0.2,width:1}//opacity 透明度,width宽度
                      }
                  },
                  {
                      name: 'MA10',
                      type: 'line',
                      data: calculateMA(10,data0),
                      smooth: true,
                      lineStyle: {
                          normal: {opacity: 0.2,width:1}
                      }
                  },
                  {
                      name: 'MA20',
                      type: 'line',
                      data: calculateMA(20,data0),
                      smooth: true,
                      lineStyle: {
                          normal: {opacity: 0.2,width:1}
                      }
                  },
                  {
                      name: 'MA30',
                      type: 'line',
                      data: calculateMA(30,data0),
                      smooth: true,
                      lineStyle: {
                          normal: {opacity: 0.2,width:1}
                      }
                  },
                  {
                      name:'成交量',
                      type: 'bar',
                      data: data0.volumns,
                      yAxisIndex:1,
                      xAxisIndex:1,
                  },
              ]
          };
          myChart.setOption(quotes_option);
          get_data();
      });
  }

    /**
     * 涨跌幅，舆论评价
     * 异步加载数据
     */
    function get_data(){
      _ajax.get('','{{URL('api/attitudedata/topic/'.$code_id)}}',function (data){
          topic_charts = echarts.init(__('topic'));
          topic_charts.hideLoading();
          data = eval(data);
          time_data = [];
          zd_data = [];
          topic_data = [];
          news_data = [];
          news_count = [];
          topic_count = [];
          for(i=0;i<data.length;i++){
              time_data.push(data[i][0]);
              zd_data.push(data[i][1]);
              topic_count.push(data[i][4]);
              news_count.push(data[i][5]);
              topic = parseFloat(data[i][2]);
              if(topic<0.5 & topic!=0){
                  topic_data.push(topic-1);
              }else{
                  topic_data.push(topic);
              }
              news = parseFloat(data[i][3]);
              if(news<0.5 & news!=0){
                  news_data.push(news-1);
              }else{
                  news_data.push(news);
              }
          }
          option = {
              title: {
                  text: '舆情状态',
                  left: '2%'
              },
              grid: [{
                  left: '3%',
                  right: '2%',
                  bottom: '30%',
                  containLabel: false,//区域是否包含刻度标签
                  height: '60%'
              },{
                  left: '3%',
                  right: '2%',
                  bottom: '3%',
                  containLabel: false,
                  height: '25%'
              }],
              tooltip: {
                  trigger: 'axis',
                  axisPointer: {
                      type: 'cross'//自动显示label
                  }
              },
              //坐标指示器
              axisPointer: {
                  link: {xAxisIndex: 'all'},
                  label: {
                      backgroundColor: '#777'
                  }
              },
              //区域缩放组件x,x1
              dataZoom: [
                  {
                      type: 'inside',
                      start: 70,
                      end: 100,
                      xAxisIndex:[0,1]
                  },
              ],
              xAxis: [{
                  type: 'category',
                  boundaryGap: false,
                  data: time_data,
              },{
                  type: 'category',
                  data: time_data,
                  gridIndex:1,boundaryGap: false,
                  axisTick : {show: true}, //坐标轴刻度设置
                  axisLabel: {show:true}, //坐标轴标签设置
              }],
              yAxis: [{
                  type: 'value',
                  scale: true,  //是否脱离0值比例
                  boundaryGap : false, //坐标轴留白
              },{
                  type: 'value',
                  splitLine:{show:false,},
                  axisLabel:{show:false},axisTick:{show:false}
              },{
                  type: 'value',
                  gridIndex:1,splitLine:{show:false},splitNumber:2
              }],
              legend: {
                  data: ['涨跌幅', '舆论评价', '新闻评价']
              },
              series: [
                  {
                      name:'收盘',
                      type:'line',
                      stack: '收盘',
                      data:zd_data,
                      lineStyle: {
                          normal: {opacity: 0.2}
                      }
                  },
                  {
                      name:'舆论评价',
                      type:'bar',
                      data:topic_data,
                      stack:'attitude',
                      xAxisIndex:1,
                      yAxisIndex:2,
                  },
                  {
                      name:'新闻评价',
                      type:'bar',
                      data:news_data,
                      stack:'attitude',
                      xAxisIndex:1,
                      yAxisIndex:2,
                  },{
                      name:'评论量',
                      type:'bar',
                      data:topic_count,
                      yAxisIndex:1,
                      stack:'liang' //分组,分开显示还是重叠显示取决于是否有相同的stack
                  },{
                      name:'新闻量',
                      type:'bar',
                      data:news_count,
                      stack:'liang',
                      yAxisIndex:1
                  }
              ]
          };
          topic_charts.setOption(option);
          attitudes = _ajax;
          get_attitudes(attitudes)
      });
    }
    get_quotes();

    /**
     * 舆论热度与走势关系
     *
     * @method get_attitudes
     * @param  [type]        ajax [description]
     */
    function get_attitudes(ajax){
      ajax.get('','{{URL('api/attitudedata/attitudes/'.$code_id)}}',function (data){
          topic_charts = echarts.init(__('attitudes'));
          topic_charts.hideLoading();
          data = eval(data);
          time_data = [];
          zd_data = [];
          topic_data = [];
          news_data = [];
          for(i=0;i<data.length;i++){
              time_data.push(data[i][0]);
              zd_data.push(data[i][1]);
              topic = parseFloat(data[i][2]);
              topic_data.push(topic);
              news = parseFloat(data[i][3]);
              news_data.push(news);
          }
          option = {
              title: {
                  text: '舆论热度走势',
                  left: '2%',
              },
              grid: {
                  left: '3%',
                  right: '4%',
                  bottom: '3%',
                  containLabel: true
              },
              tooltip: {
                  trigger: 'axis'
              },
              dataZoom: [
                  {
                      type: 'inside',
                      start: 70,
                      end: 100
                  },
                  {
                      show: true,
                      type: 'slider',
                      top: '95%',
                      start: 70,
                      end: 100
                  }
              ],
              xAxis: {
                  type: 'category',
                  boundaryGap: false,
                  data: time_data,
              },
              yAxis: {
                  type: 'value'
              },
              legend: {
                  data: ['涨跌幅', '舆论', '新闻'],
                  top:'5%',
              },
              series: [
                  {
                      name:'涨跌幅',
                      type:'line',
                      stack: '涨跌幅',
                      data:zd_data,
                      lineStyle: {
                          normal: {opacity: 0.2}
                      }
                  },
                  {
                      name:'舆论',
                      type:'line',
                      stack: '舆论',
                      data:topic_data,
                  },
                  {
                      name:'新闻',
                      type:'line',
                      stack:'新闻',
                      data:news_data,
                  },
              ]
          };
          topic_charts.setOption(option);
          get_ddtj();
      });
    }

    /**
     * 大单统计
     *
     * @method get_ddtj
     */
    function get_ddtj(){
        _ajax.get('','{{URL('api/ddtj/'.$code_id)}}',function (data){
            ddtj = echarts.init(__('ddtj'));
            data = eval(data);
            time_data = [];
            zd_data = [];
            dk_data = [];
            totalvolpct = [];
            for(i=0;i<data.length;i++){
                time_data.push(data[i][0]);
                zd_data.push(data[i][1]);
                dk_data.push(parseFloat(data[i][2]));
                totalvolpct.push(data[i][3]);
            }
            option = {
                title: {
                    text:'主力动向与行情关系',top:'0%',left:'2%'
                },
                tooltip : {
                    trigger: 'axis',
                    axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                        type : 'shadow',        // 默认为直线，可选为：'line' | 'shadow'
                        type: 'cross'//自动显示label
                    }
                },
                legend: {
                    data:[ '收盘', '大单仓位','仓位比例']
                },
                grid:[
                    {
                        left:'5%',right:'8%',bottom:'30%',height:'60%'
                    },{
                        left:'5%',right:'8%',bottom:'2%',height:'20%'
                    }
                ],
                dataZoom: [
                    {
                        type: 'inside',
                        start: 70,
                        end: 100,
                        xAxisIndex:[0,1]
                    },
                    {
                        show: true,
                        type: 'slider',
                        top: '95%',
                        start: 70,
                        end: 100,
                        xAxisIndex:[0,1]
                    }
                ],
                yAxis : [
                    {
                        type : 'value',scale:true,boundaryGap:false,
                    },
                    {
                        type : 'value',scale:true,boundaryGap:false,
                        axisTick :{show:false},
                        splitLine:{show:false,}
                    },{
                        type:'value',gridIndex:1,splitNumber:2,scale:true,boundaryGap:false,
                    }
                ],
                xAxis : [
                    {
                        type : 'category',
                        axisTick : {show: false},
                        data : time_data,
                    },{
                        type:'category',data:time_data,gridIndex:1
                    }
                ],
                //坐标指示器
                axisPointer: {
                    link: {xAxisIndex: 'all'},
                    label: {
                        backgroundColor: '#777'
                    }
                },
                series : [
                    {
                        name:'收盘',
                        type:'line',
                        stack:'收盘',
                        label: {
                            normal: {
                                show: true,//是否显示值
                                position: 'right'//显示值的位置
                            }
                        },
                        data:zd_data
                    },
                    {
                        name:'大单仓位',
                        type:'line',
                        stack:'大单仓位',
                        yAxisIndex :1,
                        lineStyle:{
                            normal:{
                                color:'#777'
                            }
                        },
                        data:dk_data
                    },
                    {
                        name:'仓位比例',
                        type:'bar',
                        stack:'占总量',
                        data:totalvolpct,
                        xAxisIndex:1,
                        yAxisIndex:2,
                        itemStyle: {
                            normal: {opacity: 1,color:'#f77'}
                        }
                    },
                ]
            };
            ddtj.setOption(option);
            get_concept();
        });
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
        get_zhchange();
    }
    function get_zhchange(){
        _ajax.get('','{{URL('api/zuhe_change/'.$code_id)}}',function (data){
            zuhe_charts = echarts.init(__('zuhe'));
            zuhe_charts.hideLoading();
            data = eval(data);
            if(data == null){
                data = ['2017-01-01','0'];
            }
            change_data = [];
            time_data = [];
            zd_data = [];
            count_data = [];
            for(i=0;i<data.length;i++){
                time_data.push(data[i][0]);
                change_data.push(data[i][1]);
                zd_data.push(data[i][2]);
                count_data.push(data[i][3]);
            }
            option = {
                title: {
                    text: '组合调仓与行情关系',
                    left: '2%'
                },
                tooltip: {
                    trigger: 'axis'
                },
                dataZoom: [
                    {
                        type: 'inside',
                        xAxisIndex:[0,1],
                        start: 70,
                        end: 100
                    },
                    {
                        show: true,
                        xAxisIndex:[0,1],
                        type: 'slider',
                        top: '95%',
                        start: 70,
                        end: 100
                    }
                ],
                xAxis: [
                    {type: 'category',boundaryGap: false,data: time_data},
                    {type: 'category',data: time_data,gridIndex:1}
                ],
                yAxis: [
                    {type:'value',gridIndex:0,scale: true,boundaryGap : true,axisLine: {onZero: false},splitLine: {show: false}},
                    {type:'value',gridIndex:0,scale: true,boundaryGap : true,axisLine: {onZero: false},splitLine: {show: false}},
                    {type:'value',gridIndex:1,splitLine:{show:false},splitNumber:2}
                ],
                legend: {
                    data: ['仓位','收盘']
                },
                //提示框组件。
                tooltip: {
                    trigger: 'axis',//触发类型 item 是指在散点图,饼图中触发,axis指在柱状图,折线图中触发,none指不触发
                    axisPointer: {
                        type: 'cross'//自动显示label
                    }
                },
                //坐标指示器
                axisPointer: {
                    link: {xAxisIndex: 'all'},
                    label: {
                        backgroundColor: '#777'
                    }
                },
                grid: [
                    {
                        left: '5%',
                        right: '5%',
                        height: '62%',
                        top: '10%'
                    },
                    {
                        left: '5%',
                        right: '5%',
                        bottom: '2%',
                        height: '20%'
                    }
                ],
                series: [
                    {
                        name:'仓位',
                        type:'line',
                        stack: '仓位',
                        data:change_data,
                        yAxisIndex:1,
                        lineStyle: {
                            normal: {opacity: 0.8,color:'#777'}
                        },
                    },
                    {
                        name:'收盘',
                        type:'line',
                        stack: '收盘',
                        data:zd_data,
                        lineStyle: {
                            normal: {opacity: 0.8,color: 'red'}
                        },
                        label:{
                            normal:{
                                show:true,
                                position:'right'
                            }
                        }
                    },
                    {
                        name:'调仓数',
                        type:'bar',
                        stack:'调仓数',
                        data:count_data,
                        yAxisIndex:2,
                        xAxisIndex:1
                    }
                ],
            };
            zuhe_charts.setOption(option);
        });
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
