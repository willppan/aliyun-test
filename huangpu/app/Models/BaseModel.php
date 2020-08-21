<?php
/**
 * Created by PhpStorm.
 * User: panwei
 * Date: 2019-08-12
 * Time: 09:39
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    /**
     * 设置日期时间格式
     *
     * @var string
     */
    public $dateFormat = 'U';

    /**
     * 需要被转换日期时间格式的字段
     *
     * @var array
     */
    protected $dates = [
        'updated_at',
    ];

}
