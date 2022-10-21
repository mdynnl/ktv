<?php

namespace App\Http\Livewire;

use App\Models\Food;
use App\Models\FoodCategory;
use App\Models\FoodType;
use Livewire\Component;

class LiveFbMenuView extends Component
{
    public $categories;
    public $foodTypes;
    public $selectedCategoryId;
    public $selectedTypeId;

    protected $listeners = [
        'foodTypeCreated' => '$refresh',
        'foodTypeUpdated' => '$refresh',
        'foodTypeDeleted' => '$refresh',

        'foodCreated' => '$refresh',
        'foodUpdated' => '$refresh',
        'foodDeleted' => '$refresh',
    ];

    public function hydrate()
    {
        $this->foodTypes = FoodType::select('id', 'food_type_name', 'printer_type_id')->withCount('foods')->with('printerType:id,printer_type')->where('food_category_id', $this->selectedCategoryId)->get();
    }

    public function updatedSelectedCategoryId()
    {
        $this->foodTypes = FoodType::select('id', 'food_type_name', 'printer_type_id')->withCount('foods')->with('printerType:id,printer_type')->where('food_category_id', $this->selectedCategoryId)->get();
        if ($this->foodTypes->count() > 0) {
            $this->selectedTypeId = $this->foodTypes->first()->id;
        } else {
            $this->selectedTypeId = null;
        }
    }


    public function mount()
    {
        $this->categories = FoodCategory::all('id', 'food_category_name');
        $this->selectedCategoryId = $this->categories->first()->id;

        $this->foodTypes = FoodType::select('id', 'food_type_name', 'printer_type_id')->withCount('foods')->with('printerType:id,printer_type')->where('food_category_id', $this->selectedCategoryId)->get();
        $this->selectedTypeId = $this->foodTypes->first()->id;
    }

    public function render()
    {
        return view('livewire.live-fb-menu-view', [
            'foods' => Food::with('foodType')->select('id', 'food_type_id', 'food_name', 'price')->where('food_type_id', $this->selectedTypeId)->get()
        ]);
    }
}
