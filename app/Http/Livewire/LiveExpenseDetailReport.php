<?php

namespace App\Http\Livewire;

use App\Models\Expense;
use App\Traits\WithPrinting;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LiveExpenseDetailReport extends Component
{
    use WithPrinting;

    public $fromDate;
    public $toDate;

    public function print()
    {
        $date = now()->format('Y-m-d');

        $data['fromDate'] = $this->fromDate;
        $data['toDate'] = $this->toDate;

        $data['expenseGroup'] = Expense::with('expenseType:id,expense_type_name')
        ->select('*', DB::raw('price * qty as amount'))
        ->whereDate('expense_date', '>=', $this->fromDate)
        ->whereDate('expense_date', '<=', $this->toDate)
        ->get()
        ->groupBy(function ($expense) {
            return $expense->expenseType->expense_type_name;
        });

        return $this->printToPDF('pdf.expense-detail-pdf', $data, $date, 'Expense-Detail', 'L');
    }

    public function mount()
    {
        $this->toDate = today()->toDateString();
        $this->fromDate = today()->subWeek()->toDateString();
    }

    public function render()
    {
        return view('livewire.live-expense-detail-report', [
            'expenseGroup' => Expense::with('expenseType:id,expense_type_name')
            ->select('*', DB::raw('price * qty as amount'))
            ->whereDate('expense_date', '>=', $this->fromDate)
            ->whereDate('expense_date', '<=', $this->toDate)
            ->get()
            ->groupBy(function ($expense) {
                return $expense->expenseType->expense_type_name;
            })
        ]);
    }

    protected function loadExpenseDetails()
    {
    }
}
