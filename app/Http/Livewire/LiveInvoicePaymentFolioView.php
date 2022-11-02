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

class LiveInvoicePaymentFolioView extends Component
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
    public $showInvoicePaymentFolioView = false;
    public $isDirty = false;

    protected $listeners = ['viewInvoicePaymentFolio', 'checkOutPaymentsSettled'];

    protected $rules = [
        'commercial_tax' => 'nullable|between:0,999999999.99',
        'service_tax' => 'nullable|between:0,999999999.99',
    ];

    public function checkOutPaymentsSettled()
    {
        $inhouse = Inhouse::find($this->inhouse_id);
        $this->fill($inhouse);
    }

    public function saveChanges()
    {
        if ($this->isDirty) {
            $inhouse = Inhouse::find($this->inhouse_id);
            $inhouse->update([
                'sub_total' => $this->sub_total,
                'commercial_tax' => $this->commercial_tax,
                'commercial_tax_amount' => $this->commercial_tax_amount,
                'service_tax' => $this->service_tax,
                'service_tax_amount' => $this->service_tax_amount,
                'total' => $this->total,
            ]);
            $inhouse->refresh();
            $this->fill($inhouse);
            $this->isDirty = false;
        }
    }

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

    public function updatedShowInvoicePaymentFolioView()
    {
        $this->reset();
    }

    public function updated()
    {
        $this->calculateAmounts();
        $this->isDirty = true;
    }

    public function viewInvoicePaymentFolio(Inhouse $inhouse)
    {
        // $this->inhouse = $inhouse;
        $this->fill($inhouse);
        $this->room_no = $inhouse->room->room_no;
        $this->inhouse_id = $inhouse->id;
        $this->payments = $inhouse->viewInformationInvoices;
        $this->sub_total = $this->payments->sum('amount');
        $this->calculateAmounts();
        $this->initialInhouseUpdate();


        $this->showInvoicePaymentFolioView = true;
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
        return view('livewire.live-invoice-payment-folio-view');
    }

    protected function calculateAmounts()
    {
        $this->commercial_tax = empty($this->commercial_tax) ? 0 : $this->commercial_tax;
        $this->service_tax = empty($this->service_tax) ? 0 : $this->service_tax;
        $this->commercial_tax_amount = ($this->sub_total * $this->commercial_tax) / 100;
        $this->service_tax_amount = ($this->sub_total * $this->service_tax) / 100;
        $this->total = $this->sub_total + $this->commercial_tax_amount + $this->service_tax_amount;
    }

    protected function initialInhouseUpdate()
    {
        $inhouse = Inhouse::find($this->inhouse_id);
        $inhouse->update([
            'sub_total' => $this->sub_total,
            'commercial_tax_amount' => $this->commercial_tax_amount,
            'service_tax_amount' => $this->service_tax_amount,
            'total' => $this->total,
        ]);

        $inhouse->refresh();
        $this->fill($inhouse);
    }
}
