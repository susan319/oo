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

  <body class="layui-anim layui-anim-up">

    <div class="x-body">

        <div class="layui-tab-content">



          <xblock>
            <a class="layui-btn layui-btn-small" href="javascript:location.replace(location.href);" title="刷新">刷新
            </a>
            <a class="layui-btn" onclick="x_admin_show('添加角色','/rbac/role/add',1000,300)"><i class="layui-icon"></i>添加角色</a>
          </xblock>
                <div class="layui-tab-item layui-show">
                    <table class="layui-table">
                        <thead>
                        <tr>
                            <th style="width: 30px;">ID</th>
                            <th>角色名称</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>

                            @foreach($datas as $vo)
                            <tr>
                                <td>{{$vo->id}}</td>
                                <td>{{$vo->name}}</td>
                                <td>启用</td>
                                <td>

                                    <a href="javascript:;" onclick="x_admin_show('修改','/rbac/role/edit?id={{$vo->id}}',600,300)" class="layui-btn layui-btn-primary layui-btn-mini"><i class="layui-icon">&#xe642;</i></a>


                                   <a href="javascript:;" onclick="x_admin_show('设置权限 => {{$vo->name}}','/rbac/role/set_auth?id={{$vo->id}}')" class="layui-btn layui-btn-primary layui-btn-mini">设置权限</a>

                                </td>
                            </tr>
                            @endforeach



                        </tbody>
                    </table>
                </div>
            </div>

    </div>

  </body>

</html>
