<?php

namespace App\Exports;

use App\Models\Expense;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ExpenseExport implements FromView
{
    protected $expenses;
    public function __construct($expenses){
        $this->expenses = $expenses;
    }
    public function view(): View
    {
        return view('expense.sheet',['expenses' => $this->expenses]);
    }
}
