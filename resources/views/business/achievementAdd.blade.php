<!DOCTYPE html>
<html>

  <head>
    <meta charset="UTF-8">
    <title>欢迎页面-X-admin2.0</title>
    <meta name="renderer" content="webkit">
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

  <body>
    <div class="x-body layui-anim ">
        <form class="layui-form form-container" action="/statistics/achievement/add" method="post">

                @csrf()

                <div class="layui-form-item">
                    <label class="layui-form-label">操作员ID</label>
                    <div class="layui-input-block">
                        <input type="text" name="number" value="{{$staff->number}}" required="" lay-verify="required" placeholder="请输入ID" class="layui-input">
                    </div>
                </div>


                <div class="layui-form-item">
                    <label class="layui-form-label">考勤天数</label>
                    <div class="layui-input-block">
                        <input type="text" name="attendance_days"  required="" lay-verify="required" placeholder="请输入考勤天数" class="layui-input" value="{{$flowingWater->attendance_days or ''}}">
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

    <script type="text/javascript">

        var fractional_column = "{{$flowingWater->month or 'null'}}";

        if (fractional_column != 'null') {
            $('select[name=month]').val(fractional_column);
        }

    </script>


  </body>

</html>
