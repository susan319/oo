@extends('layout')

@section('content')

<div class="x-body layui-anim" id="app">
	
	<form class="layui-form form-container" action="/other/posts/calculation" method="post">
		
		@csrf()

		<div class="layui-form-item">
            <label class="layui-form-label">操作员ID</label>
            <div class="layui-input-block">
                <input type="text" name="number" value="{{$number}}" required="" lay-verify="required" placeholder="请输入ID" class="layui-input">
            </div>
        </div>

	 	<div class="layui-form-item">
            <label class="layui-form-label">考勤天数</label>
            <div class="layui-input-block">
                <input type="text" name="attendance_days"  required="" lay-verify="required" placeholder="请输入考勤天数" class="layui-input" value="{{$rs->attendance_days or 0}}">
            </div>
        </div>
		
		<div class="layui-form-item">
            <label class="layui-form-label">水电费</label>
            <div class="layui-input-inline">
                <input type="text" name="hydropower" required="" lay-verify="required" placeholder="请输入水电费" class="layui-input" value="{{$rs->hydropower or 0}}">
            </div>
            <div class="layui-form-mid layui-word-aux">披索</div>
        </div>


		<div style="display: none"><textarea name="remarks_money" v-text="others"></textarea></div>


        <div class="layui-form-item">
        	<label class="layui-form-label"></label>
        	<a href="javascript:;" class="layui-btn layui-btn-primary" v-on:click="addInput">添加其他款项</a>
        </div>
		
		
		<div class="layui-form-item" v-for="(other,k) in others">
            <label class="layui-form-label">备注&金额</label>
            <div class="layui-input-inline">
                <input type="text"  v-model="others[k].remarks" required="" lay-verify="required" placeholder="请输入备注" class="layui-input">
            </div>
            <div class="layui-input-inline">
                <input type="text" v-model="others[k].money"  required="" lay-verify="required" placeholder="请输入金额" class="layui-input" >
            </div>
            <div class="layui-input-inline">
				<a href="javascript:;" class="layui-btn layui-btn-primary" v-on:click="delInput(k)">-</a>
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

@endsection


@section('js')
<script src="https://cdn.bootcss.com/vue/2.5.20/vue.js"></script>
<script>
	var remarks = {!!$rs->remarks_money or "'null'" !!};
	 if (remarks == 'null') {
	 	remarks = [];
	 }

	var app = new Vue({
		el: '#app',
		data:{
			others: remarks, //备注&金额 type:[]
		},
		methods:{
			//添加备注
			addInput:function() {
				var field = {remarks:'', money:0};
				app.others.push(field);
			},
			//减少备注
			delInput:function(k) {
			  app.others.splice(k,1);
			}
		},
	
	});

</script>
@endsection