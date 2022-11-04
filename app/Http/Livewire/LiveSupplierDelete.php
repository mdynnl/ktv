<?php

namespace App\Http\Livewire;

use App\Models\Supplier;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class LiveSupplierDelete extends Component
{
    use AuthorizesRequests;

    public $supplier;
    public $showSupplierDeleteModal = false;

    protected $listeners = ['deleteSupplier'];


    public function delete()
    {
        try {
            $this->supplier->delete();
            $this->emit('supplierDeleted');
            $this->showSupplierDeleteModal = false;
        } catch (QueryException $queryException) {
            $this->showRoomDeleteModal = false;
            $this->dispatchBrowserEvent('failure-notify', ['title' => "Supplier Delete Unsuccessful", 'body' => "Cannot delete supplier cause other related data exist. Please delete related data first to delete this supplier."]);
        } catch (\Exception $exception) {
            dd(get_class($exception));
        }
    }

    public function deleteSupplier(Supplier $supplier)
    {
        $this->authorize('delete', $supplier);

        $this->supplier = $supplier;
        $this->showSupplierDeleteModal = true;
    }

    public function render()
    {
        return view('livewire.live-supplier-delete');
    }
}
