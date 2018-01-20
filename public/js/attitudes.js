/**
 * 舆论热度与走势关系
 *
 * @method get_attitudes
 * @param  [type]        ajax [description]
 */
function get_attitudes(url){
  $.get(url,function (data){
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
  });
  return true;
}
