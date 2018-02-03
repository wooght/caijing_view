/**
 * 大单统计
 *
 * @method get_ddtj
 */
function get_ddtj(url){
    $.get(url,function (data){
        ddtj = echarts.init(__('ddtj'));
        d = eval('('+data+')');
        data = d.is_data.dd_data;
        hc = d.is_data.hc;
        hc_jia = d.is_data.hc_jia;
        time_data = [];
        zd_data = [];
        dk_data = [];
        totalvolpct = [];
        hc_data = [];
        hc_jia_data = [];
        for(i=0;i<data.length;i++){
            time_data.push(data[i][0]);
            zd_data.push(data[i][1]);
            dk_data.push(parseFloat(data[i][2]));
            totalvolpct.push(data[i][3]);
        }
        for(i=0;i<hc.length;i++){
            hc_data.push([
                {
                    name: hc[i][2],
                    coord: hc[i][0],
                    symbol: 'circle', //circle 实心圆,rect实心方形,triangle箭头
                    symbolSize: 5,
                },
                {
                    coord: hc[i][1],
                    symbol: 'triangle',
                    symbolSize: 10,
                }
            ])
        }
        for(i=0;i<hc_jia.length;i++){
            hc_jia_data.push(
                {
                    coord: hc_jia[i],
                    symbol: 'rect',
                    symbolSize: 5,
                }
            )
        }
        option = {
            title: {
                text:'大单量速率比',top:'0%',left:'2%'
            },
            tooltip : {
                trigger: 'axis',
                axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                    type : 'shadow',        // 默认为直线，可选为：'line' | 'shadow'
                    type: 'cross'//自动显示label
                }
            },
            legend: {
                data:[ '收盘', '大单','占比']
            },
            grid:[
                {
                    left:'5%',right:'0%',bottom:'30%',height:'60%'
                },{
                    left:'5%',right:'0%',bottom:'2%',height:'20%'
                }
            ],
            dataZoom: [
                {
                    type: 'inside',
                    start: 70,
                    end: 100,
                    xAxisIndex:[0,1],
                    label:{
                        normal:{
                            color: '#99f'
                        }
                    }
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
                            show: false,//是否显示值
                            position: 'left',//显示值的位置
                        }
                    },
                    data:zd_data,
                    // 标线
                    markLine: {
                        symbol: ['none', 'none'],
                        data: hc_data,
                    },
                    markPoint:{
                        data: hc_jia_data,
                    },
                    lineStyle:{
                        normal:{
                            opacity: 0.3,
                            color: 'green',
                        }
                    }
                },
                {
                    name:'大单',
                    type:'line',
                    stack:'大单仓位',
                    yAxisIndex :1,
                    lineStyle:{
                        normal:{
                            color:'#777',
                            opacity:0.8
                        }
                    },
                    data:dk_data
                },
                {
                    name:'占比',
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
        ddtj_result(d)
    });
    return true;
}
function ddtj_result(d){
    ddhc = echarts.init(__('ddhc'));
    data = d.is_data.dd_data;
    time_data = [];
    dd_range = [];
    shou_range = [];
    total_income = [];
    for(i=0;i<data.length;i++){
        time_data.push(data[i][0]);
        dd_range.push(data[i][6]);
        shou_range.push(data[i][7]);
        total_income.push(data[i][8])
    }
    option = {
        title: {
            text:'速率回测结果',top:'0%',left:'2%'
        },
        tooltip : {
            trigger: 'axis',
            axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                type : 'line',        // 默认为直线，可选为：'line' | 'shadow'
                type: 'cross'//自动显示label
            }
        },
        grid:[
            {
                left: '45%', top:'5%', right:'2%', bottom:'35%', height:'55%'
            },{
                left: '45%', right:'2%', bottom:'5%', height: '30%'
            }
        ],
        yAxis : [
            {
                type : 'value',scale:true,boundaryGap:false,
            },{
                type : 'value',scale:true,boundaryGap:false,gridIndex:1
            }
        ],
        xAxis : [
            {
                type : 'category',
                axisTick : {show: false},
                data : time_data,
            },{
                type : 'category',
                axisTick : {show: false},
                data : time_data,
                gridIndex:1,
            }
        ],
        dataZoom: [
            {
                type: 'inside',
                start: 85,
                end: 100,
                xAxisIndex:[0,1],
                label:{
                    normal:{
                        color: '#99f'
                    }
                }
            },
            {
                show: true,
                type: 'slider',
                top: '95%',
                start: 85,
                end: 100,
                xAxisIndex:[0,1]
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
                name: '收益',
                type: 'line',
                data: total_income,
            },
            {
                name: '大',
                type: 'bar',
                data: dd_range,
                itemStyle:{
                    normal:{
                        color: '#f00'
                    }
                },
                yAxisIndex:1,
                xAxisIndex:1,
            },{
                name: '收',
                type: 'bar',
                data: shou_range,
                itemStyle:{
                    normal:{
                        color: '#a87'
                    }
                },
                yAxisIndex:1,
                xAxisIndex:1,
            },
            {
                type: 'pie',
                radius : ['10%', '30%'],  //圆饼大小比例
                center: ['20%', '30%'], //圆饼位置 x,y
                data:[
                    {value:d.is_nums, name:'有系数'+d.is_nums},
                    {value:d.no_nums, name:'无系数'+d.no_nums},
                    {value:d.is_jia, name:'有加'+d.is_jia},
                    {value:d.no_jia, name:'无加'+d.no_jia}
                ],
            },
            {
                type: 'pie',
                radius : ['10%', '30%'],  //圆饼大小比例
                zlevel : 100,
                center: ['20%', '80%'],
                data:[
                    {value:d.is_income, name:'有收益'+d.is_income},
                    {value:d.no_income, name:'无收益'+d.no_income}
                ]
            }
        ]
    };
    ddhc.setOption(option);
}
