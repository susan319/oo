<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>后台登录-X-admin2.0</title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <meta http-equiv="Cache-Control" content="no-siteapp" />

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="/static/admin/css/font.css">
    <link rel="stylesheet" href="/static/admin/css/xadmin.css">


    <script type="text/javascript" src="/static/admin/js/jquery-3-2-1.js"></script>

    <script src="/static/admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="/static/admin/js/xadmin.js"></script>

</head>
<body>

    <br/>

    <xblock>
      <a class="layui-btn layui-btn-small" href="javascript:location.replace(location.href);" title="刷新">刷新
      </a>
      <a class="layui-btn" onclick="x_admin_show('添加菜单','/rbac/menu/add')"><i class="layui-icon"></i>添加菜单</a>
    </xblock>

    <xblock>
     <center><span style="color: red">红色及以下代表可用写路由</span></center>
     <table class="layui-table layui-form">
        <thead>
          <tr>

            <th width="70">ID</th>
            <th>菜单名</th>
            <th>路由</th>
            <th>icons</th>
            <th>目录级别</th>
            <th>启用</th>
            <th >操作</th>
        </thead>
        
        <tbody class="x-cate">

          @foreach($menuTree as $data)
          <tr cate-id='{{$data->id}}' fid="{{$data->pid}}" >

            <td>{{$data->id}}</td>
            <td>

              @if($data->level == 1 )
                &nbsp;
                <i class="layui-icon x-show" status='true'>&#xe623;</i>
              @elseif($data->level == 2 )
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <i class="layui-icon x-show" status='true'>&#xe623;</i>
              @elseif($data->level == 3)
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                
              @elseif($data->level == 4)
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              @endif

              @if($data->level == 3)
                <span style="color: red">{{$data->name}}</span>
              @elseif($data->level == 4)
                |___{{$data->name}}
              @else 
                {{$data->name}}
              @endif
              

            </td>

            <td>{{$data->router}}</td>


            <td>{{$data->icons}}</td>

            <td>{{$data->level}}</td>

            <td>
            @if($data->status == 1) 
              <i class="layui-icon">&#xe605;</i>     
            @else
              <i class="layui-icon">&#x1006;</i>   
            @endif
            </td>

            <td class="td-manage">
               
               <a href="javascript:;" onclick="x_admin_show('修改','/rbac/menu/edit?id={{$data->id}}')" class="layui-btn layui-btn-primary layui-btn-mini"><i class="layui-icon">&#xe642;</i></a>


                <a href="javascript:;" class="layui-btn layui-btn-primary ajax-delete layui-btn-mini" data="/rbac/menu/delete?id={{$data->id}}"><i class="layui-icon">&#xe640;</i></a>

            </td>
          </tr>
          @endforeach

        </tbody>



      </table>


    </xblock>


</body>
</html>
