@extends('layouts.adminlte')
@section('header')
    数据概括
    <small>统计数据概括</small>
@endsection
@section('bread')
    <li><a href="#"><i class="fa fa-dashboard"></i> 首页</a></li>
    <li class="active">数据统计</li>
@endsection
@section('content')
<section style="margin:auto; padding-top:20px;" class="content container-fluid">
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
          <span class="info-box-icon bg-aqua"><i class="fa fa-envelope-o"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">可分析股票数</span>
            <span class="info-box-number">{{$companys}}</span>
          </div>
    </div>
  </div>

  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-green"><i class="fa fa-flag-o"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">统计板块数</span>
        <span class="info-box-number">{{$plates}}</span>
      </div>
    </div>
  </div>

  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-red"><i class="fa fa-star-o"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">统计区域数</span>
        <span class="info-box-number">{{$region}}</span>
      </div>
    </div>
  </div>

  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
          <span class="info-box-icon bg-aqua"><i class="fa fa-envelope-o"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">拥有历史行情股票数</span>
            <span class="info-box-number">{{$quotes}}</span>
          </div>
    </div>
  </div>

  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-green"><i class="fa fa-flag-o"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">爬取新闻数</span>
        <span class="info-box-number">{{$news}}</span>
      </div>
    </div>
  </div>

  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-red"><i class="fa fa-star-o"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">爬取分析文章数</span>
        <span class="info-box-number">{{$topic}}</span>
      </div>
    </div>
  </div>

  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
          <span class="info-box-icon bg-aqua"><i class="fa fa-envelope-o"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">爬取公告数</span>
            <span class="info-box-number">{{$notices}}</span>
          </div>
    </div>
  </div>
  <table width="100%" style="background-color:#fff;"><tr>
    <td width='50%'><div id="topic" style="width: 100%;height:400px;"><img src="/pic/loading.gif"></div></td>
    <td><div id="news" style="width: 100%;height:400px;"><img src="/pic/loading.gif"></div></td>
  </tr></table>
  <script src="{{asset("js/echarts.js")}}"></script>
  <script type="text/javascript">
  var topicchart = echarts.init(document.getElementById('topic'));
  var newchart = echarts.init(document.getElementById('news'));
  function get_option(tname,namedata,valuedata){
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
            boundaryGap: [0, 0.01]
        },
        yAxis: {
            type: 'category',
            data: namedata,
        },
        series: [
            {
                name: '总计',
                type: 'bar',
                data: valuedata,
            },
        ]
    };
    return option;
  }
  $.get('{{URL('api/article_nums')}}',function (data){
      data = eval("("+data+")")
      topicname = []
      topicvalue = []
      newsname = []
      newsvalue = []
      for(i in data[0]){
          topicname.push(i)
          topicvalue.push(data[0][i])
      }
      for(i in data[1]){
          newsname.push(i)
          newsvalue.push(data[1][i])
      }
      topicoption = get_option('topic统计',topicname,topicvalue);
      newsoption = get_option('news统计',newsname,newsvalue);
      topicchart.setOption(topicoption);
      newchart.setOption(newsoption);
  })
  </script>
  <!-- <table width="100%" align="center">
    <tr>
      <td align="right"><img src="total_classfaly_pic/news_total.png" ></td>
      <td align="left"> <img src="total_classfaly_pic/topic_total.png" ></td>
    </tr>
  </table> -->
</section>
@endsection
