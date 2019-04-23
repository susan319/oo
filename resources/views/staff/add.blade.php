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

    <script src="/static/admin/Plug/jSignature/libs/flashcanvas.js"></script>
    <script src="/static/admin/Plug/jSignature/libs/jSignature.min.js"></script>

  </head>

  <body>
    <div class="x-body layui-anim layui-anim-up">
        <form class="layui-form form-container" action="/staff/add" method="post">



                @csrf()

                <div class="layui-form-item">
                    <label class="layui-form-label">员工ID</label>
                    <div class="layui-input-block">
                        <input type="text" name="number" value="" required="" lay-verify="required" placeholder="请输入员工ID" class="layui-input">
                    </div>
                </div>


                <div class="layui-form-item">

                    <label class="layui-form-label">部门</label>

                    <div class="layui-input-inline">
                        <select name="" lay-verify="required" lay-filter="department_select">
                            <option value="">请选择</option>
                            @foreach($department_ones as $department)

                                <option value="{{$department->id}}" title="{{$department->remarks}}">{{$department->name}}
                                </option>

                            @endforeach
                        </select>
                    </div>

                    <div class="select-show" style="display: none">

                    </div>


                </div>



                <div class="layui-form-item">
                    <label class="layui-form-label">职务</label>
                    <div class="layui-input-inline">
                        <select name="salary_structure_id" lay-verify="required" lay-filter="select" class="salary_structure_id">

                        </select>
                    </div>
                </div>


                <div class="layui-form-item">
                    <label class="layui-form-label">角色</label>
                    <div class="layui-input-inline">
                        <select name="role_id" lay-verify="required">
                                <option value="">请选择</option>
                            @foreach($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                            
                           
                        </select>
                    </div>
                </div>


                <div class="layui-form-item" id="business_type" style="display: none">

                    <label class="layui-form-label">推广部类型</label>
                    <div class="layui-input-inline">

                        <input type="radio" name="business_type" value="1" title="推广">
                        <input type="radio" name="business_type" value="2" title="特殊" checked>

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
                    <label class="layui-form-label">英文名</label>
                    <div class="layui-input-block">
                        <input type="text" name="nick_name" value="json" required="" lay-verify="required" placeholder="请输入英文名" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                      <label class="layui-form-label">籍贯</label>
                      <div class="layui-input-block">
                        <!-- place -->
                         <input type="text" name="place" value="上海" required="" lay-verify="required" placeholder="请输入籍贯" class="layui-input">
                      </div>
                </div>

                 <div class="layui-form-item">
                    <label class="layui-form-label">联系电话</label>
                    <div class="layui-input-block">
                        <input type="text" name="phone" value="131311" required="" lay-verify="required" placeholder="请输入联系电话" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">出生年月</label>
                    <div class="layui-input-block">
                        <input type="text" name="age" value="" required="" lay-verify="required" placeholder="请输入出生年月" class="layui-input" id="age">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">入职日期</label>
                    <div class="layui-input-block">
                        <input type="text" name="date_of_entry" value="" required="" lay-verify="required" placeholder="请输入入职日期" class="layui-input" id="date_of_entry">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">系统密码</label>
                    <div class="layui-input-block">
                        <input type="text" name="password"  required="" lay-verify="required" placeholder="请输入系统密码" class="layui-input" value="123456">
                    </div>
                </div>


                <div class="layui-form-item">
                    <label class="layui-form-label">转正</label>
                    <div class="layui-input-block">
                      <select name="is_formal" lay-verify="required">
                        <option value="0">未转正</option>
                        <option value="1">转正</option>
                      </select>
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

        layui.use(['laydate','form'], function(){

            var laydate = layui.laydate,
                form    = layui.form;

            //执行一个laydate实例
            laydate.render({
              elem: '#age' //指定元素
              ,format: 'MM-dd'
            });

            laydate.render({
              elem: '#date_of_entry' //指定元素
              ,type: 'datetime'
            });


            //当下拉菜单发生变化的时候
           form.on('select(department_select)', function(data){

                var department_id = data.value;

                if ( department_id == 3) {
                    $('#business_type').show();
                }   else {
                    $('#business_type').hide();
                }

                //备注
                var remarks = data.elem[data.elem.selectedIndex].title;

                if (department_id == '') {
                    $('select[name=salary_structure_id]').val("");
                    $('.select-show').hide();
                    form.render();
                    return false;
                }

                $('select[name=salary_structure_id]').val("");

               
                // 获取该部门的子部门
                $.post('/staff/subsidiary',{department_id:department_id,'_token':"{{csrf_token()}}",'remarks':remarks},function(res){

                    var str = '<div class="layui-input-inline"><select name="department_id" lay-verify="required">';

                    str += '<option value="">请选择</option>';

                    $.each(res.departments,function(k,v){

                        var steTemp = '';

                        if (v.level == 3) {
                            steTemp += "|___"
                            str += "<option value='"+v.id+"'>" + steTemp + v.name + "</option>";
                        } else {
                            str += "<option value='"+v.id+"' >" + steTemp + v.name + "</option>";
                        }

                    });

                    str += '</select></div>';

                    $('.select-show').empty().append(str).show();


                    var SalaryStructureStr = '<option value="">请选择</option>';
                   
                    $.each(res.SalaryStructure,function(k,v){
                        SalaryStructureStr += "<option value='"+v.id+"'>"+v.name+"</option>"
                    });

                    $('.salary_structure_id').empty().append(SalaryStructureStr);

                    form.render();
                });


            });



           //公寓
           form.on('select(g_id_select)', function(data){
                
                var g_id = data.value;

                if (g_id == '') {
                    $('select[name=f_id]').val("");
                    $('.select-apartmen-show').hide();
                    form.render();
                    return false;
                }

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
                            str += "<option value='"+v.id+"'>"+v.name+'('+sexTemp+')'+"</option>";
                        });

                        str += '</select></div>';

                        $('.select-apartmen-show').empty().append(str).show();

                        form.render();
                });

           });



      });






    </script>


  </body>

</html>
