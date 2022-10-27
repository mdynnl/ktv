<?php

namespace App\Http\Livewire;

use App\Models\Item;
use App\Models\PurchaseDetail;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LivePurchaseDetailDelete extends Component
{
    public $purchaseDetail;
    public $showPurchaseDetailDeleteModal = false;

    protected $listeners = ['deletePurchaseDetail'];

    public function delete()
    {
        DB::transaction(function () {
            Item::find($this->purchaseDetail->item_id)
                ->decrement('current_qty', $this->purchaseDetail->recipe_qty);

            $this->purchaseDetail->delete();
            $this->emit('purchaseDetailDeleted');
            $this->showPurchaseDetailDeleteModal = false;
        });
    }

    public function deletePurchaseDetail(PurchaseDetail $purchaseDetail)
    {
        $this->purchaseDetail = $purchaseDetail;

        $this->showPurchaseDetailDeleteModal = true;
    }

    public function render()
    {
        return view('livewire.live-purchase-detail-delete');
    }
}
