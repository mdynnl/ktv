<?php

namespace App\Http\Livewire;

use App\Models\ExpenseType;
use App\Traits\WithPrinting;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LiveExpenseSummaryReport extends Component
{
    use WithPrinting;

    public $expenseTypes;
    public $fromDate;
    public $toDate;

    public function print()
    {
        $date = now()->format('Y-m-d');
        $data = [
            'fromDate' => $this->fromDate,
            'toDate' => $this->toDate,
            'expenseTypes' => $this->expenseTypes,
        ];

        return $this->printToPDF('pdf.expense-summary-pdf', $data, $date, 'Expense-Summary', 'P');
    }

    public function hydrate()
    {
        $this->loadSummary();
    }

    public function mount()
    {
        $this->toDate = today()->toDateString();
        $this->fromDate = today()->subWeek()->toDateString();
    }

    public function render()
    {
        $this->loadSummary();
        return view('livewire.live-expense-summary-report');
    }

    protected function loadSummary()
    {
        $this->expenseTypes = ExpenseType::with(['expenses' => function ($query) {
            $query->select('id', 'expense_type_id', DB::raw('price * qty as amount'))
            ->whereDate('expense_date', '>=', $this->fromDate)
            ->whereDate('expense_date', '<=', $this->toDate);
        }])
        ->get();
    }
}
