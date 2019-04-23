@extends('layout')


@section('content')

@if($flag == false)

    <p style="margin-top:30px"><center>暂未录入数据</center></p>
@else
 <div class="layui-tab-content" id="app">

    <table class="layui-table layui-form">
        <thead>
             <tr>
                <th>ID</th>
                <th>上班天数</th>
                <th>基本薪资</th>
                <th>得分({{$flowingWater->fraction}}分)</th>
                <th>有效({{$flowingWater->point}}个)</th>
                <th>组长岗位</th>
                <th>特殊岗位</th>
                <th>水电</th>
                <th>其他小项</th>
             </tr>
             <tbody>
                <tr>
                    <td>{{$other->number}}</td>
                    <td>{{$other->attendance_days}}</td>
                    <td>{{$other->basic_salary}}</td>
                    <td>{{$flowingWater->fraction_money}}</td>
                    <td>{{$flowingWater->point_money}}</td>

                    <td>{{$flowingWater->group_moeny}}</td>
                    <td>{{$flowingWater->special_moeny}}</td>

                    <td>{{$other->hydropower}}P</td>
                    <td>
                         <li v-for="i in remarks_money">@{{i.remarks}}：@{{i.money}}元<hr/></li>
                    </td>
                </tr>
             </tbody>

        </thead>
    </table>
    <br/>
     <p style="font-weight: bold; ">总计：{{($flowingWater->total_moeny + $other->total_price)*$rate - $other->hydropower}}</p>
 </div>
@endif


@endsection


@section('js')
<script src="https://cdn.bootcss.com/vue/2.5.20/vue.js"></script>
<script type="text/javascript">
    var remarks_money = {!! $other->remarks_money or "'null'"!!};
    var app = new Vue({
        el: '#app',
        data:{
            remarks_money:remarks_money,
        }
    });
</script>
@endsection
