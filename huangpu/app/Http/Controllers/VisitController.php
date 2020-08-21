<?php
/**
 * Created by PhpStorm.
 * User: 潘伟
 * Date: 2020-08-20
 * Time: 22:55
 */

namespace App\Http\Controllers;


use App\Models\Visit;

class VisitController
{
    public function index()
    {
        Visit::query()->where('id',1)->increment('num');
        return [
            'data'    => [],
            'code'    => 0,
            'message' => 'success',
        ];
    }


    public function count()
    {
        $num = Visit::query()->where('id',1)->sum('num');
        return [
            'data'    => [
                'num' => $num
            ],
            'code'    => 0,
            'message' => 'success',
        ];
    }
}