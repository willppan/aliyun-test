<?php
/**
 * Created by PhpStorm.
 * User: 潘伟
 * Date: 2020-08-22
 * Time: 12:18
 */

namespace App\Http\Controllers;


class WebController
{
    public function index()
    {
        return view('index');
    }

    public function login()
    {
        return view('login');
    }
}