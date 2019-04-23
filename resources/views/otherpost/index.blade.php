@extends('layout')




@section('content')

<div class="x-body">

	 <div class="layui-tab-content">
    	 	<xblock>
                    <a class="layui-btn layui-btn-small" href="javascript:location.replace(location.href);" title="刷新">
                        刷新
                    </a>


            </xblock>

            <xblock>

                @foreach($datas['department'] as $department)
                    <a class="layui-btn layui-btn-primary click-department" href="/other/posts?id={{$department->id}}" data="{{$department->id}}" id="department{{$department->id}}">{{$department->name}}
                    </a>
                @endforeach

            </xblock>


             <div class="layui-collapse">
             	<div class="layui-colla-item">
             		<h2 class="layui-colla-title" style="font-size: 16px"></h2>
             	</div>
             	 <div class="layui-colla-content layui-show">
             	 	<table class="layui-table">
                        <thead>
                        <tr>
                            <th>员工ID</th>
                            <th>昵称</th>
                            <th>岗位</th>
                            <th>职位</th>
                            <th>是否录入<span style="float: right;"><span style="color: green">√录入</span> <span style="color: red">×未录入</span></span></th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($staffs as $staff)
                                <tr>
                                    <th>{{$staff->number}}</th>
                                    <th>{{$staff->nick_name}}</th>
                                    <th>{{$staff->salary->remarks}}</th>
                                    <th>{{$staff->salary->name}}</th>
                                    <th>
                                         @if( isset($staff->otherpost->is_input) )
                                            @if($staff->otherpost->is_input == 1)
                                                <span style="color: green">√</span>
                                            @else
                                              <span style="color: red">×</span>
                                            @endif
                                        @else
                                            <span style="color: red">×</span>
                                        @endif
                                    </th>
                                    <th>
                                        <a href="javascript:;" onclick="x_admin_show('薪资计算','/other/posts/calculation?number={{$staff->number}}',800,800)" class="layui-btn layui-btn-primary layui-btn-mini">薪水计算</a>

                                        <a href="javascript:;" onclick="x_admin_show('查看明细','/other/posts/see?number={{$staff->number}}',1200,300)" class="layui-btn layui-btn-primary layui-btn-mini">查看</a>
                                    </th>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                	</div>
             	 </div>
            </div>
</div>



@endsection


@section('js')

<script type="text/javascript">

	var active = "{{$datas['active']}}";
    $('#department'+active).css({ "color": "#fff", "background": "#009688" });

</script>

@endsection
