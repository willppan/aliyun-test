<?php
/**
 * Created by PhpStorm.
 * User: 潘伟
 * Date: 2020-08-28
 * Time: 10:51
 */

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpWord\TemplateProcessor;

class WordController
{
    public function index(Request $request)
    {
        $params = $request->only([
            'id_card','phone','name','hunyin',
            'name1','guanxi1','age1','zhengzhi1','gongzuo1',
            'name2','guanxi2','age2','zhengzhi2','gongzuo2',
            'name3','guanxi3','age3','zhengzhi3','gongzuo3',
        ]);

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

        $data = User::query()
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

        $path = storage_path('word/template.docx');
        // 生成world 存放目录

        $filePath = storage_path('word/'.$params['id_card'].'.docx');
        // 声明模板象并读取模板内容
        $templateProcessor = new TemplateProcessor($path);
        // 格式化时间
        $date = date('Y年m月d日',strtotime($data['date']));
        // 替换模板内容
        $templateProcessor->setValue('position', $data['position']);
        $templateProcessor->setValue('position_id', $data['position_id']);
        $templateProcessor->setValue('company', $data['company']);
        $templateProcessor->setValue('name', $data['name']);
        $templateProcessor->setValue('sex', $data['sex']);
        $templateProcessor->setValue('now_address', $data['now_address']);
        $templateProcessor->setValue('birthday', $data['birthday']);
        $templateProcessor->setValue('face', $data['face']);
        $templateProcessor->setValue('hukou_address', $data['hukou_address']);
        $templateProcessor->setValue('id_card', $data['id_card']);
        $templateProcessor->setValue('hunyin', $params['hunyin']);
        $templateProcessor->setValue('high_education', $data['high_education']);
        $templateProcessor->setValue('high_degree', $data['high_degree']);
        $templateProcessor->setValue('ben_date', $data['ben_date']);
        $templateProcessor->setValue('ben_school', $data['ben_school']);
        $templateProcessor->setValue('ben_education', $data['ben_education']);
        $templateProcessor->setValue('ben_major', $data['ben_major']);
        $templateProcessor->setValue('shuo_date', $data['shuo_date']);
        $templateProcessor->setValue('shuo_school', $data['shuo_school']);
        $templateProcessor->setValue('shuo_education', $data['shuo_education']);
        $templateProcessor->setValue('shuo_major', $data['shuo_major']);
        $templateProcessor->setValue('bo_date', $data['bo_date']);
        $templateProcessor->setValue('bo_school', $data['bo_school']);
        $templateProcessor->setValue('bo_education', $data['bo_education']);
        $templateProcessor->setValue('bo_major', $data['bo_major']);
        $templateProcessor->setValue('address', $data['address']);
        $templateProcessor->setValue('phone', $data['phone']);
        $templateProcessor->setValue('work_date1', $data['work_date1']);
        $templateProcessor->setValue('work_company1', $data['work_company1']);
        $templateProcessor->setValue('work_position1', $data['work_position1']);
        $templateProcessor->setValue('work_date2', $data['work_date2']);
        $templateProcessor->setValue('work_company2', $data['work_company2']);
        $templateProcessor->setValue('work_position2', $data['work_position2']);
        $templateProcessor->setValue('work_date3', $data['work_date3']);
        $templateProcessor->setValue('work_company3', $data['work_company3']);
        $templateProcessor->setValue('work_position3', $data['work_position3']);
        $templateProcessor->setValue('work_date4', $data['work_date4']);
        $templateProcessor->setValue('work_company4', $data['work_company4']);
        $templateProcessor->setValue('work_position4', $data['work_position4']);
        $templateProcessor->setValue('name1', $params['name1']);
        $templateProcessor->setValue('guanxi1', $params['guanxi1']);
        $templateProcessor->setValue('age1', $params['age1']);
        $templateProcessor->setValue('zhengzhi1', $params['zhengzhi1']);
        $templateProcessor->setValue('gongzuo1', $params['gongzuo1']);
        $templateProcessor->setValue('name2', $params['name2']);
        $templateProcessor->setValue('guanxi2', $params['guanxi2']);
        $templateProcessor->setValue('age2', $params['age2']);
        $templateProcessor->setValue('zhengzhi2', $params['zhengzhi2']);
        $templateProcessor->setValue('gongzuo2', $params['gongzuo2']);
        $templateProcessor->setValue('name3', $params['name3']);
        $templateProcessor->setValue('guanxi3', $params['guanxi3']);
        $templateProcessor->setValue('age3', $params['age3']);
        $templateProcessor->setValue('zhengzhi3', $params['zhengzhi3']);
        $templateProcessor->setValue('gongzuo3', $params['gongzuo3']);
        $templateProcessor->setValue('comment', $data['comment']);

        // 生成新的 world
        $templateProcessor->saveAs($filePath);
        $redisKey = 'word_'.$params['id_card'];
        Redis::set($redisKey,$filePath);
        return [
            'data'    => [
                'key' => $redisKey,
            ],
            'code'    => 0,
            'message' => 'success',
        ];
    }

    public function download(Request $request)
    {
        $params = $request->only(['key']);
        // 参数验证规则
        $rules = [
            'key'   => 'required',
        ];
        $message = [
            'key.required'  => 'token不能为空',
        ];
        Validator::make($params, $rules, $message)->validate();
        $filePath =  Redis::get($params['key']);
        if(empty($filePath)){
            return response()->json([
                'code'    => 10000,
                'message' => '下载失败！',
            ]);
        }
        // 下载文件
        $fileName = '广州市黄埔区广州开发区2020年公开招聘政府雇员报名表.docx';
        $encodedFileName = urlencode($fileName);
        header('Content-Type:text/html;charset=utf-8');
        header('Content-disposition:attachment;filename='.$encodedFileName);

        $fileSize = filesize($filePath);
        header('Content-length:' . $fileSize);
        readfile($filePath);
        @unlink($filePath);
    }
}