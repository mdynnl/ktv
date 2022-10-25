<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\Customers;
use Livewire\Component;

class LiveCustomerView extends Component
{
    public $search = '';

    protected $listeners = [
        'customerCreated' => '$refresh',
        'customerUpdated' => '$refresh',
        'customerDeleted' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.live-customer-view', [
            'customers' => Customer::when(strlen($this->search) >= 2 ? $this->search : false, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('customer_name', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('customer_name')
            ->get()
        ]);
    }
}
