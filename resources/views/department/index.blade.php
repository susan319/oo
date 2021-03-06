<!DOCTYPE html>
<html>

  <head>
    <meta charset="UTF-8">
    <title>欢迎页面-X-admin2.0</title>
    <meta name="renderer" content="webkit">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="/static/admin/css/font.css">
    <link rel="stylesheet" href="/static/admin/css/xadmin.css">
    <script type="text/javascript" src="/static/admin/js/jquery-3-2-1.js"></script>
    <script type="text/javascript" src="/static/admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="/static/admin/js/xadmin.js"></script>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
      <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body class="layui-anim ">

    <div class="x-body">

        <div class="layui-tab-content">



          <xblock>
            <a class="layui-btn layui-btn-small" href="javascript:location.replace(location.href);" title="刷新">刷新
            </a>
            <a class="layui-btn" onclick="x_admin_show('添加部门','/department/add',800,600)"><i class="layui-icon"></i>添加部门</a>

          </xblock>


          <table class="layui-table layui-form">
        <thead>
          <tr>

            <th width="70">ID</th>
            <th>部门名称</th>
            <th>备注</th>
            <th >操作</th>
        </thead>
        <tbody class="x-cate">

          @foreach($datas as $data)
          <tr cate-id='{{$data->id}}' fid="{{$data->pid}}" >

            <td>{{$data->id}}</td>
            <td>


              @if($data->level == 2)
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|___
              @elseif($data->level == 3)
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              @endif

              {{$data->name}}

            </td>


            
            <td>{{$data->remarks}}</td>

            <td class="td-manage">
               <a href="javascript:;" onclick="x_admin_show('修改','/department/edit?id={{$data->id}}',800,300)" class="layui-btn layui-btn-primary layui-btn-mini"><i class="layui-icon">&#xe642;</i></a>


              <!--   <a href="javascript:;" class="layui-btn layui-btn-primary ajax-delete layui-btn-mini" data="/department/delete?id={{$data->id}}"><i class="layui-icon">&#xe640;</i></a> -->

            </td>
          </tr>
          @endforeach

        </tbody>
      </table>


        </div>

    </div>



  </body>

</html>
