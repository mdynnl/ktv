<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class LiveCustomerDelete extends Component
{
    use AuthorizesRequests;

    public $customer;
    public $showCustomerDeleteModal = false;

    protected $listeners = ['deleteCustomer'];

    public function delete()
    {
        $this->customer->delete();
        $this->emit('customerDeleted');
        $this->showCustomerDeleteModal = false;
    }

    public function deleteCustomer(Customer $customer)
    {
        $this->customer = $customer;
        $this->showCustomerDeleteModal = true;
    }

    public function render()
    {
        return view('livewire.live-customer-delete');
    }
}
