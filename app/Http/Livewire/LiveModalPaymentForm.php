<?php

namespace App\Http\Livewire;

use App\Models\CheckOutPayment;
use App\Models\CurrencyExchange;
use App\Models\CheckoutPaymentType;
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
    public $checkout_payment_type_id;
    public $remark;

    public $checkoutPaymentTypes;
    public $showModalPaymentForm = false;

    protected $listeners = ['makePayments'];

    protected $rules = [
          'remark' => 'nullable|string',
          'checkout_payment_type_id' => 'required|integer',
    ];

    public function saveCheckOutPayment()
    {
        $this->validate();
        DB::transaction(function () {
            $inhouse = Inhouse::find($this->inhouse_id);
            $inhouse->update([
                'checkout_payment_type_id' => $this->checkout_payment_type_id,
                'remark' => $this->remark,
                'checkout_payment_done' => true,
                'updated_user_id' => auth()->id(),
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
        $this->checkoutPaymentTypes = CheckoutPaymentType::all('id', 'checkout_payment_type_name');

        $this->showModalPaymentForm = true;
    }

    public function render()
    {
        return view('livewire.live-modal-payment-form');
    }
}
