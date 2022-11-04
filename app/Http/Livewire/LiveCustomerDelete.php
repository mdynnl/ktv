<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use Illuminate\Database\QueryException;
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
        try {
            $this->customer->delete();
            $this->emit('customerDeleted');
            $this->showCustomerDeleteModal = false;
        } catch (QueryException $queryException) {
            $this->showCustomerDeleteModal = false;
            $this->dispatchBrowserEvent('failure-notify', ['title' => "Customer Delete Unsuccessful", 'body' => "Cannot delete customer cause other related data exist. Please delete related data first to delete this customer."]);
        } catch (\Exception $exception) {
            dd(get_class($exception));
        }
    }

    public function deleteCustomer(Customer $customer)
    {
        $this->authorize('delete', $customer);

        $this->customer = $customer;
        $this->showCustomerDeleteModal = true;
    }

    public function render()
    {
        return view('livewire.live-customer-delete');
    }
}
