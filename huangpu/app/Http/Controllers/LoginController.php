<?php
/**
 * Created by PhpStorm.
 * User: 潘伟
 * Date: 2020-08-20
 * Time: 22:01
 */

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController
{
    public function index(Request $request)
    {
        // 账户验证
        $account = trim($request->post('username'));
        if (empty($account)) {
            return response()->json([
                'code'    => 10000,
                'message' => '账号不能为空！',
            ]);
        }
        if($account != 'admin'){
            return response()->json([
                'code'    => 10000,
                'message' => '账号密码错误！',
            ]);
        }

        // 密码验证
        $password = trim($request->post('password'));
        if (empty($password)) {
            return response()->json([
                'code'    => 10000,
                'message' => '密码不能为空！',
            ]);
        }

        // 管理员密码错误
        if ('huangpu2020..' != $password) {
            return response()->json([
                'code'    => 10000,
                'message' => '账号密码错误！',
            ]);
        }

        $admin = Admin::query()->where('username',$account)->first();

        // 认证信息保存
        Auth::guard('admin')->login($admin);

        return [
            'id'              => $admin->id,
            'username'        => $admin->username,
        ];
    }
}