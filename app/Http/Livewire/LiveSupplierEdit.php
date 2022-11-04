<?php

namespace App\Http\Livewire;

use App\Models\Supplier;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class LiveSupplierEdit extends Component
{
    use AuthorizesRequests;

    public $supplier;

    public $showSupplierEditForm = false;

    protected $listeners = ['editSupplier'];

    protected function rules()
    {
        return [
            'supplier.supplier_name' => 'required|string',
            'supplier.contact_person' => 'nullable|string',
            'supplier.phone' => 'nullable|string',
            'supplier.address' => 'nullable|string',
            'supplier.email' => 'nullable|email|unique:suppliers,email,' . $this->supplier->id,
            'supplier.updated_user_id' => 'nullable|integer',
        ];
    }

    public function update()
    {
        $this->supplier->updated_user_id = auth()->id();

        $this->validate();

        $this->supplier->update();
        $this->emit('supplierUpdated');
        $this->showSupplierEditForm = false;
    }

    public function editSupplier(Supplier $supplier)
    {
        $this->authorize('update', $supplier);

        $this->resetValidation();
        $this->reset();

        $this->supplier = $supplier;

        $this->showSupplierEditForm = true;
    }

    public function render()
    {
        return view('livewire.live-supplier-edit');
    }
}
