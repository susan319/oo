<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Rbac\RoleModel;    //角色
use App\Models\Rbac\MenusModel;   //菜单
use App\Models\ExchangeRateModel; //汇率

class CommonController extends Controller
{

	protected $number;  //员工ID

	public function __construct()
    {
        $this->middleware(function ($request, $next) {
	        $this->number = session()->get('number');
	        return $next($request);
    	});
    }


    /***设置汇率****/
    public function setExchangeRate (Request $request)
    {
        if ($request->isMethod('post')) {

            if ( !is_numeric($request->rate) ) {
                return ['code' => 0,'msg' => '汇率只能是数字'];
            }

            if ( ExchangeRateModel::where('id',1)->update(['rate' => $request->rate]) )
                return ['code' => 1,'msg' => '设置成功'];
            else
                return ['code' => 0, 'msg' => '设置失败,请重新设置'];
        } else {
            $rate = ExchangeRateModel::first()->rate;
            return view('common.setExchangeRate',compact('rate'));
        }
    }


    /*********检测url**********/
    public function testingUrl(Request $request)
    {

    	/**检测是否登录或是否登陆过期**/
    	if (!session('login_token') ) {
            return ['code' => 0, 'msg' => '登录过期,请刷新页面'];
        }



        /***********检测链接是否有权限访问URL***************/

        // 1. 获取检测的url
        if ( strpos($request->url,'?') !== false ) {
        	$url = substr($request->url,0,strpos($request->url,'?'));
        } else {
        	$url = $request->url;
        }

        //$url 是用户点击进来的链接
        $role_id = session('role_id');
        $roles = RoleModel::where('id',$role_id)->first();
		//获取ids
		$ids =  explode(',',$roles['auth_ids']);
        $menus = MenusModel::whereIn('id',$ids)
                    ->where('status',1)
                    ->orderBy('order','desc')
                    ->get()
                    ->toArray();

    	$bool = array_search($url,array_column($menus,'router'));
      	if ($bool === false) {
      		return ['code'=>0,'msg'=>'你没有访问权限,如果需要此权限请联系管理员！'];
      	}

    }




}
