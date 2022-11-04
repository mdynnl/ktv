<?php

namespace App\Http\Livewire;

use App\Models\Item;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class LiveItemEdit extends Component
{
    use AuthorizesRequests;

    public $item;
    public $showItemEditForm = false;

    protected $listeners = ['editItem'];

    protected $rules = [
        'item.item_name' => 'required|string',
        'item.recipe_price' => 'required|between:0,999999999.99',
        'item.recipe_unit' => 'required|string',
        'item.reorder' => 'required|integer',
        'item.is_kitchen_item' => 'required|boolean',
        'item.updated_user_id' => 'required|integer',
    ];

    public function update()
    {
        $this->item->updated_user_id = auth()->id();

        $this->validate();

        $this->item->update();

        $this->emit('itemUpdated');
        $this->showItemEditForm = false;
    }

    public function editItem(Item $item)
    {
        $this->authorize('update', $item);

        $this->resetValidation();
        $this->reset();

        $this->item = $item;

        $this->showItemEditForm = true;
    }
}
