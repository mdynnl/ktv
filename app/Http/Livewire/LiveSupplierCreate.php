<?php

namespace App\Http\Livewire;

use App\Models\Supplier;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class LiveSupplierCreate extends Component
{
    use AuthorizesRequests;

    public $supplier;

    public $showSupplierCreateForm = false;

    protected $listeners = ['createSupplier'];

    protected $rules = [
        'supplier.supplier_name' => 'required|string',
        'supplier.contact_person' => 'nullable|string',
        'supplier.phone' => 'nullable|string',
        'supplier.address' => 'nullable|string',
        'supplier.email' => 'nullable|email|unique:suppliers,email',
        'supplier.created_user_id' => 'nullable|integer',
    ];


    public function create()
    {
        $this->supplier->created_user_id = auth()->id();

        $this->validate();

        $this->supplier->save();

        $this->emit('supplierCreated');
        $this->showSupplierCreateForm = false;
    }

    public function createSupplier()
    {
        $this->authorize('create', Supplier::class);

        $this->resetValidation();
        $this->reset();

        $this->supplier = new Supplier();

        $this->showSupplierCreateForm = true;
    }
    public function render()
    {
        return view('livewire.live-supplier-create');
    }
}
