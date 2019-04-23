@extends('layout')

@section('content')



<div class="x-body layui-anim">


	@if($data['flag'] == 'other')
		@if($data['otherPosts'] != null)
			<div class="x-body" id="app">
			<div class="layui-tab-content">
					<form class="layui-form" >
						   <table class="layui-table layui-form">
						        <thead>
						          <tr>
						            <th width="70">ID</th>
						            <th>上班天数</th>
						            <th>基本薪资</th>
						            <th>水电(披索)</th>
						            <th>汇率</th>
						            <th>其他小项</th>

						        </thead>
						        <tbody class="x-cate">


						          <tr>
						            <td>{{$data['otherPosts']['number']}}</td>
						            <td>{{$data['otherPosts']['attendance_days']}}</td>
						            <td>{{$data['otherPosts']['basic_salary']}}</td>
						            <td>-{{$data['otherPosts']['hydropower']}}P</td>
						            <td>{{$data['rate']}}</td>
						            <td>
						            	<li v-for="(i,index) in remarks_money"><span style="width:80px;display: inline-block;">  @{{i.remarks}}</span><span style="width: 250px;margin-left: 15px;display: inline-block;">@{{i.money}}元</span><hr></li>
						            </td>

						          </tr>


						        </tbody>
						      </table>
						    <br/>
							<div >

								<li><span style="font-weight: bold;">结算：{{floor($data['otherPosts']['total_price'] * $data['rate'] - $data['otherPosts']['hydropower'])}} 披索</span></li>

							</div>
					</form>
			</div>

	</div>
		@else
			 <blockquote class="layui-elem-quote" style="margin-top: 50px">工资未录入，联系管理员</blockquote>
		@endif
	@endif





	@if($data['flag'] == 'extension')
        @if( $data['otherPosts'] == null)
            <blockquote class="layui-elem-quote" style="margin-top: 50px">工资未录入，联系管理员</blockquote>
        @else
                <div class="x-body" id="app">
            <div class="layui-tab-content">
                    <form class="layui-form" >
                           <table class="layui-table layui-form">
                                <thead>
                                  <tr>
                                    <th width="70">ID</th>
                                    <th>上班天数</th>
                                    <th>基本薪资</th>
                                    <th>得分({{$data['flowing']['fraction']}})</th>
                                    <th>有效({{$data['flowing']['point']}})</th>
                                    <th>组长岗位</th>
                                    <th>特殊岗位</th>
                                    <th>水电(披索)</th>
                                    <th>汇率</th>
                                    <th>其他小项</th>

                                </thead>
                                <tbody class="x-cate">


                                  <tr>
                                    <td>{{$data['otherPosts']['number']}}</td>
                                    <td>{{$data['otherPosts']['attendance_days']}}</td>
                                    <td>{{$data['otherPosts']['basic_salary']}}</td>
                                    <td>{{$data['flowing']['fraction_money']}}</td>
                                    <td>{{$data['flowing']['point_money']}}</td>
                                    <td>{{$data['flowing']['group_moeny']}}</td>
                                    <td>{{$data['flowing']['special_moeny']}}</td>
                                    <td>-{{$data['otherPosts']['hydropower']}}P</td>
                                    <td>{{$data['rate']}}</td>
                                    <td>
                                        <li v-for="(i,index) in remarks_money"><span style="width:80px;display: inline-block;">  @{{i.remarks}}</span><span style="width: 250px;margin-left: 15px;display: inline-block;">@{{i.money}}元</span><hr></li>
                                    </td>

                                  </tr>


                                </tbody>
                              </table>
                            <br/>
                        <div>
                        <p style="font-weight: bold; ">总计：{{($data['flowing']['total_moeny'] + $data['otherPosts']['total_price'])*$data['rate'] - $data['otherPosts']['hydropower']}}</p>
                        </div>
                    </form>
            </div>

    </div>
        @endif

	@endif


</div>
@endsection

@section('js')
<script src="https://cdn.bootcss.com/vue/2.5.20/vue.js"></script>
<script type="text/javascript">
	var remarks_money = {!! $data['otherPosts']['remarks_money'] or "'null'"!!};
	var app = new Vue({
		el: '#app',
		data:{
			remarks_money:remarks_money,
		}
	});
</script>
@endsection
