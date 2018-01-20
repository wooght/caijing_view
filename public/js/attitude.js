/**
 * 涨跌幅，舆论评价
 * 异步加载数据
 */
function get_attitude(url){
  $.get(url,function (data){
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
  });
  return true;
}
