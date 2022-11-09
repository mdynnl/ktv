<?php

namespace App\Http\Livewire;

use App\Traits\WithPrinting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LiveProfitSummaryReport extends Component
{
    use AuthorizesRequests;
    use WithPrinting;

    public $expenses;
    public $incomes;
    public $fromDate;
    public $toDate;

    public function print()
    {
        $date = now()->format('Y-m-d');
        $total_income = 0;
        foreach ($this->incomes as $income) {
            $total_income += $income->amount;
        }

        $total_expense = 0;
        foreach ($this->expenses as $expense) {
            $total_expense += $expense->amount;
        }

        $range = 0;
        if (count($this->incomes) > count($this->expenses)) {
            $range = count($this->incomes);
        } else {
            $range = count($this->expenses);
        }

        $data = [
            'fromDate' => $this->fromDate,
            'toDate' => $this->toDate,
            'range' => $range,
            'expenses' => $this->expenses,
            'incomes' => $this->incomes,
            'total_income' => $total_income,
            'total_expense' => $total_expense,
            'profit' => $total_income - $total_expense,
        ];

        return $this->printToPDF('pdf.profit-summary-pdf', $data, $date, 'Profit-Summary', 'P');
    }

    public function hydrate()
    {
        $this->loadIncomes();
        $this->loadExpenses();
    }

    public function mount()
    {
        $this->authorize('view reports');

        $this->toDate = today()->toDateString();
        $this->fromDate = today()->subWeek()->toDateString();
    }

    public function render()
    {
        $this->loadIncomes();
        $this->loadExpenses();
        return view('livewire.live-profit-summary-report');
    }

    protected function loadIncomes()
    {
        $this->incomes = DB::select(
            "SELECT
			income,
			sum(amount) as amount
			from
			(
				select
				inhouses.operation_date,
				'KTV' as income,
				sum(inhouses.total) as amount
				from
				inhouses
				group by
				inhouses.operation_date
				union
				select
				orders.operation_date,
				'F&B' as income,
				sum(orders.sub_total) as amount
				from
				orders
				group by
				orders.operation_date
				union
				select
				o.operation_date,
				'F&B Cost (-)' as income,
				sum(((od.food_cost * od.qty) * -1)) as amount
				from
				orders o
				left join order_details od on od.order_id = o.id
				group by
				o.operation_date
				union
				select
				inhouse_services.operation_date,
				'Service Staff' as income,
				sum(session_hours * service_staff_rate) as amount
				from
				inhouse_services
				group by
				inhouse_services.operation_date
				union
				select
				inhouse_services.operation_date,
				'Commission (-)' as income,
				sum(
					(session_hours * service_staff_commission_rate) * -1
				) as amount
				from
				inhouse_services
				group by
				inhouse_services.operation_date
			) x
			where operation_date >= '$this->fromDate' and operation_date <= '$this->toDate'
			group by
				income
		"
        );
    }

    protected function loadExpenses()
    {
        $this->expenses = DB::select(
            "SELECT
			expense,
			sum(amount) as amount
			from
			(
				select
				et.id,
				e.expense_date,
				et.expense_type_name as expense,
				e.price * e.qty as amount
				from
				expenses e
				left join expense_types et on et.id = e.expense_type_id
			) x
			where
			x.expense_date >= '$this->fromDate' and x.expense_date <= '$this->toDate'
			group by
			expense
		"
        );
    }
}
