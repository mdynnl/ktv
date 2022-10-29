<?php

namespace App\Http\Livewire;

use App\Models\Inhouse;
use App\Traits\WithPrinting;
use Livewire\Component;

class LiveSalesDetailReport extends Component
{
    use WithPrinting;

    public $inhouses;
    public $dateFrom;
    public $dateTo;
    public $selectedGroups = [1, 2, 3];

    public function print()
    {
        $data['date_from'] = $this->dateFrom;
        $data['date_to'] = $this->dateTo;
        $data['inhouses'] = $this->inhouses;
        return $this->printToPDF('pdf.sales-detail-pdf', $data, app('OperationDate'), "Sales-Detail", 'P');
    }

    public function mount()
    {
        $this->dateFrom = today()->subDay()->toDateString();
        $this->dateTo = today()->toDateString();
    }

    public function render()
    {
        $this->inhouses = Inhouse::with([ 'viewInformationInvoices' => function ($query) {
            $query->whereIn('group_no', $this->selectedGroups);
        }])
        ->whereDate('operation_date', '>=', $this->dateFrom)
        ->whereDate('operation_date', '<=', $this->dateTo)
        ->where('checked_out', true)->get();

        return view('livewire.live-sales-detail-report');
    }
}
