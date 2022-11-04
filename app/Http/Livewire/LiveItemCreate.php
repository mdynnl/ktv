<?php

namespace App\Http\Livewire;

use App\Models\Item;
use App\Models\ItemType;
use App\Models\Store;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class LiveItemCreate extends Component
{
    use AuthorizesRequests;

    public $item;
    public $stores;
    public $showItemCreateForm = false;

    protected $listeners = ['createItem'];

    protected $rules = [
        'item.item_name' => 'required|string',
        'item.recipe_price' => 'required|numeric|between:0,999999999.99',
        'item.recipe_unit' => 'required|string',
        'item.reorder' => 'required|integer',
        'item.is_kitchen_item' => 'required|boolean',
        'item.created_user_id' => 'required|integer',
    ];

    public function create()
    {
        $this->item->created_user_id = auth()->id();

        $this->validate();

        $this->item->save();

        $this->emit('itemCreated');
        $this->showItemCreateForm = false;
    }

    public function createItem()
    {
        $this->authorize('create', Item::class);

        $this->resetValidation();
        $this->reset();

        $this->item = new Item();
        $this->item->is_kitchen_item = true;
        $this->showItemCreateForm = true;
    }
}
