@extends('layout')

@section('content')

@if(isset($rs) && $rs != null)
<div class="x-body" id="app">
	<div class="layui-tab-content">
			<form class="layui-form" >
				   <table class="layui-table layui-form">
				        <thead>
				          <tr>
				            <th width="70">ID</th>
				            <th>基本薪资</th>
				            <th>水电(披索)</th>
				            <th>其他小项</th>
				        </thead>
				        <tbody class="x-cate">


				          <tr >
				            <td>{{$rs->number}}</td>
				            <td>{{$rs->basic_salary}}</td>
				            <td>{{$rs->hydropower}}P</td>
				            <td>
				            	<li v-for="i in remarks_money">@{{i.remarks}}：@{{i.money}}元<hr/></li>
				            </td>
				          </tr>


				        </tbody>
				      </table>
				    <br/>
					<div >

						<li><span style="font-weight: bold;">总计：{{floor($rs->total_price * $rate - $rs->hydropower)}} </span></li>

					</div>
			</form>
	</div>
</div>
@else

<div style="text-align: center; margin-top: 50px; font-weight: bold;">未入录入数据</div>
@endif


@endsection


@section('js')
<script src="https://cdn.bootcss.com/vue/2.5.20/vue.js"></script>
<script type="text/javascript">
	var remarks_money = {!! $rs->remarks_money or "'null'"!!};
	var app = new Vue({
		el: '#app',
		data:{
			remarks_money:remarks_money,
		}
	});
</script>
@endsection
