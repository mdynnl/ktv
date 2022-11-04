<?php

namespace App\Http\Livewire;

use App\Models\Purchase;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class LivePurchaseDelete extends Component
{
    use AuthorizesRequests;

    public $purchase;
    public $showPurchaseDeleteModal = false;

    protected $listeners = ['deletePurchase'];

    public function delete()
    {
        try {
            $this->purchase->delete();
            $this->emit('purchaseDeleted');
            $this->showPurchaseDeleteModal = false;
        } catch (QueryException $queryException) {
            $this->showPurchaseDeleteModal = false;
            $this->dispatchBrowserEvent('failure-notify', ['title' => "Purchase Delete Unsuccessful", 'body' => "Cannot delete purchase cause other related data exist. Please delete related data first to delete this purchase."]);
        } catch (\Exception $exception) {
            dd(get_class($exception));
        }
    }

    public function deletePurchase(Purchase $purchase)
    {
        $this->authorize('delete', $purchase);

        $this->purchase = $purchase;
        $this->showPurchaseDeleteModal = true;
    }
    public function render()
    {
        return view('livewire.live-purchase-delete');
    }
}
