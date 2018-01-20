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
    result = []
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
function get_quotes(url){
    $.get(url,function (data){
        var myChart = echarts.init(__('quotes'));
        var upColor = '#ec0000';
        var upBorderColor = '#8A0000';
        var downColor = '#00da3c';
        var downBorderColor = '#008F28';
        str_start = data.indexOf('保存中.....')
        if(str_start>0){
            data1 = data.split('保存中.....')
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
                    itemStyle: {
                        normal:{
                            color: '#e99'
                        }
                    }
                },
            ]
        };
        myChart.setOption(quotes_option);
    });
    return true;
}
