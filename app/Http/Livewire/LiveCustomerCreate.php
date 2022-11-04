<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class LiveCustomerCreate extends Component
{
    use AuthorizesRequests;

    public $customer;
    public $showCustomerCreateForm = false;

    protected $listeners = ['createCustomer'];

    protected $rules = [
        'customer.customer_name' => 'required|string',
        // 'customer.discount' => 'nullable|between:0,999999999.99',
        'customer.phone' => 'nullable|string|min:8',
        'customer.address' => 'nullable|string',
        'customer.created_user_id' => 'required|nullable'
    ];

    public function create()
    {
        $this->validate();
        if (empty($this->customer->discount)) {
            $this->customer->discount = 0;
        }
        $this->customer->save();
        $this->emit('customerCreated');
        $this->showCustomerCreateForm = false;
    }

    public function createCustomer()
    {
        $this->authorize('create', Customer::class);

        $this->resetValidation();
        $this->reset();

        $this->customer = new Customer();
        $this->customer->created_user_id = auth()->id();

        $this->showCustomerCreateForm = true;
    }
    public function render()
    {
        return view('livewire.live-customer-create');
    }
}
