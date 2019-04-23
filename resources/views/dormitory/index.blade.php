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

  <body class="layui-anim">



    <div class="x-body">

        <div class="layui-tab-content">

            <xblock>


                <a class="layui-btn layui-btn-small" href="javascript:location.replace(location.href);" title="刷新">
                    刷新
                </a>

            </xblock>
           

            <xblock>

                @foreach($datas['apartment_ones'] as $apartment)
                    <a class="layui-btn layui-btn-primary click-department" href="/dormitory_management/dormitory?id={{$apartment->id}}" data="{{$apartment->id}}" id="apartment{{$apartment->id}}">{{$apartment->name}}
                    </a>
                @endforeach

            </xblock>



                 <div class="layui-tab-item layui-show">
                    <table class="layui-table">
                        <thead>
                        <tr>
                           
                            <th>房号 / 员工名字</th>
                            <th> 部门</th>
                            <th>可住人数</th>
                            <th>已住人数</th>
                            <th>剩余人数</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>

                            @foreach($datas['data'] as $apartment)
                                <tr>
                                    
                                    <td style="color: #009688">
                                       {{$apartment->name}}  @if($apartment->sex == 1)
                                            <span style="float: right">(男)</span>
                                        @elseif($apartment->sex == 2)
                                            <span style="float: right">(女)</span>
                                        @else
                                                   
                                        @endif
                                    </td>

                                    <td>
                                       
                                    </td>

                                    <td>
                                        @if($apartment->level == 2)
                                            {{$apartment->resident_number}}
                                        @endif
                                        
                                    </td>
                                    <td>

                                        @if($apartment->level == 2)
                                           {{$apartment->checked_number}}
                                        @endif
                                    </td>
                                    <td>
                                        @if($apartment->level == 2)
                                          <span style="color: red"> 
                                            @if($apartment->resident_number - $apartment->checked_number == 0)
                                                满员
                                            @else 
                                                {{$apartment->resident_number - $apartment->checked_number}}
                                            @endif
                                          </span>
                                        @endif
                                    </td>
                                    <td>
                                      @if($apartment->status == 1)
                                            <i class="layui-icon">&#xe605;</i>
                                        @else 
                                            <i class="layui-icon">&#x1006;</i>   
                                        @endif
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                                @if(isset($apartment->peoples) && count($apartment->peoples) > 0 )
                                    
                                    @foreach($apartment->peoples as $peoples)
                                        <tr>
                                            <td>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|___&nbsp;{{$peoples->staff->nick_name}}</td>
                                            <td>
                                               {{$peoples->staff->department->name}}
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <a href="javascript:;" onclick="x_admin_show('宿舍更换','/dormitory_management/dormitory/edit?id={{$peoples->number}}&g_id={{$peoples->g_id}}&f_id={{$peoples->f_id}}',800,600)" class="layui-btn layui-btn-primary layui-btn-mini"><i class="layui-icon">&#xe642;</i></a>
                                            </td>
                                        </tr>
                                        
                                    @endforeach

                                @endif

                            @endforeach


                        </tbody>
                    </table>
                </div>




            <script type="text/javascript">

                var active = "{{$datas['active']}}";
                $('#apartment'+active).css({ "color": "#fff", "background": "#009688" });

            </script>


        </div>

    </div>


  </body>

</html>
