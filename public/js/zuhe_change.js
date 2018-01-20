/**
 * 组合调仓
 *
 * @method get_zhchange
 */
function get_zhchange(url){
    $.get(url,function (data){
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
