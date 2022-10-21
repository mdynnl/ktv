<?php

namespace App\Http\Livewire;

use App\Models\FoodCategory;
use App\Models\FoodType;
use App\Models\PrinterType;
use Livewire\Component;

class LiveFoodTypeEdit extends Component
{
    public $foodType;
    public $foodCategories;
    public $printers;
    public $showFoodTypeEditForm = false;

    protected $listeners = ['editFoodType'];

    protected $rules = [
        'foodType.food_category_id' => 'required|integer',
        'foodType.food_type_name' => 'required|string',
        'foodType.isFunctionMenu' => 'required|boolean',
        'foodType.isPrintable' => 'required|boolean',
        'foodType.printer_type_id' => 'nullable|integer',
        'foodType.updated_user_id' => 'required|integer',
    ];

    public function update()
    {
        $this->validate();

        if (empty($this->foodType->printer_type_id)) {
            $this->foodType->printer_type_id = null;
        }

        $this->foodType->update();
        $this->emit('foodTypeUpdated');
        $this->showFoodTypeEditForm = false;
    }

    public function editFoodType(FoodType $foodType)
    {
        $this->resetValidation();
        $this->reset();

        $this->foodType = $foodType;
        $this->foodType->updated_user_id = auth()->id();

        $this->foodCategories = FoodCategory::all('id', 'food_category_name');
        $this->printers = PrinterType::all('id', 'printer_type');

        $this->showFoodTypeEditForm = true;
    }

    public function render()
    {
        return view('livewire.live-food-type-edit');
    }
}
