<header class="main-header">

  <!-- Logo -->
  <a href="{{ url('/') }}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini">WGT</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg">{{ config('app.name', 'caijing') }}</span>
  </a>

  <!-- Header Navbar -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" style="float:left;" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu" style="float:right; width:90%;">
      <ul class="nav navbar-nav">

        <!-- User Account Menu -->
        <li class="dropdown user user-menu" style="float:right; display:block;">
          <!-- Menu Toggle Button -->
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <!-- The user image in the navbar-->
            <img src="{{asset("adminlte/dist/img/user2-160x160.jpg")}}" class="user-image" alt="User Image">
            <!-- hidden-xs hides the username on small devices so only the image appears. -->
            <span class="hidden-xs">wooght</span>
          </a>
          <ul class="dropdown-menu">
            <!-- The user image in the menu -->
            <li class="user-header">
              <img src="{{asset("adminlte/dist/img/user2-160x160.jpg")}}" class="img-circle" alt="User Image">

              <p>
                Alexander Pierce - Web Developer
                <small>Member since Nov. 2012</small>
              </p>
            </li>
            <!-- Menu Body -->
            <li class="user-body">
              <div class="row">
                <div class="col-xs-4 text-center">
                  <a href="#">Followers</a>
                </div>
                <div class="col-xs-4 text-center">
                  <a href="#">Sales</a>
                </div>
                <div class="col-xs-4 text-center">
                  <a href="#">Friends</a>
                </div>
              </div>
              <!-- /.row -->
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="#" class="btn btn-default btn-flat">Profile</a>
              </div>
              <div class="pull-right">
                <a href="#" class="btn btn-default btn-flat">退出</a>
              </div>
            </li>
          </ul>
        </li>
        <!--登陆情况结束-->
        <li class="dropdown messages-menu" style="display:block; width:60%; float:right; padding-right:20px;">
            <form method="get" action="#" style="display:block;">
              <div class="input-group margin" style="width:100%; margin-top:10px;">
                <input type="text" id="codeid" class="form-control">
                <span class="input-group-btn">
                  <button type="button" onclick="go()" class="btn btn-info btn-flat">搜索</button>
                </span>
              </div>
            </form>
        </li>
      </ul>
    </div>
  </nav>
</header>
