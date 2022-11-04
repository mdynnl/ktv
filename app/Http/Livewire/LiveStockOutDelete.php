<?php

namespace App\Http\Livewire;

use App\Models\Item;
use App\Models\StockOut;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LiveStockOutDelete extends Component
{
    use AuthorizesRequests;

    public $stockout;
    public $showStockoutDeleteModal = false;

    protected $listeners = ['deleteStockout'];

    public function delete()
    {
        try {
            DB::transaction(function () {
                Item::find($this->stockout->item_id)->increment('current_qty', $this->stockout->qty);
                $this->stockout->delete();
                $this->emit('stockoutDeleted');
                $this->showStockoutDeleteModal = false;
            });
        } catch (QueryException $queryException) {
            $this->showStockoutDeleteModal = false;
            $this->dispatchBrowserEvent('failure-notify', ['title' => "Stockout Record Delete Unsuccessful", 'body' => "Cannot delete stockout record cause other related data exist. Please delete related data first to delete this record."]);
        } catch (\Exception $exception) {
            dd(get_class($exception));
        }
    }

    public function deleteStockout(StockOut $stockout)
    {
        $this->authorize('delete', $stockout);

        $this->stockout = $stockout;
        $this->showStockoutDeleteModal = true;
    }

    public function render()
    {
        return view('livewire.live-stock-out-delete');
    }
}
