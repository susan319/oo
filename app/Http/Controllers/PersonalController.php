<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\NotesModel;
use App\Models\StaffModel;
use App\Models\OtherPosts;
use App\Models\ExchangeRateModel;
use App\Models\FlowingWaterModel;

class PersonalController extends CommonController
{



    /*****我的便签******/
    public function myNotes(Request $request)
    {
        $rs = NotesModel::where('number',$this->number)->get();
        return view('personal.myNotes')->with('rs',$rs);
    }


    public function myNotesAdd(Request $request)
    {

        $data['content'] = $request->content;
        $data['number'] = $this->number;

        return (new NotesModel())->myAdd($data);
    }

    public function myNotesDelete(Request $request)
    {
        $rs = NotesModel::where(['id'=>$request->id])->delete();
        return ['code'=>1,'msg'=>'ok'];
    }




    /****我的薪资*****/
    public function salary (Request $Request)
    {
        /***
        *这里为了找到该number 是那个大部门的人
        ***/
        $department_id = StaffModel::where('number',$this->number)->first()->department_id;
        $department =  getPrentDepartmentID($department_id);


        $data = [];

        $data['rate'] = ExchangeRateModel::first()->rate; //注入汇率
        $data['otherPosts']   = OtherPosts::where('number',$this->number)->first();
        // ID为3 表示他是推广部们的人
        if ( $department->id == 3) {
            $data['flag'] = 'extension';
            $data['flowing'] = (new FlowingWaterModel())->where('number',$this->number)->first();
        } else {
            $data['flag'] = 'other';
        }
        return view('personal.salary',compact('data'));
    }

}
