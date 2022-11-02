<?php

namespace App\Http\Livewire;

use App\Models\Inhouse;
use App\Models\ViewInformationInvoice;
use App\Traits\WithPrinting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

class LiveViewInvoice extends Component
{
    use WithPrinting;

    // public ?Inhouse $inhouse = null;

    // Inhouse fills
    public $inhouse_id;
    public $room_no;
    public $arrival;
    public $departure;
    public $commercial_tax;
    public $commercial_tax_amount;
    public $service_tax;
    public $service_tax_amount;
    public $checkout_payment_done;
    public $sub_total;
    public $total;

    public $payments;

    // States
    public $showViewInvoiceModal = false;

    protected $listeners = ['showInvoice'];

    public function printInvoice()
    {
        $data = [];
        $data['inhouse_id'] = $this->inhouse_id;
        $data['room_no'] = $this->room_no;
        $data['arrival'] = Carbon::parse($this->arrival)->format('Y-m-d g:i A');
        $data['departure'] = Carbon::parse($this->departure)->format('Y-m-d g:i A');
        $data['sub_total'] = $this->sub_total;
        $data['commercial_tax'] = $this->commercial_tax;
        $data['ct_amount'] = $this->commercial_tax_amount;
        $data['service_tax'] = $this->service_tax;
        $data['st_amount'] = $this->service_tax_amount;
        $data['total'] = $this->total;

        $data['data'] = $this->payments;
        return $this->printToPDF('pdf.room-invoice-pdf', $data, app('OperationDate'), "Invoice_Room_No_{$this->room_no}", 'P');
    }



    public function showInvoice(Inhouse $inhouse)
    {
        $this->fill($inhouse);
        $this->room_no = $inhouse->room->room_no;
        $this->inhouse_id = $inhouse->id;
        $this->payments = $inhouse->viewInformationInvoices;
        $this->sub_total = $this->payments->sum('amount');


        $this->showViewInvoiceModal = true;
    }

    public function hydrate()
    {
        if (isset($this->inhouse_id)) {
            $inhouse = Inhouse::find($this->inhouse_id);
            $this->payments = $inhouse->viewInformationInvoices;
        }
    }


    public function render()
    {
        return view('livewire.live-view-invoice');
    }
}
