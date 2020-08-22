<?php
/**
 * Created by PhpStorm.
 * User: 潘伟
 * Date: 2020-08-20
 * Time: 22:01
 */

namespace App\Http\Controllers;

use App\Library\Excel\ExcelExport;
use App\Models\Register;
use Illuminate\Http\Request;

class ListController
{
    public function index(Request $request)
    {
        $params = $request->only(['company','date','term']);

        $data = Register::query()
            ->when(!empty($params['date']),function ($query) use($params){
                $query->where('date',$params['date']);
            })
            ->when(!empty($params['term']),function ($query) use($params){
                $query->where('term',$params['term']);
            })
            ->when(!empty($params['company']),function ($query) use($params){
                $query->where('company',$params['company']);
            })
            ->get()
            ->toArray();

        return [
            'data'    => $data,
            'code'    => 0,
            'message' => 'success',
        ];
    }

    public function export(Request $request)
    {
        $params = $request->only(['company','date']);

        $data = Register::query()
            ->when(!empty($params['date']),function ($query) use($params){
                $query->where('date',$params['date']);
            })
            ->when(!empty($params['company']),function ($query) use($params){
                $query->where('company',$params['company']);
            })
            ->get()
            ->toArray();
        $export = [];
        foreach($data as $key=> $item){
            $export[] = [
                $key+1,
                $item['name'],
                $item['phone'],
                $item['id_card']."\t",
                $item['company'],
                $item['date'],
                $item['term'],
            ];
        }
        return (new ExcelExport([
            'fileName' => '预约考生信息',
            'data'     => $export,
            'headings' => [
                '序号',
                '姓名',
                '手机号',
                '身份证号',
                '报考单位',
                '预约日期',
                '预约场次'
            ],
            'width' => [
                'A' => 10,
                'B' => 10,
                'C' => 20,
                'D' => 30,
                'E' => 40,
                'F' => 10,
                'G' => 10,
            ]
        ]))->export();
    }
}