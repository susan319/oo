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

      
         
              <xblock > 

                <div style="margin-bottom: 30px" >
                    <!-- <a class="layui-btn layui-btn-small" href="javascript:location.replace(location.href);" title="刷新">刷新
                    </a> -->

                    <a class="layui-btn" onclick="x_admin_show('添加员工','/staff/add',1500,800)"><i class="layui-icon"></i>添加员工</a>

                    <a class="layui-btn" href="/staff"><i class="layui-icon"></i>初始化</a>
<!-- 
                    <a class="layui-btn " lay-filter="sreach" href="/staff"><i class="layui-icon">init</i></a> -->

                </div>



                 <div class="layui-row">
                    <form class="layui-form layui-col-md12 x-so" action="/staff" method="get">

                    @csrf



                    <div class="layui-input-inline">
                        <select name="status">
                            <option value="1">在职</option>
                            <option value="2">离职</option>
                        </select>
                    </div>





                    <div class="layui-input-inline">
                        <select name="department_id"  lay-filter="select" lay-search>
                              <option value="">请选择</option>
                              @foreach($departments as $department)

                                  @if($department['level'] == 2)
                                    <option value="{{$department['id']}}">|__{{$department['name']}}</option>
                                  @elseif($department['level'] == 3)
                                     <option value="{{$department['id']}}">&nbsp;&nbsp;&nbsp;&nbsp;|__{{$department['name']}}</option>
                                  @else
                                    <option disabled>{{$department['name']}}</option>
                                  @endif


                              @endforeach
                        </select>
                    </div>


                    <div class="layui-input-inline">

                      <input type="text" name="number" placeholder="请输入ID" autocomplete="off" class="layui-input">


                       <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>

                    </div>



                    </form>
                  </div>

                  <div style="font-weight: bold;">在职员工:{{$total}}人</div>

              </xblock>
             






                 @if(count($all) == 0)

                    <div style="text-align: center; margin-top: 100px;">
                        <h3>暂无员工</h3>
                    </div>
                 @else
                 <div class="layui-tab-item layui-show">
                    <table class="layui-table">
                        <thead>
                        <tr>
                            <th>序号</th>
                            <th>ID</th>
                            <th>昵称</th>
                           
                            <th>入职部门</th>
                            <th>职位</th>
                            <th>入职日期</th>
                            <th>住宿</th>
                            <th>角色</th>
                            <th>是否转正</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>


                          <tbody>

                            @foreach($all as $key => $vo)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$vo->number}}</td>
                                <td>
                                    {{$vo->nick_name}}
                                </td>
                                
                                <td>{{getPrentDepartment($vo['department']['pid'])}} => <span style="color: red">{{$vo['department']['name']}} </span> </td>
                                <td>

                                    @if($vo->salary->name == "推广主管")
                                        <span style="color: red;font-weight: bold;">{{$vo->salary->name}}</span>
                                    @elseif($vo->salary->name == "组长")
                                        <span style="color: #abcdef;font-weight: bold;">{{$vo->salary->name}}</span>
                                    @elseif($vo->salary->name == "副组长")
                                        <span style="color: green;font-weight: bold;">{{$vo->salary->name}}</span>
                                    @else
                                        {{$vo->salary->name}}
                                    @endif

                                </td>
                                
                                
                               
                                <td>{{$vo->date_of_entry}}</td>

                                <td>
                                  {{ getDormitory($vo->dormitory->g_id,$vo->dormitory->f_id) }}
                                </td>

                                <td>
                                    {{$vo->roles->name}}
                                </td>

                                <th>@if($vo->is_formal == 1) 转正 @else <span style="color: red">未转正</span> @endif </th>

                                <td>@if($vo->status == 1) 在职 @else 离职 @endif</td>
                                <td>
                                    <a href="javascript:;" onclick="x_admin_show('修改','/staff/edit?id={{$vo->id}}',1500,800)" class="layui-btn layui-btn-primary layui-btn-mini"><i class="layui-icon">&#xe642;</i></a>
                                </td>
                            </tr>
                            @endforeach



                        </tbody>
                        @endif



                    </table>





                {{ $all->appends(array('status'=>$status,'department_id'=>$department_id))->render()}}

                </div>


         </div>

    </div>

    <script type="text/javascript">

        var status = "{{$status}}";
        $('select[name=status]').val(status);

        var number = "{{$number}}";
        $('input[name=number]').val(number);

        var department_id = "{{$department_id}}";
        $('select[name=department_id]').val(department_id);

    </script>

  </body>

</html>
