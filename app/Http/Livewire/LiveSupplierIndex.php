<?php

namespace App\Http\Livewire;

use App\Models\Supplier;
use Livewire\Component;

class LiveSupplierIndex extends Component
{
    public $search = '';

    protected $listeners = [
        'supplierCreated' => '$refresh',
        'supplierUpdated' => '$refresh',
        'supplierDeleted' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.live-supplier-index', [
            'suppliers' => Supplier::when(strlen($this->search) > 1 ? $this->search : false, function ($query) {
                $query->where('supplier_name', 'like', '%'.$this->search.'%')
                ->orWhere('contact_person', 'like', '%'.$this->search.'%');
            })
            ->orderBy('supplier_name')
            ->get()
        ]);
    }
}
