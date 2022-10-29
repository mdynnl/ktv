<?php

namespace App\Http\Livewire;

use App\Models\CheckOutPayment;
use App\Models\CurrencyExchange;
use App\Models\PaymentType;
use App\Models\Inhouse;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LiveModalPaymentForm extends Component
{
    // Inhouse fills
    public $inhouse_id;
    public $room_no;
    public $total;
    public $payment_type_id;
    public $remark;

    public $paymentTypes;
    public $showModalPaymentForm = false;

    protected $listeners = ['makePayments'];

    protected $rules = [
          'remark' => 'nullable|string',
          'payment_type_id' => 'required|integer',
    ];

    public function saveCheckOutPayment()
    {
        $this->validate();
        DB::transaction(function () {
            $inhouse = Inhouse::find($this->inhouse_id);
            $inhouse->update([
                'payment_type_id' => $this->payment_type_id,
                'remark' => $this->remark,
                'checkout_payment_done' => true,
                'updated_user_id' => auth()->id(),
            ]);

            $inhouse->order()->update([
                'is_paid' => true
            ]);
        });

        $this->emit('checkOutPaymentsSettled');
        $this->closeModalPaymentForm();
    }

    public function closeModalPaymentForm()
    {
        $this->showModalPaymentForm = false;
        $this->reset();
    }



    public function makePayments(Inhouse $inhouse)
    {
        if ($inhouse->checkout_payment_done) {
            return;
        }
        $this->fill($inhouse);
        $this->inhouse_id = $inhouse->id;
        $this->paymentTypes = PaymentType::all('id', 'payment_type_name');

        $this->showModalPaymentForm = true;
    }

    public function render()
    {
        return view('livewire.live-modal-payment-form');
    }
}
