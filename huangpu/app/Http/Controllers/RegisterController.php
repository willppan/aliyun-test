<?php
/**
 * Created by PhpStorm.
 * User: 潘伟
 * Date: 2020-08-20
 * Time: 22:01
 */

namespace App\Http\Controllers;



use App\Models\Inquiry;
use App\Models\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController
{
    public function index(Request $request)
    {
        $params = $request->only(['id_card','phone','name','company','date','term']);
        // 参数验证规则
        $rules = [
            'id_card' => ['required','regex:
/^[1-9]\d{5}(18|19|20|(3\d))\d{2}((0[1-9])|(1[0-2]))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$/'],
            'phone'   => 'required|regex:/^1[345789][0-9]{9}$/',
            'name'    => 'required',
            'company' => 'required',
            'date'    => 'required',
            'term'    => 'required',
        ];
        $message = [
            'id_card.*' => '身份证号格式错误',
            'phone.*'   => '手机号格式错误',
            'name.required'    => '姓名不能为空',
            'company.required' => '所选单位不能为空',
            'date.required'    => '预约日期不能为空',
            'term.required'    => '预约场次不能为空',
        ];
        Validator::make($params, $rules, $message)->validate();
        // 8月28日上午9点
        if(time() < 1598576400){
            return response()->json([
                'code'    => 10000,
                'message' => '预约未开始！',
            ]);
        }

        if(time() >= 1598947200){
            return response()->json([
                'code'    => 10000,
                'message' => '预约已结束！',
            ]);
        }

        if ($params['date'] == '9月2日') {

        } else if ($params['date'] == '9月3日') {

        } else if ($params['date'] == '9月4日') {

        } else {
            return response()->json([
                'code'    => 10000,
                'message' => '预约时间有误，请重新选择！',
            ]);
        }
        if(!in_array($params['term'],['上午9:00-11:30','下午14:00-17:00'])){
            return response()->json([
                'code'    => 10000,
                'message' => '预约时间有误，请重新选择！',
            ]);
        }

        $count = Register::query()
            ->where('date',$params['date'])
            ->where('term',$params['term'])
            ->count();

        if($count >= 300){
            return response()->json([
                'code'    => 10000,
                'message' => '该时间段已约满，请选择其他时间预约！',
            ]);
        }

        $has = Register::query()
            ->where('id_card',$params['id_card'])
            ->orWhere('phone',$params['phone'])
            ->first();
        if(!empty($has)){
            return response()->json([
                'code'    => 10000,
                'message' => '请勿重复提交！',
            ]);
        }

        Register::query()->create($params);

        return [
            'data'    => [],
            'code'    => 0,
            'message' => 'success',
        ];
    }

    public function search(Request $request)
    {
        $params = $request->only(['id_card','phone','name']);
        // 参数验证规则
        $rules = [
            'id_card' => ['required','regex:
/^[1-9]\d{5}(18|19|20|(3\d))\d{2}((0[1-9])|(1[0-2]))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$/'],
            'phone'   => 'required|regex:/^1[345789][0-9]{9}$/',
            'name'    => 'required',
        ];
        $message = [
            'id_card.*' => '身份证号格式错误',
            'phone.*'   => '手机号格式错误',
            'name.required'    => '姓名不能为空',
        ];
        Validator::make($params, $rules, $message)->validate();


        $data = Inquiry::query()
            ->where('name',$params['name'])
            ->where('phone',$params['phone'])
            ->where('id_card',$params['id_card'])
            ->first();
        if(empty($data)){
            return response()->json([
                'code'    => 10000,
                'message' => '未查到此人信息！',
            ]);
        }

        return [
            'data'    => $data,
            'code'    => 0,
            'message' => 'success',
        ];
    }
}