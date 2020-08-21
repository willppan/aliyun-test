<?php
/**
 * Created by PhpStorm.
 * User: qian
 * Date: 2019/8/28
 * Time: 10:53
 */
namespace App\Library\Excel;

use Maatwebsite\Excel\Concerns\FromArray;

class Export implements FromArray
{
    protected $invoices;

    public function __construct(array $invoices)
    {
        $this->invoices = $invoices;
    }

    public function array(): array
    {
        return $this->invoices;
    }
}
