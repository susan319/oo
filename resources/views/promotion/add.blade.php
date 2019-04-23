@extends('layout')


@section('content')
<div class="x-body layui-anim ">
        <form class="layui-form form-container" action="/promotion/posts/add" method="post">

                @csrf()

                <div class="layui-form-item">
                    <label class="layui-form-label">操作员ID</label>
                    <div class="layui-input-block">
                        <input type="text" name="number" value="{{$staff->number}}" required="" lay-verify="required" placeholder="请输入ID" class="layui-input">
                    </div>
                </div>



                @if($staff['is_formal'] == 0)
                <div class="layui-form-item">
                    <label class="layui-form-label">新人月数</label>
                    <div class="layui-input-block">
                      <select name="month" lay-verify="required">
                        <option value="4">更多</option>
                        <option value="1">1个月</option>
                        <option value="2">2个月</option>
                        <option value="3">3个月</option>
                      </select>
                    </div>
                </div>
                @endif



                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">总分</label>
                    <div class="layui-input-block">
                      <textarea name="total_score"  required="" lay-verify="required" placeholder="请输入内容" class="layui-textarea" rows=25 cols=30>{{$fractional_column}}</textarea>
                    </div>
                </div>


                <input type="hidden" name="department_id" value="{{$staff->department_id}}">


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
<script type="text/javascript">

        var fractional_column = "{{$flowingWater->month or 'null'}}";

        if (fractional_column != 'null') {
            $('select[name=month]').val(fractional_column);
        }

    </script>
@endsection
