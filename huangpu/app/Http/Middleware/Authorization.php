<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use \Illuminate\Support\Facades\Auth;
/**
 * Class Authorization
 * @package App\Http\Middleware
 */
class Authorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 登录验证
        if (!Auth::guard('admin')->check()) {
            return response()->json([
                'code'    => 10000,
                'message' => '用户未登录！',
            ]);
        }

        // 平台管理员信息查询
        $admin = Admin::query()->where(['id' => Auth::guard('admin')->id()])->first();

        $request->admin = [
            'id' => $admin->id,
            'username' => $admin->username,
        ];

        return $next($request);
    }
}
