<?php
/**
 * Created by PhpStorm.
 * User: lianghuan
 * Date: 2019-08-28
 * Time: 10:46
 */

namespace App\Library\Excel;

use Maatwebsite\Excel\Facades\Excel;

/**
 * Class ExcelExport
 * @package App\Library\Excel
 */
class ExcelExport
{
    /**
     * 导出数据
     *
     * @var array
     */
    private $data;

    /**
     * 导出文件名称
     *
     * @var array
     */
    private $fileName;

    /**
     * 导出头数据
     *
     * @var array
     */
    private $headings;

    /**
     * 自定义宽
     *
     * @var array
     */
    private $width;

    /**
     * ExcelExport constructor.
     * @param array $array
     */
    public function __construct($array = [])
    {
        $this->data = $array['data'] ?? [];
        $this->fileName = $array['fileName'] ?? 'default';
        $this->headings = $array['headings'] ?? [];
        $this->width = $array['width'] ?? [];
    }

    /**
     * 导出Excel
     * @author 梁欢 lianghuan@vchangyi.com
     * @date 2019/08/28
     */
    public function export()
    {
        $result = new FormatExport($this->data, $this->headings, $this->width);

        return Excel::download($result, $this->fileName.'.xlsx');
    }

}
