@extends('layout')

@section('content')

<div class="container">
        <div class="logo"><a href="/">
       @php  $department = getPrentDepartmentID(session('department_id')); echo $department->name   @endphp : {{session('nick_name')}}</a></div>

        <div class="left_open">
            <i title="展开左侧栏" class="iconfont">&#xe699;</i>
        </div>

        <ul class="layui-nav left fast-add"  id="top-menu" lay-filter="">
              @foreach($firstMenus as $menu)
                <li class="layui-nav-item" data="{{$menu->id}}" >
                  <a href="javascript:;" >{{$menu->name}}</a>
                </li>
              @endforeach
        </ul>




        <ul class="layui-nav left fast-add"  id="top-time" lay-filter=""
style="margin-left: 200px">
           　<li class="layui-nav-item " id="Date"　></li>
            <li class="layui-nav-item">　</li>
            <li class="layui-nav-item" id="hours"> </li>
            <li class="layui-nav-item" id="point">:</li>
            <li class="layui-nav-item" id="min"> </li>
            <li class="layui-nav-item" id="point">:</li>
            <li class="layui-nav-item" id="sec"> </li>
        </ul>



        <ul class="layui-nav right" lay-filter="">


          <li class="layui-nav-item">
            <a href="javascript:;">{{session('role_name')}}</a>
            <dl class="layui-nav-child"> <!-- 二级菜单 -->
              <dd><a onclick="x_admin_show('个人信息','http://www.baidu.com')">个人信息</a></dd>
              <dd><a onclick="x_admin_show('切换帐号','http://www.baidu.com')">切换帐号</a></dd>
              <dd><a href="/outLogin">退出</a></dd>
            </dl>
          </li>

        </ul>

    </div>
    <!-- 顶部结束 -->
    <!-- 中部开始 -->
     <!-- 左侧菜单开始 -->
    <div class="left-nav">
      <div id="side-nav">
        <ul id="nav">

        </ul>
      </div>
    </div>
    <!-- <div class="x-slide_left"></div> -->
    <!-- 左侧菜单结束 -->
    <!-- 右侧主体开始 -->
    <div class="page-content">
        <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
          <ul class="layui-tab-title">
            <li class="home"><i class="layui-icon">&#xe68e;</i>我的桌面</li>
          </ul>
          <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <iframe src='/welcome' frameborder="0" scrolling="yes" class="x-

iframe"></iframe>
            </div>
          </div>
        </div>
    </div>
    <div class="page-content-bg"></div>
    <!-- 右侧主体结束 -->
    <!-- 中部结束 -->
    <!-- 底部开始 -->
    <div class="footer">
        <div class="copyright">Copyright ©2017 x-admin v2.3 All Rights

Reserved</div>
    </div>



@endsection



@section('js')


<script type="text/javascript">
$(document).ready(function() {

  // 创建两个变量，一个数组中的月和日的名称
  var monthNames = [ "1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月",

"10月", "11月", "12月" ];
  var dayNames= ["星期日","星期一","星期二","星期三","星期四","星期五","星期六"]

  // 创建一个对象newDate（）
  var newDate = new Date();
  // 提取当前的日期从日期对象
  newDate.setDate(newDate.getDate());
  //输出的日子，日期，月和年
  $('#Date').html(newDate.getFullYear() + "年" + monthNames[newDate.getMonth()] +

'' + newDate.getDate() + '号　' + dayNames[newDate.getDay()]);

  setInterval( function() {
    // 创建一个对象，并提取newDate（）在访问者的当前时间的秒
    var seconds = new Date().getSeconds();
    //添加前导零秒值
    $("#sec").html(( seconds < 10 ? "0" : "" ) + seconds);
  },1000);

  setInterval( function() {
    // 创建一个对象，并提取newDate（）在访问者的当前时间的分钟
    var minutes = new Date().getMinutes();
    // 添加前导零的分钟值
    $("#min").html(( minutes < 10 ? "0" : "" ) + minutes);
    },1000);

  setInterval( function() {
    // 创建一个对象，并提取newDate（）在访问者的当前时间的小时
    var hours = new Date().getHours();
    // 添加前导零的小时值
    $("#hours").html(( hours < 10 ? "0" : "" ) + hours);
    }, 1000);

});
</script>


<script type="text/javascript">

      $('#top-menu li:eq(0)').addClass('layui-this');

      id = $('#top-menu li:eq(0)').attr('data');

      //点击li 调用该ID下面的菜单
      $("#top-menu li").click(function(){
          id = $(this).attr('data');
          getMenuData(id);
      });

      getMenuData(id); //调用函数

      function getMenuData(id)
      {
         if (checkUrl() == false) {
              return;
          }

          // 获取子菜单
          $.post('/rbac/menu/get_submenu',{id:id,'_token':"{{csrf_token()}}"},function(res){

              var str = '';

              $.each(res, function(k,v){

                  if (v.level == 2) {
                    str += '<li>';

                    str += '<a href="javascript:;"><i class="iconfont">&#xe'+v.icons+';</i><cite>'+v.name+'</cite><i class="iconfont nav_right">&#xe697;</i></a>';



                    str += '<ul class="sub-menu">';

                      $.each(res, function(kk,vv){
                          if (vv.pid == v.id) {
                              str += '<li data_id="'+vv.id+'">';
                              str += '<a _href="'+vv.router+'">';
                              str += '<i class="iconfont">&#xe6a7;</i>';
                              str += '<cite>'+vv.name+'</cite>';
                              str += '</a>';
                              str += '</li>';
                          }
                      });

                    str += '</ul>';

                    str += '</li>';
                  }

              });


              $("#nav").html("").append(str);
          });
      }





  </script>



@endsection
