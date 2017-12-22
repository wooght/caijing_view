<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu" data-widget="tree">
        <li class="header">选取股票</li>
        <li class="treeview active menu-open">
            <a href="#">
              <i class="fa fa-table"></i> <span>股票列表</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{URL('companyslist')}}"><i class="fa fa-circle-o">所有股票</i></a></li>
              <li><a href="{{URL('plate_list')}}"><i class="fa fa-circle-o">板块查询</i></a></li>
              <li><a href="{{URL('admin/adminlist')}}"><i class="fa fa-circle-o">地域查询</i></a></li>
              <li><a href="{{URL('redian_list')}}"><i class="fa fa-circle-o">热点追踪</i></a></li>
            </ul>
        </li>
        <li class="treeview">
            <a href="#">
            <i class="fa fa-edit"></i> <span>概念股</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{URL('concept_list')}}"><i class="fa fa-circle-o">概念列表</i></a></li>
            </ul>
        </li>
        <li class="header">数据查看</li>
        <li class="treeview active menu-open">
            <a href="#">
              <i class="fa fa-pie-chart"></i>
              <span>选取数据</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{URL('news_list/page/1')}}"><i class="fa fa-circle-o">新闻列表</i></a></li>
              <li><a href="{{URL('topics_list/page/1')}}"><i class="fa fa-circle-o">分析文章</i></a></li>
              <li><a href="{{URL('admin/adminlist')}}"><i class="fa fa-circle-o">地域查询</i></a></li>
            </ul>
        </li>
        <li class="header">爬虫管理</li>
        <li class="treeview active menu-open">
            <a href="#">
                <i class="fa fa-laptop"></i>
                <span>爬虫操作</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class='action'><a href="general.html"><i class="fa fa-circle-o"></i> 爬虫列表</a></li>
            </ul>
        </li>
    </ul>
  </section>
</aside>
