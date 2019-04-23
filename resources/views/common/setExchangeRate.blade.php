@extends('layout')


@section('content')
	
	

	<div class="x-body layui-anim">

			<xblock>
                 <a class="layui-btn layui-btn-small" href="javascript:location.replace(location.href);" title="刷新">刷新
                </a>   
             </xblock>

		
        <form class="layui-form form-container"  method="post" style="margin-top: 50px">
            <div class="layui-form-item">
                <label class="layui-form-label">汇率设置</label>
                <div class="layui-input-block">
                    <input type="text" name="rate" value="{{$rate}}" required="" lay-verify="required" placeholder="请输入汇率" class="layui-input">
                </div>
                
            </div>
        </form>

    </div>

@endsection


@section('js')
<script>

	$('input[name=rate]').change(function(){
		var exchange_rate = $(this).val();
		var reg = /^[0-9]+.?[0-9]*$/;
		if (  !reg.test(exchange_rate) ) {
			layer.msg('汇率设置不正确');
			return false;
		}
		$.post('/rate/setting',{rate:exchange_rate,'_token':"{{csrf_token()}}"},function(res){
			if (res.code == 1) {
				layer.msg(res.msg)
			}
       });

	});

</script>
@endsection