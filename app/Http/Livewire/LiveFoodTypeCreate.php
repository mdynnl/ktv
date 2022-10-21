<?php

namespace App\Http\Livewire;

use App\Models\FoodCategory;
use App\Models\FoodType;
use App\Models\PrinterType;
use Livewire\Component;

class LiveFoodTypeCreate extends Component
{
    public $foodType;
    public $foodCategories;
    public $printers;
    public $showFoodTypeCreateForm = false;

    protected $listeners = ['createFoodType'];

    protected $rules = [
        'foodType.food_category_id' => 'required|integer',
        'foodType.food_type_name' => 'required|string',
        'foodType.isFunctionMenu' => 'required|boolean',
        'foodType.isPrintable' => 'required|boolean',
        'foodType.printer_type_id' => 'nullable|integer',
        'foodType.created_user_id' => 'required|integer',
    ];

    public function create()
    {
        $this->validate();

        if (empty($this->foodType->printer_type_id)) {
            $this->foodType->printer_type_id = null;
        }

        $this->foodType->save();
        $this->emit('foodTypeCreated');
        $this->showFoodTypeCreateForm = false;
    }

    public function createFoodType()
    {
        $this->resetValidation();
        $this->reset();

        $this->foodType = new FoodType();
        $this->foodCategories = FoodCategory::all('id', 'food_category_name');
        $this->printers = PrinterType::all('id', 'printer_type');

        $this->foodType->food_category_id = 1;
        $this->foodType->printer_type_id = 1;
        $this->foodType->isPrintable = false;
        $this->foodType->isFunctionMenu = false;
        $this->foodType->created_user_id = auth()->id();

        $this->showFoodTypeCreateForm = true;
    }

    public function render()
    {
        return view('livewire.live-food-type-create');
    }
}
