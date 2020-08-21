<?php
/**
 * Created by PhpStorm.
 * User: 潘伟
 * Date: 2020-08-20
 * Time: 22:16
 */

namespace App\Models;

class Register extends BaseModel
{
    /**
     * 表名称
     *
     * @var string
     */
    protected $table = 'register';

    protected $fillable = [
        'id_card',
        'phone',
        'name',
        'company',
        'date',
    ];
}