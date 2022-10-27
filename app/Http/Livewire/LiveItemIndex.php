<?php

namespace App\Http\Livewire;

use App\Models\Item;
use Livewire\Component;

class LiveItemIndex extends Component
{
    public $search = '';

    protected $listeners = [
        'itemCreated' => '$refresh',
        'itemUpdated' => '$refresh',
        'itemDeleted' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.live-item-index', [
            'items' => Item::when(strlen($this->search) >= 2 ? $this->search : false, function ($query) {
                $query->where('item_name', 'like', '%'.$this->search.'%');
            })
            ->orderBy('item_name')
            ->get(),
        ]);
    }
}
