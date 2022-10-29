<?php

namespace App\Http\Livewire;

use App\Traits\WithPrinting;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LiveSalesSummaryReport extends Component
{
    use WithPrinting;
    public $dateFrom;
    public $dateTo;
    public $salesSummary;

    public function print()
    {
        $data['date_from'] = $this->dateFrom;
        $data['date_to'] = $this->dateTo;
        $data['salesSummary'] = $this->salesSummary;
        return $this->printToPDF('pdf.sales-summary-pdf', $data, today()->toDateString(), "Sales-Summary", 'L');
    }

    public function hydrate()
    {
        $this->salesSummary = $this->getSalesSummary();
    }

    public function mount()
    {
        $this->dateFrom = today()->subDay()->toDateString();
        $this->dateTo = today()->toDateString();
    }

    public function render()
    {
        $this->salesSummary = $this->getSalesSummary();

        return view('livewire.live-sales-summary-report');
    }

    public function getSalesSummary()
    {
        return DB::select(
            "SELECT
				operation_date, id, room_amount, fb_amount, service_amount, cash, card, credit, total_amount, tax, service, total_amount - (tax + service) net_amount
			from
			(
				select operation_date, id, commercial_tax_amount as tax, service_tax_amount as service,
				case
					when payment_type_id = 1 then total
					else 0
				end as 'cash',
				case
					when payment_type_id = 2 then total
					else 0
				end as 'card',
				case
					when payment_type_id = 3 then total
					else 0
				end as 'credit',
					total as 'total_amount'
				from inhouses
			) x
			left join (
				select inhouse_id, sum(rAmt) as room_amount, sum(fAmt) as fb_amount, sum(sAmt) as service_amount
				from
				(
					select inhouse_id,
					case
						when group_no = 1 then sum(price * qty)
						else 0
					end 'rAmt',
					case
						when group_no = 2 then sum(price * qty)
						else 0
					end 'fAmt',
					case
						when group_no = 3 then sum(price * qty)
						else 0
					end 'sAmt'
					from view_information_invoices
					group by inhouse_id, group_no
				) a
				group by inhouse_id
			) y on x.id = y.inhouse_id
			where convert(operation_date, date ) >= '$this->dateFrom'
			and convert(operation_date, date) <= '$this->dateTo'
			"
        );
    }
}
