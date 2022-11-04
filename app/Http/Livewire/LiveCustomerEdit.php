<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class LiveCustomerEdit extends Component
{
    use AuthorizesRequests;

    public $customer;
    public $showCustomerEditForm = false;

    protected $listeners = ['editCustomer'];

    protected function rules()
    {
        return [
            'customer.customer_name' => 'required|string',
            'customer.phone' => 'nullable|string|min:8',
            'customer.address' => 'nullable|string',
            'customer.updated_user_id' => 'required|nullable'
        ];
    }

    public function update()
    {
        $this->validate();
        if (empty($this->customer->discount)) {
            $this->customer->discount = 0;
        }
        $this->customer->update();
        $this->emit('customerUpdated');
        $this->showCustomerEditForm = false;
    }

    public function editCustomer(Customer $customer)
    {
        $this->authorize('update', $customer);

        $this->resetValidation();
        $this->reset();

        $this->customer = $customer;
        $this->customer->updated_user_id = auth()->id();
        $this->showCustomerEditForm = true;
    }

    public function render()
    {
        return view('livewire.live-customer-edit');
    }
}
