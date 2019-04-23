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

                <a class="layui-btn layui-btn-small my-clear" href="javascript:;" title="一键清空本月数据">
                    一键清空本月数据
                </a>

                
            </xblock>


            <xblock>

                @foreach($datas['extensionGroups'] as $department)
                    <a class="layui-btn layui-btn-primary click-department" href="/statistics/promotion_of_performance?id={{$department->id}}" data="{{$department->id}}" id="department{{$department->id}}">{{$department->name}}
                    </a>
                @endforeach

            </xblock>



            <div class="layui-collapse">
                @foreach($datas['v'] as $k => $data)
                    <div class="layui-colla-item">
                        <h2 class="layui-colla-title" style="color: #009688;font-size: 16px">{{$data['name']}}
                        </h2>
                        <hr class="hr20">
                        <div>
                            <label class="layui-form-label" style="color: red">
                                特殊岗评分
                            </label>
                            <div class="layui-input-inline">
                              <input type="text" name="score" required lay-verify="required" placeholder="请打分" autocomplete="off" class="layui-input" data="{{$data['id']}}" value="{{$data['special_position_score']['score']}}">
                            </div>
                        </div>
                        <hr class="hr20" >



                        <div class="layui-colla-content layui-show">
                            
                            <div style="border:dotted 3px green; height: 100px; line-height: 100px">
                                <center>
                                    <span style="font-size: 25px;color: green">
                                        团队:
                                        @php
                                            $temp = 0;
                                            foreach( $data['price']  as $key => $price ){
                                                $temp += $price['total_amount'];
                                            }
                                            echo $temp;
                                            echo '元';
                                        @endphp
                                    </span>
                                </center>
                            </div>
                       

                            <div class="layui-tab-item layui-show">
                                <table class="layui-table">
                                    <thead>
                                    <tr>
                                        <th>业务员ID</th>
                                        <th>昵称</th>
                                        <th>职位</th>
                                        <th>是否转正</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                       @php

                                            $arrs = $data['data'];
                                            $arrs = $arrs->toArray();

                                            $arr = array_map(create_function('$n', 'return $n["salary"]["salary"];'), $arrs);

                                            array_multisort($arr, SORT_DESC, $arrs );

                                        @endphp 

                                        @foreach($arrs as $v)
                                            <tr>
                                                <th >{{$v['number']}}</th>
                                                <th >{{$v['nick_name']}}</th>
                                                <th style="color: red">{{$v['salary']['name']}}　
                                                    @if($v['business_type'] == 1)
                                                    <span style="float: right;">(推广)</span>
                                                    @else
                                                    <span style="float: right;">(特殊)</span>
                                                    @endif
                                                </th>




                                                <th >@if($v['is_formal'] == 1) 转正 @else <span style="color: red">未转正</span> @endif</th>

                                                <th>

                                                    <a href="javascript:;" onclick="x_admin_show('业务员ID:{{$v['number']}}','/statistics/achievement/add?number={{$v['number']}}',800,800)" class="layui-btn layui-btn-primary layui-btn-mini">添加上月得分</a>

                                                    <a href="javascript:;" onclick="x_admin_show('业务员ID：'+'{{$v['number']}}','/statistics/view_performance?number={{$v['number']}}',1500,300)" class="layui-btn layui-btn-primary layui-btn-mini">查看上月绩效</a>

                                                </th>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                    
                    </div>
                </div>
                @endforeach
            </div>




            <script type="text/javascript">

                var active = "{{$datas['active']}}";
                $('#department'+active).css({ "color": "#fff", "background": "#009688" });

                $('input[name=score]').change(function(){
                    var score = $(this).val();
                    var department_id  = $(this).attr('data');

                    if ( score == '' ) {
                        layer.msg('评分不能为空');
                        return false;
                    }

                    $.post('/statistics/special_position_score',{score:score,department_id:department_id},function(res){

                            if (res.code == 1) {
                                layer.msg(res.msg);
                            }

                    });

                });


                // 清空数据
                $('.my-clear').click(function(){

                    layer.confirm('是否清除数据?', function(index){


                        $.post('/statistics/clear',{'_token':"{{csrf_token()}}",},function(res){

                            layer.msg('正在清除数据，请稍等');

                            if (res.code == 1) {
                                setTimeout(function () {
                                   layer.msg(res.msg);
                                }, 3000);
                                setTimeout(function () {
                                   location.href = "/statistics/promotion_of_performance";
                                }, 5000);
                            }

                        });

                       layer.close(index);
                    });

                });

            </script>


        </div>

    </div>


  </body>

</html>
