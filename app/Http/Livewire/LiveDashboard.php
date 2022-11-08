<?php

namespace App\Http\Livewire;

use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LiveDashboard extends Component
{
    public $salesAndGrossProfits;
    public $expenses;
    public $top10ServiceStaffs;
    public $overviewSales;

    public $fromDate;
    public $toDate;

    // Graph Settings
    public $viewDailyMonthlyYearly = 1;
    public $animateOnFirstRun = true;
    public $showDataLabels = false;

    public $colors = [
        'service_staff' => '#f6ad55',
        'shopping' => '#fc8181',
        'entertainment' => '#90cdf4',
        'travel' => '#66DA26',
        'other' => '#cbd5e0',
    ];

    public function mount()
    {
        $this->fromDate = today()->subMonth()->toDateString();
        $this->toDate = today()->toDateString();
    }
    public function render()
    {
        if ($this->viewDailyMonthlyYearly == 1) {
            $this->dailySalesAndGrossProfits();
            $this->dailyExpenses();
            $this->dailyOverviewSales();
        } elseif ($this->viewDailyMonthlyYearly == 2) {
            $this->monthlySalesAndGrossProfits();
            $this->monthlyExpenses();
            $this->monthlyOverviewSales();
        } else {
            $this->yearlySalesAndGrossProfits();
            $this->yearlyExpenses();
            $this->yearlyOverviewSales();
        }
        $this->top10ServiceStaffs();



        $expenseAreaChartModel = $this->expenses->reduce(
            function ($areaChartModel, $data) {
                if ($this->viewDailyMonthlyYearly == 1) {
                    $date = Carbon::parse($data->expense_date)->format('M d');
                } elseif ($this->viewDailyMonthlyYearly == 2) {
                    $date = Carbon::parse($data->expense_year . '-' . $data->expense_month)->format('Y M');
                } else {
                    $date = $data->expense_year;
                }
                return $areaChartModel->addPoint($date, $data->amount);
            },
            LivewireCharts::areaChartModel()
            ->setAnimated($this->animateOnFirstRun)
            ->setColor('#F0E68C')
            ->withOnPointClickEvent('onAreaPointClick')
            ->setDataLabelsEnabled($this->showDataLabels)
            ->legendPositionRight()
            ->sparklined()
        );


        $salesAreaChartModel = $this->salesAndGrossProfits->reduce(
            function ($areaChartModel, $data) {
                if ($this->viewDailyMonthlyYearly == 1) {
                    $date = Carbon::parse($data->operation_date)->format('M d');
                } elseif ($this->viewDailyMonthlyYearly == 2) {
                    $date = Carbon::parse($data->operation_year . '-' . $data->operation_month)->format('Y M');
                } else {
                    $date = $data->operation_year;
                }
                return $areaChartModel->addPoint($date, round($data->total), ['id' => 0]);
            },
            LivewireCharts::areaChartModel()
            ->setAnimated($this->animateOnFirstRun)
            ->setColor('#90EE90')
            ->withOnPointClickEvent('onAreaPointClick')
            ->setDataLabelsEnabled($this->showDataLabels)
            ->sparklined()
        );

        $grossProfitsAreaChartModel = $this->salesAndGrossProfits->reduce(
            function ($areaChartModel, $data) {
                if ($this->viewDailyMonthlyYearly == 1) {
                    $date = Carbon::parse($data->operation_date)->format('M d');
                } elseif ($this->viewDailyMonthlyYearly == 2) {
                    $date = Carbon::parse($data->operation_year . '-' . $data->operation_month)->format('Y M');
                } else {
                    $date = $data->operation_year;
                }
                return $areaChartModel->addPoint($date, round($data->gross_profit), ['id' => 0]);
            },
            LivewireCharts::areaChartModel()
            ->setAnimated($this->animateOnFirstRun)
            ->setColor('#30579A')
            ->withOnPointClickEvent('onAreaPointClick')
            ->setDataLabelsEnabled($this->showDataLabels)
            ->sparklined()
        );

        $top10ServiceStaffColumnChartModel = $this->top10ServiceStaffs->reduce(
            function ($columnChartModel, $data) {
                $name = $data->nick_name;
                $value = $data->popularity;

                return $columnChartModel->addSeriesColumn('Session', $name, $value);
            },
            LivewireCharts::columnChartModel()
            ->setHorizontal(true)
            ->multiColumn()
            ->setAnimated($this->animateOnFirstRun)
            ->setDataLabelsEnabled($this->showDataLabels)
            ->setColors(['#9b1a53', '#ad1d5d', '#bf2067', '#d12370', '#dc2e7b', '#df4087', '#e25292', '#e5649e', '#e876a9', '#eb89b4'])
            ->setColumnWidth(90)
        );


        $overviewSalesMultiLineChartModel = $this->overviewSales->reduce(
            function ($multiLineChartModel, $data) {
                if ($this->viewDailyMonthlyYearly == 1) {
                    $date = Carbon::parse($data->operation_date)->format('M d');
                } elseif ($this->viewDailyMonthlyYearly == 2) {
                    $date = Carbon::parse($data->operation_year . '-' . $data->operation_month)->format('Y M');
                } else {
                    $date = $data->operation_year;
                }
                return $multiLineChartModel
                    ->addSeriesPoint($data->section, $date, round($data->total), ['id' => 0]);
            },
            LivewireCharts::multiLineChartModel()
            ->setAnimated($this->animateOnFirstRun)
            ->withOnPointClickEvent('onPointClick')
            ->setSmoothCurve()
            ->multiLine()
            ->setDataLabelsEnabled($this->showDataLabels)
            ->setColors(['#30579A', '#90EE90', '#ec3c3b'])
        );

        return view('livewire.live-dashboard', [
            'salesAreaChartModel' => $salesAreaChartModel,
            'grossProfitsAreaChartModel' => $grossProfitsAreaChartModel,
            'expenseAreaChartModel' => $expenseAreaChartModel,
            'top10ServiceStaffColumnChartModel' => $top10ServiceStaffColumnChartModel,
            'overviewSalesMultiLineChartModel' => $overviewSalesMultiLineChartModel,
        ]);
    }

    public function yearlyOverviewSales()
    {
        $this->overviewSales = collect(DB::select(
            "SELECT
			year(operation_date) as operation_year,
			case
			when group_no = 1 then 'Rooms'
			when group_no = 2 then 'F&B'
			else 'Service Staff'
			end section,
			group_no,
			sum(amount) as total
		from
			view_information_invoices v
			left join inhouses on inhouses.id = v.inhouse_id
		where
			operation_date >= '$this->fromDate'
			and operation_date <= '$this->toDate'
		group by
			group_no,
			operation_year
		order by
			operation_year
			"
        ));
    }

    public function monthlyOverviewSales()
    {
        $this->overviewSales = collect(DB::select(
            "SELECT
			month(operation_date) as operation_month,
			year(operation_date) as operation_year,
			case
			when group_no = 1 then 'Rooms'
			when group_no = 2 then 'F&B'
			else 'Service Staff'
			end section,
			group_no,
			sum(amount) as total
		from
			view_information_invoices v
			left join inhouses on inhouses.id = v.inhouse_id
		where
			operation_date >= '$this->fromDate'
			and operation_date <= '$this->toDate'
		group by
			group_no,
			operation_month, operation_year
		order by
			operation_month
			"
        ));
    }

    public function dailyOverviewSales()
    {
        $this->overviewSales = collect(DB::select(
            "SELECT
			operation_date,
			case when group_no = 1 then 'Rooms'
			when group_no = 2 then 'F&B'
			else 'Service Staff'
			end section,
			group_no,
			sum(amount) as total
		  from
			view_information_invoices v
			left join inhouses on inhouses.id = v.inhouse_id
			where operation_date >= '$this->fromDate' and operation_date <= '$this->toDate'
			group by group_no, operation_date
			order by operation_date
			"
        ));
    }

    public function yearlyExpenses()
    {
        $this->expenses = collect(DB::select(
            "SELECT
				year(expense_date) as expense_year,
				sum(price * qty) as amount
			from
				expenses
				where expense_date >= '$this->fromDate' and expense_date <= '$this->toDate'
			group by expense_year
			order by expense_year
			"
        ));
    }

    public function monthlyExpenses()
    {
        $this->expenses = collect(DB::select(
            "SELECT
				month(expense_date) as expense_month,
				year(expense_date) as expense_year,
				sum(price * qty) as amount
			from
				expenses
				where expense_date >= '$this->fromDate' and expense_date <= '$this->toDate'
			group by expense_month, expense_year
			order by expense_month
			"
        ));
    }

    public function dailyExpenses()
    {
        $this->expenses = collect(DB::select(
            "SELECT
				expense_date,
				sum(price * qty) as amount
			from
				expenses
				where expense_date >= '$this->fromDate' and expense_date <= '$this->toDate'
			group by expense_date
			order by expense_date
			"
        ));
    }

    public function yearlySalesAndGrossProfits()
    {
        $this->salesAndGrossProfits = collect(DB::select(
            "SELECT
			  s.operation_year,
			  total,
			  total - if(isnull(total_cost), 0, total_cost) - if(isnull(commission), 0, commission) as gross_profit
			from
			  (
				select
				  year(operation_date) as operation_year,
				  sum(total) as total
				from
				  inhouses
				where
				  operation_date >= '2022-10-29'
				  and operation_date <= '2022-11-05'
				group by
				  operation_year
			  ) s
			  left join (
				select
				  year(o.operation_date) as operation_year,
				  sum(d.food_cost * d.qty) as total_cost
				from
				  orders o
				  left join order_details d on o.id = d.order_id
				where
				  o.operation_date >= '2022-10-29'
				  and o.operation_date <= '2022-11-05'
				group by
				  operation_year
			  ) f on s.operation_year = f.operation_year
			  left join (
				select
				  year(i.operation_date) as operation_year,
				  sum(v.session_hours * service_staff_commission_rate) commission
				from
				  inhouses i
				  left join inhouse_services v on i.id = v.inhouse_id
				where
				  v.operation_date >= '2022-10-29'
				  and v.operation_date <= '2022-11-05'
				group by
				 operation_year
			  ) c on s.operation_year = c.operation_year
			"
        ));
    }

    public function monthlySalesAndGrossProfits()
    {
        $this->salesAndGrossProfits = collect(DB::select(
            "SELECT
			s.operation_month,
			s.operation_year,
			total,
			total - if(isnull(total_cost), 0, total_cost) - if(isnull(commission), 0, commission) as gross_profit
		  from
			(
			  select
				month(operation_date) as operation_month,
				year(operation_date) as operation_year,
				sum(total) as total
			  from
				inhouses
			  where
				operation_date >= '$this->fromDate'
				and operation_date <= '$this->toDate'
			  group by
				operation_year,
				operation_month
			) s
			left join (
			  select
				month(o.operation_date) as operation_month,
				year(o.operation_date) as operation_year,
				sum(d.food_cost * d.qty) as total_cost
			  from
				orders o
				left join order_details d on o.id = d.order_id
			  where
				o.operation_date >= '$this->fromDate'
				and o.operation_date <= '$this->toDate'
			  group by
				operation_year,
				operation_month
			) f on s.operation_month = f.operation_month
			left join (
			  select
				month(i.operation_date) as operation_month,
				year(i.operation_date) as operation_year,
				sum(v.session_hours * service_staff_commission_rate) commission
			  from
				inhouses i
				left join inhouse_services v on i.id = v.inhouse_id
			  where
				v.operation_date >= '$this->fromDate'
				and v.operation_date <= '$this->toDate'
			  group by
			   operation_month, operation_year
			) c on s.operation_month = c.operation_month
			order by operation_month
			"
        ));
    }

    public function dailySalesAndGrossProfits()
    {
        $this->salesAndGrossProfits = collect(DB::select(
            "SELECT
			s.operation_date,
			total,
			total - if(isnull(total_cost), 0, total_cost) - if(isnull(commission), 0, commission) as gross_profit
		  from
			(
			  select
				operation_date,
				sum(total) as total
			  from
				inhouses
			  where
				operation_date >= '$this->fromDate'
				and operation_date <= '$this->toDate'
			  group by
				operation_date
			) s
			left join (
			  select
				o.operation_date,
				sum(d.food_cost * d.qty) as total_cost
			  from
				orders o
				left join order_details d on o.id = d.order_id
			  where
				o.operation_date >= '$this->fromDate'
				and o.operation_date <= '$this->toDate'
			  group by
				o.operation_date
			) f on s.operation_date = f.operation_date
			left join (
			  select
				i.operation_date,
				sum(v.session_hours * service_staff_commission_rate) commission
			  from
				inhouses i
				left join inhouse_services v on i.id = v.inhouse_id
			  where
				v.operation_date >= '$this->fromDate'
				and v.operation_date <= '$this->toDate'
			  group by
				operation_date
			) c on s.operation_date = c.operation_date
			order by operation_date
			"
        ));
    }

    public function top10ServiceStaffs()
    {
        $this->top10ServiceStaffs = collect(DB::select(
            "SELECT
				service_staff_id,
				nick_name,
				sum(session_hours) as popularity
			from
			inhouse_services
			left join service_staff on service_staff.id = inhouse_services.service_staff_id

			where operation_date >= '$this->fromDate' and operation_date <= '$this->toDate'

			group by service_staff_id, nick_name
			order by popularity desc
			limit 10
			"
        ));
    }
}
