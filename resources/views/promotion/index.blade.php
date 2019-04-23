@extends('layout')



@section('content')
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
                @foreach($promotions as $promotion)
                    <a class="layui-btn layui-btn-primary click-promotion" href="/promotion/posts?id={{$promotion->id}}" data="{{$promotion->id}}" id="promotion{{$promotion->id}}">{{$promotion->name}}
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
                                        <th>是否录入<span style="float: right;"><span style="color: green">√录入</span> <span style="color: red">×未录入</span></span></th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                       @php

                                            $arrs = $data['data'];
                                            $arrs = $arrs->toArray();

                                            $arr = array_map(function($n){
                                                return $n['salary']['salary'];
                                            },$arrs);

                                          

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







                                                    <th>
                                                        <span >
                                                        绩效 @if($v['flowing_water']['is_input'] == 1)
                                                            <i class="iconfont" style="color: green">√</i>
                                                        @else
                                                            <i class="iconfont" style="color: red">×</i>
                                                        @endif
                                                       </span>
                                                        <span style="margin-left: 30px">
                                                        工资 @if($v['otherpost']['is_input'] == 1)
                                                            <i class="iconfont" style="color: green">√</i>
                                                        @else
                                                            <i class="iconfont" style="color: red">×</i>
                                                        @endif
                                                       </span>

                                                    </th>


                                                <th>



                                                    <a href="javascript:;" onclick="x_admin_show('业务员ID:{{$v['number']}}','/promotion/posts/add?number={{$v['number']}}',800,800)" class="layui-btn layui-btn-primary layui-btn-mini">绩效计算</a>

                                                    <a href="javascript:;" onclick="x_admin_show('业务员ID:{{$v['number']}}','/promotion/posts/calculation?number={{$v['number']}}',800,800)" class="layui-btn layui-btn-primary layui-btn-mini">工资计算</a>


                                                    <a href="javascript:;" onclick="x_admin_show('业务员ID：'+'{{$v['number']}}','/promotion/posts/see?number={{$v['number']}}',1500,600)" class="layui-btn layui-btn-primary layui-btn-mini">查看</a>

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


        </div>
    </div>
</body>
@endsection

@section('js')
<script>
        var active = "{{$active}}";
        $('#promotion'+active).css({ "color": "#fff", "background": "#009688" });

        $('input[name=score]').change(function(){
                    var score = $(this).val();
                    var department_id  = $(this).attr('data');

                    if ( score == '' ) {
                        layer.msg('评分不能为空');
                        return false;
                    }

                    $.post('/promotion/special_position_score',{score:score,department_id:department_id},function(res){
                            if (res.code == 1) {
                                layer.msg(res.msg);
                            }
                    });

                });


                // 清空数据
                $('.my-clear').click(function(){

                    layer.confirm('是否清除数据?', function(index){


                        $.post('/promotion/clear',{'_token':"{{csrf_token()}}",},function(res){

                            layer.msg('正在清除数据，请稍等');

                            if (res.code == 1) {
                                setTimeout(function () {
                                   layer.msg(res.msg);
                                }, 3000);
                                setTimeout(function () {
                                   location.href = "/promotion/posts";
                                }, 5000);
                            }

                        });

                       layer.close(index);
                    });

                });

</script>
@endsection
