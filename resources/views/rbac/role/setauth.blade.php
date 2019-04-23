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




    <link rel="stylesheet" href="/static/admin/Plug/css/bootstrapStyle/bootstrapStyle.css" type="text/css">
    <script type="text/javascript" src="/static/admin/Plug/js/jquery.ztree.core.js"></script>
    <script type="text/javascript" src="/static/admin/Plug/js/jquery.ztree.excheck.js"></script>
    <script type="text/javascript" src="/static/admin/Plug/js/jquery.ztree.exedit.js"></script>



    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
      <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body class="layui-anim ">


        <ul id="treeDemo" class="ztree"></ul>

  </body>



  <script type="text/javascript">



    var zNodes = {!!$auths!!};
    var role_id = "{{$role_id}}";

    var setting = {

            showIcon : false,

            view: {
                selectedMulti: false,
            },

            check: {
                enable: true,     //这里设置是否显示复选框

            },
            data: {
                simpleData: {
                    enable: true,
                    idKey: "id",
                    pIdKey: "pid",
                }
            },
            callback:{
                beforeCheck:true,
                onCheck:onCheck, //点击复选框执行事件
            },

        };

        $(document).ready(function(){
           let treeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
           treeObj.expandAll(true); //展开
        });

        function onCheck(e,treeId,treeNode) {
            var treeObj=$.fn.zTree.getZTreeObj("treeDemo"),
            nodes=treeObj.getCheckedNodes(true),

            ids="";
            for(var i=0;i<nodes.length;i++){
                ids+=nodes[i].id + ",";
            }


            $.post('/rbac/role/set_auth',{id:role_id,auth_ids:ids,'_token':"{{csrf_token()}}",},function(res){
                    if (res.code == 1) {
                        layer.msg(res.msg);
                    }
            });
        }


  </script>


</html>
