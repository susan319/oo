<!DOCTYPE html>
<html>

  <head>
    <meta charset="UTF-8">
    <title>欢迎页面-X-admin2.0</title>
    <meta name="renderer" content="webkit">
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

  <body>
    <div class="x-body layui-anim layui-anim-up">
        <form class="layui-form form-container" action="/rbac/menu/edit" method="post">

                @csrf

                <input type="hidden" name="id" value="{{$data->id}}">
                <input type="hidden" name="level" value="{{$data->level}}">
                <input type="hidden" name="pid" value="{{$data->pid}}">

                <div class="layui-form-item">
                    <label class="layui-form-label">菜单名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="name" value="{{$data->name}}" required="" lay-verify="required" placeholder="请输入菜单名称" class="layui-input">
                    </div>
                </div>


               


                <div class="layui-form-item">
                    <label class="layui-form-label">
                       router
                    </label>
                    <div class="layui-input-block">
                        <input type="text" name="router" value="{{$data->router}}"  placeholder="router" class="layui-input">
                    </div>
                </div>


                <div class="layui-form-item">
                    <label class="layui-form-label">icons</label>
                    <div class="layui-input-block">
                        <input type="text" name="icons"   value="{{$data->icons}}" class="layui-input">
                    </div>
                </div>


                @if($data->level == 3)
                    <div class="layui-form-item">
                        <label class="layui-form-label">是否启用</label>
                        <div class="layui-input-block">
                          <input type="radio" name="status" value="1" title="是">
                          <input type="radio" name="status" value="0" title="否">
                        </div>
                    </div>
                @endif
                


                <div class="layui-form-item">
                    <label class="layui-form-label">排序</label>
                    <div class="layui-input-block">
                        <input type="text" name="order" value="{{$data->order}}" required="" lay-verify="required" placeholder="请输入角色名称" class="layui-input">
                    </div>
                </div>




                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit="" lay-filter="*">保存</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    </div>
                </div>
            </form>
    </div>

    <script type="text/javascript">
            
        var status = "{{$data->status}}"; //获取服务端的值
        $("input[name='status'][value='"+status+"']").attr("checked",true);

    </script>

  </body>

</html>
