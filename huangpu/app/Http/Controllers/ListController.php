<?php
/**
 * Created by PhpStorm.
 * User: 潘伟
 * Date: 2020-08-20
 * Time: 22:01
 */

namespace App\Http\Controllers;

use App\Models\Register;
use Illuminate\Http\Request;

class ListController
{
    public function index(Request $request)
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

        return [
            'data'    => $data,
            'code'    => 0,
            'message' => 'success',
        ];
    }

    public function export()
    {
        
    }
}