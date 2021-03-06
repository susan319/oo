<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>后台登录-X-admin2.0</title>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />


    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="/static/admin/css/font.css">
    <link rel="stylesheet" href="/static/admin/css/xadmin.css">

    <script type="text/javascript" src="/static/admin/js/jquery-3-2-1.js"></script>


    <script src="/static/admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="/static/admin/js/xadmin.js"></script>



</head>
<body class="login-bg">

    <div class="login layui-anim layui-anim-up">
        <div class="message">x-OA 管理登录</div>
        <div id="darkbannerwrap"></div>

        <form method="post" class="layui-form" >
            <input name="number" placeholder="ID"  type="text" lay-verify="required" class="layui-input" >
            <hr class="hr15">
            <input name="password" lay-verify="required" placeholder="密码"  type="password" class="layui-input">
            <hr class="hr15">
            <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
            <hr class="hr20" >
        </form>
    </div>

    <script>
        $(function  () {
            layui.use('form', function(){
              var form = layui.form;

              //监听提交
              form.on('submit(login)', function(data){
                // alert(888)
                var number = $('input[name=number]').val();
                var password = $('input[name=password]').val();

                $.post('/login',{number:number,password:password,'_token':"{{csrf_token()}}"},function(res){

                    if (res.code == 0) {
                        layer.msg(res.msg);
                    }

                    if (res.code == 1) {
                        self.location.href="/";
                    }

                });

                return false;
              });
            });
        })
    </script>


</body>
</html>
