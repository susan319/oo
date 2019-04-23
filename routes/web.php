<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




/**********登录 退出***********/
Route::any('/login','LoginController@login');       //登录
Route::get('/outLogin','LoginController@outLogin'); //退出登录





/********Admin**********/
Route::group(['middleware'=>['check.login']],function(){



	Route::get('/','IndexController@index');
	Route::get('/welcome','IndexController@welcome');

	Route::any('/testingUrl','CommonController@testingUrl'); //检测url
	Route::any('/rate/setting','CommonController@setExchangeRate');//设置汇率


	/*****rbac******/
	Route::group(['namespace' => 'Rbac'],function () {

		//菜单管理
		Route::get('/rbac/menu','MenuController@index');
		Route::any('/rbac/menu/add','MenuController@add');
		Route::any('/rbac/menu/edit','MenuController@edit');
		Route::any('/rbac/menu/delete','MenuController@delete');
		//根据ID获取子菜单
		Route::post('/rbac/menu/get_submenu','MenuController@getSubmenu');


		//角色管理
		Route::get('/rbac/role','RoleController@index');
		Route::any('/rbac/role/add','RoleController@add');
		Route::any('/rbac/role/edit','RoleController@edit');
		//设置角色权限
		Route::any('/rbac/role/set_auth','RoleController@setAuth');

	});
	/*****rbac******/


	/*******部门********/
	Route::get('/department','DepartmentController@index');
	Route::any('/department/add','DepartmentController@add');
	Route::any('/department/edit','DepartmentController@edit');


	//部门薪资结构
    Route::get('/salary_structure','SalaryStructureController@index');
    Route::any('/salary_structure/add','SalaryStructureController@add');
    Route::any('/salary_structure/edit','SalaryStructureController@edit');


    //员工
    Route::any('/staff','StaffController@index');
	Route::any('/staff/add','StaffController@add');
	Route::any('/staff/edit','StaffController@edit');
	Route::any('/staff/delete','StaffController@delete');
	//获取子部门和所属薪资
	Route::post('/staff/subsidiary','StaffController@subsidiary');
	//员工生日
	Route::any('/salary/todays_birthday','StaffController@todaysBirthday');

     /******统计2******/
    Route::get('/promotion/posts','PromotionController@index'); //推广首页
    Route::any('/promotion/posts/add','PromotionController@add'); //绩效计算
    Route::any('/promotion/posts/calculation','PromotionController@calculation'); //工资计算
    Route::any('/promotion/posts/see','PromotionController@see'); //查看
    Route::any('/promotion/clear','PromotionController@clear'); //清空
    //设置特殊岗位评分
    Route::any('/promotion/special_position_score','PromotionController@specialPositionScore');

    /********其他岗位**********/
    Route::get('/other/posts','OtherPostsController@index');
    Route::any('/other/posts/calculation','OtherPostsController@calculation');
	Route::any('/other/posts/see','OtherPostsController@see');



    /******************
    *宿舍管理
    *
    ******************/
    //公寓分布
    Route::get('/dormitory_management/apartment','ApartmentController@index');
    Route::any('/dormitory_management/apartment/add','ApartmentController@add');
    Route::any('/dormitory_management/apartment/edit','ApartmentController@edit');
    Route::any('/dormitory_management/apartment/delete','ApartmentController@delete');
    //获取公寓所属的房间
    Route::post('/dormitory_management/room','ApartmentController@room');
    //入住情况
    Route::get('/dormitory_management/dormitory','ApartmentController@dormitory');
    //入住修改
    Route::any('/dormitory_management/dormitory/edit','ApartmentController@dormitoryEdit');



    /******************
    *个人中心
    *
    ******************/

    /*********我的便签***********/
    Route::any('/personal/mynotes','PersonalController@myNotes');
    Route::any('/personal/mynotes/add','PersonalController@myNotesAdd');
    Route::any('/personal/mynotes/delete','PersonalController@myNotesDelete');

    Route::any('/personal/salary','PersonalController@salary');

});

