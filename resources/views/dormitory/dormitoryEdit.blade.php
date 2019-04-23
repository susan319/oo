<!DOCTYPE html>
<html>

  <head>
    <meta charset="UTF-8">
    <title>X-admin2.0</title>
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
        <form class="layui-form form-container" action="/dormitory_management/dormitory/edit" method="post">

                @csrf()

                <div class="layui-form-item">
                    <label class="layui-form-label">员工ID</label>
                    <div class="layui-input-block">
                        <input type="text" name="number" value="{{$staff->number}}" required="" lay-verify="required" placeholder="请输入员工ID" class="layui-input" disabled>
                    </div>
                </div>

                <input type="hidden" name="number" value="{{$staff->number}}">
                <input type="hidden" name="old_f_id" value="{{$f_id}}">

                <div class="layui-form-item">
                    <label class="layui-form-label">部门</label>
                    <div class="layui-input-block">
                        <input type="text"  value="{{$staff->department->name}}" required="" lay-verify="required" placeholder="" class="layui-input" disabled>
                    </div>
                </div>




                <div class="layui-form-item">
                    <label class="layui-form-label">公寓</label>
                    <div class="layui-input-inline">
                        <select name="g_id" lay-verify="required" lay-filter="g_id_select">
                            <option value="">请选择</option>
                            @foreach($apartmen_ones as $apartmen)
                                <option value="{{$apartmen->id}}">{{$apartmen->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="select-apartmen-show" style="display: none">

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


     <script>


        var g_id = "{{$g_id}}";
        var f_id = "{{$f_id}}";

        $('select[name=g_id]').val(g_id);
        initDormitory(g_id,f_id);

        function initDormitory(g_id,f_id=null){
           
            layui.use('form', function(){
                $.post('/dormitory_management/room',{g_id:g_id,'_token':"{{csrf_token()}}"},function(res){

                       var str = '<div class="layui-input-inline"><select name="f_id" lay-verify="required">';

                        str += "<option value=''>请选择</option>";
                      

                        $.each(res,function(k,v){
                            var sexTemp = '';
                            if (v.sex == 1) {
                                sexTemp = "男";
                            } else {
                                sexTemp = "女";
                            }
                            if (f_id == v.id) {
                                str += "<option value='"+v.id+"' selected>"+v.name+'('+sexTemp+')'+"</option>";
                            } else {
                                str += "<option value='"+v.id+"'>"+v.name+'('+sexTemp+')'+"</option>";
                            }
                        });

                        str += '</select></div>';

                        $('.select-apartmen-show').empty().append(str).show();

                        form.render();
                });
            });
        }

        layui.use(['laydate','form'], function(){
            var laydate = layui.laydate,
                form    = layui.form;
            //当公寓下拉时
            form.on('select(g_id_select)', function(data) {
                
                var g_id = data.value;
                
                if (g_id == '') {
                    $('select[name=f_id]').val("");
                    $('.select-apartmen-show').hide();
                    form.render();
                    return false;
                }
                initDormitory(g_id);
                form.render();
            });
      });





    </script>


  </body>

</html>
