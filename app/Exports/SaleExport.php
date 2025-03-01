<?php

namespace App\Exports;

use App\Models\Sale;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class SaleExport implements FromView
{
    protected $sales;
    public function __construct($sales){
        $this->sales = $sales;
    }
    public function view(): View
    {
        return view('sale.sheet',['sales' => $this->sales]);
    }
}
