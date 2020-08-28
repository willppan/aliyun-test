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
        $templateProcessor->setValue('company', $data['company']);
        $templateProcessor->setValue('date', $date);
        $templateProcessor->setValue('name', $data['name']);
        $templateProcessor->setValue('sex', $data['sex']);
        $templateProcessor->setValue('birthday', $data['birthday']);
        $templateProcessor->setValue('face', $data['face']);
        $templateProcessor->setValue('id_card', $data['id_card']);

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