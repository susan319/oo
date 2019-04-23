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

  <body class="layui-anim layui-anim-up">

    <div class="x-body">


        <br/><br/>
        <div class="layui-tab-content">

                 <table class="layui-table layui-form">
                      <thead>
                         <tr>
                            <th>职位</th>
                            <th>是否转正</th>
                            <th>入职时间</th>
                            <th style="color: red">基本薪资：{{$staff->salary->salary}}元<br/>考勤天数：{{$staff->attendance_days}}天</th>
                            <th>得分 ({{$staff->fws->fraction}}分)</th>
                            <th>有效数 ({{$staff->fws->point}}个)</th>
                            <th>组长岗位奖励</th>
                            <th>特殊岗位奖励</th>
                            <th>工龄 ({{$staff->working_years}}年)</th>
                            <th>人民币总计</th>
                            <th>当地货币总计 ({{$staff->rate}})</th>
                        </tr>
                      </thead>

                      <tbody>
                        <tr>
                            <td style="color: red">{{$staff->salary->name}} @if($staff->business_type == 1)
                                <span style="float: right;">(推广)</span>
                            @else
                                <span style="float: right;">(特殊)</span>
                            @endif
                            </td>
                            <td style="color: red">
                                @if($staff->is_formal == 1)
                                    已转正
                                @else
                                    未转正　
                                    @if($staff->business_type == 1)
                                        @if($staff->month == 4)
                                            新人已过3个月
                                        @else
                                            (新人 第{{$staff->month}}个月 )
                                        @endif

                                    @endif
                                @endif
                            </td>
                            <td style="color: red">{{$staff->date_of_entry}}</td>
                            <td style="color: red">
                                {{$staff->attendance_days_25}}
                            </td>

                            <td style="color: red">

                                @if($staff->business_type == 1)
                                    @if($staff->is_formal == 1)
                                        {{$staff->fws->fraction * 50 * 0.7}}
                                    @else
                                        {{$staff->fws->fraction * 50 * 0.6}}
                                    @endif
                                @else
                                    0
                                @endif


                            </td>


                            @if($staff->business_type == 1)
                                @if($staff->is_formal == 1)
                                    <td style="color: red">
                                        @if($staff->fws->point >= 16)
                                            2000
                                        @elseif($staff->fws->point >= 15)
                                            1100
                                        @elseif($staff->fws->point >= 14)
                                            600
                                        @else
                                            0
                                        @endif
                                    </td>
                                @else
                                    <td style="color: red">
                                        @if($staff->fws->point >= 16)
                                            2000
                                        @elseif($staff->fws->point >= 15)
                                            1100
                                        @elseif($staff->fws->point >= 14)
                                            600
                                        @elseif($staff->fws->point >= 10)
                                            500
                                        @else
                                            @if( $staff->month == 1 && $staff->fws->point >= 5 )
                                                500
                                            @elseif( $staff->month == 2 && $staff->fws->point >= 8 )
                                                500
                                            @else
                                                0
                                            @endif
                                        @endif
                                    </td>
                                @endif
                            @else
                                <td style="color: red">0</td>
                            @endif


                            <td style="color: red">{{$staff->zuzhang}}</td>

                            <td style="color: red">{{$staff->ts}}</td>

                            <td style="color: red">{{$staff->working_years * 500 }}</td>
                            <td style="color: red">{{$staff->totalPrice}}</td>
                            <td style="color: red">{{$staff->local_exchange_rate}}</td>
                        </tr>
                      </tbody>


                  </table>


        </div>

    </div>




  </body>

</html>
