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
        <form class="layui-form form-container" action="/department/add" method="post">

                @csrf()

                <div class="layui-form-item">
                      <label class="layui-form-label">级别</label>
                      <div class="layui-input-block">
                        <select name="pid" lay-verify="required" lay-filter="select" >
                            <option value="0" title="0">==顶级==</option>
                            @foreach($trees as $tree)
                                <option value="{{$tree->id}}" title="{{$tree->level}}"> @if($tree->level == 2)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |__  @elseif($tree->level == 3) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|__ @endif {{$tree->name}} </option>
                            @endforeach
                        </select>
                      </div>
                </div>



                <div class="layui-form-item">
                    <label class="layui-form-label">部门名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="name" value="" required="" lay-verify="required" placeholder="请输入部门名称" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">备注</label>
                    <div class="layui-input-inline">
                        <input type="text" name="remarks" value=""  placeholder="备注" class="layui-input">
                    </div>
                     <div class="layui-form-mid layui-word-aux"> 如果是顶级 部门名称是什么备注就写什么 </div>
                </div>

                <input type="hidden" name="level" value="1" id="level">

                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit="" lay-filter="*">保存</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    </div>
                </div>
            </form>
    </div>



    <script type="text/javascript">
        //重写layer
        layui.use(['layer', 'form' ], function(){
            var layer   = layui.layer,
                form    = layui.form;

           //当下拉菜单发生变化的时候
           form.on('select(select)', function(data){

                var level = data.elem[data.elem.selectedIndex].title;
                level = parseInt(level) + 1;
                $('#level').val(level);

            });

        });
    </script>


  </body>

</html>
