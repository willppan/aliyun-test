<?php
/**
 * Created by PhpStorm.
 * User: lianghuan
 * Date: 2019-08-28
 * Time: 10:46
 */

namespace App\Library\Excel;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class FormatExport implements FromCollection, WithHeadings, WithEvents, WithColumnFormatting
{
    use Exportable;

    /**
     * 导出数据
     *
     * @var array
     */
    private $data;

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
     * 单元格字段
     *
     * @var array
     */
    protected $cellLetter = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q', 'R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD', 'AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN', 'AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ'];

    /**
     * FormatExport constructor.
     * @param $data
     * @param $headings
     * @param $width
     */
    public function __construct($data, $headings, $width)
    {
        $this->data = $data;
        $this->headings = $headings;
        $this->width = $width;
    }

    /**
     * 自定义注册事件
     * @author 梁欢 lianghuan@vchangyi.com
     * @date 2019/08/28
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // 合并头单元格
                // $event->sheet->getDelegate()->setMergeCells(['A1:H1']);

                // 如果导出数据不为空
                if (!empty($this->data) && isset($this->data[0])) {
                    // 获取总行数，如果存在头就给行加1
                    $rowCount = count($this->data);
                    if (!empty($this->headings)) {
                        $rowCount++;
                    }

                    // 循环行，给所有行设置水平和垂直居中
                    for ($row = 0; $row < $rowCount; $row++) {
                        $string = $this->cellLetter[0].($row+1).':'.$this->cellLetter[count($this->data[0]) - 1].($row+1);
                        $event->sheet->getDelegate()->getStyle($string)->getAlignment()
                            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                            ->setVertical(Alignment::HORIZONTAL_CENTER);
                        // 头部设置颜色
                        if (empty($row)) {
                            $event->sheet->getDelegate()->getStyle($string)->applyFromArray([
                                'font' => [
                                    'name' => 'Arial',
                                    'bold' => true,
                                    'italic' => false,
                                    'strikethrough' => false,
                                    'color' => [
//                                        'rgb' => '0000ff'
                                    ]
                                ],
                                /*
                                // 背景色
                                'fill' => [
                                    'fillType' => 'linear', //线性填充，类似渐变
                                    'rotation' => 45, //渐变角度
                                    'startColor' => [
                                        'rgb' => '0000ff' //初始颜色
                                    ],
                                    //结束颜色，如果需要单一背景色，请和初始颜色保持一致
                                    'endColor' => [
                                        'argb' => '0000ff'
                                    ]
                                ]*/
                            ]);
                        }
                    }

                    // 循环列，如果有给列设置宽度，读取设置的宽度，否则默认为20
                    for ($column = 0; $column < count($this->data[0]); $column++) {
                        if (isset($this->cellLetter[$column])) {
                            $columnWord = $this->cellLetter[$column];
                            if (isset($this->width[$columnWord])) {
                                $event->sheet->getDelegate()->getColumnDimension($columnWord)->setWidth($this->width[$columnWord]);
                            } else {
                                $event->sheet->getDelegate()->getColumnDimension($columnWord)->setWidth(20);
                            }
                        }
                    }
                }
            }
        ];
    }

    /**
     * 设置导出数据
     * @author 梁欢 lianghuan@vchangyi.com
     * @date 2019/08/28
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect($this->data);
    }

    /**
     * 设置导出头
     * @author 梁欢 lianghuan@vchangyi.com
     * @date 2019/08/28
     * @return array
     */
    public function headings(): array
    {
        return $this->headings;
    }

    /**
     * 格式化列
     * @author 梁欢 lianghuan@vchangyi.com
     * @date 2019/08/28
     * @return array
     */
    public function columnFormats(): array
    {
        $result = [];
        if (!empty($this->data) && isset($this->data[0])) {
            for ($column = 0; $column < count($this->data[0]); $column++) {
                if (isset($this->cellLetter[$column])) {
                    $result[$this->cellLetter[$column]] = NumberFormat::FORMAT_GENERAL;
                }
            }
        }
        return $result;
    }
}
