<?php

namespace App\Exports;

use App\Models\Paymentwithprice;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class IncomeExport implements FromView
{
    protected $incomes;
    public function __construct($incomes){
        $this->incomes = $incomes;
    }
    public function view(): View
    {
        return view('income.sheet',['incomes' => $this->incomes]);
    }
}
