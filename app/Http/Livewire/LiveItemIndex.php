<?php

namespace App\Http\Livewire;

use App\Models\Item;
use App\Traits\WithPrinting;
use Livewire\Component;

class LiveItemIndex extends Component
{
    use WithPrinting;

    public $search = '';
    public $items;
    public $reorderOnly = false;

    protected $listeners = [
        'itemCreated' => '$refresh',
        'itemUpdated' => '$refresh',
        'itemDeleted' => '$refresh',
    ];


    public function print()
    {
        $date = now()->format('Y-m-d');
        $data = [
            'list_type' => $this->reorderOnly ? 'Reorder Only' : 'All Items',
            'data' => $this->items,
        ];

        return $this->printToPDF('pdf.items-list-pdf', $data, $date, 'Items-List', 'P');
    }

    public function render()
    {
        $this->items =  Item::when(strlen($this->search) >= 2 ? $this->search : false, function ($query) {
            $query->where('item_name', 'like', '%'.$this->search.'%');
        })
        ->when($this->reorderOnly, function ($query) {
            $query->whereColumn('current_qty', '<=', 'reorder');
        })
        ->orderBy('item_name')
        ->get();
        return view('livewire.live-item-index');
    }
}
