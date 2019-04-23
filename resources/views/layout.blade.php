<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>X-admin2.0</title>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="/static/admin/css/font.css">
	<link rel="stylesheet" href="/static/admin/css/xadmin.css">


    <script type="text/javascript" src="/static/admin/js/jquery-3-2-1.js"></script>

    <script src="/static/admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="/static/admin/js/xadmin.js"></script>

</head>
<body>



  <div id="app">
      <!-- 顶部开始 -->
      @yield('content')
  </div>




  @yield('js')

</body>
</html>
