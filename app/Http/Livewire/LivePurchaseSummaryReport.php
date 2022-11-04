<?php

namespace App\Http\Livewire;

use App\Traits\WithPrinting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LivePurchaseSummaryReport extends Component
{
    use AuthorizesRequests;
    use WithPrinting;

    public $dateFrom;
    public $dateTo;
    public $purchaseSummary;

    public function print()
    {
        $data['date_from'] = $this->dateFrom;
        $data['date_to'] = $this->dateTo;
        $data['purchaseSummary'] = $this->purchaseSummary;
        return $this->printToPDF('pdf.purchase-summary-pdf', $data, today()->toDateString(), "Purchase-Summary", 'L');
    }

    public function hydrate()
    {
        $this->purchaseSummary = $this->getPurchaseSummary();
    }

    public function mount()
    {
        $this->authorize('view reports');
        $this->dateFrom = today()->subDay()->toDateString();
        $this->dateTo = today()->toDateString();
    }

    public function render()
    {
        $this->purchaseSummary = $this->getPurchaseSummary();
        return view('livewire.live-purchase-summary-report');
    }

    public function getPurchaseSummary()
    {
        return DB::select(
            "SELECT purchases.id, invoice_no, suppliers.supplier_name as supplier, purchase_date,
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
			from
			  purchases
			  left join suppliers on suppliers.id = purchases.supplier_id
			  where convert(purchase_date, date) >= '$this->dateFrom'
			  and convert(purchase_date, date) <= '$this->dateTo'
			"
        );
    }
}
