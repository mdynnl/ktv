<?php

namespace App\Http\Livewire;

use App\Models\FoodCategory;
use App\Models\FoodType;
use App\Models\PrinterType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class LiveFoodTypeEdit extends Component
{
    use AuthorizesRequests;

    public $foodType;
    public $foodCategories;
    public $printers;
    public $showFoodTypeEditForm = false;

    protected $listeners = ['editFoodType'];

    protected $rules = [
        'foodType.food_category_id' => 'required|integer',
        'foodType.food_type_name' => 'required|string',
        'foodType.updated_user_id' => 'required|integer',
    ];

    public function update()
    {
        $this->validate();

        $this->foodType->update();
        $this->emit('foodTypeUpdated');
        $this->showFoodTypeEditForm = false;
    }

    public function editFoodType(FoodType $foodType)
    {
        $this->authorize('edit food and beverage');
        $this->resetValidation();
        $this->reset();

        $this->foodType = $foodType;
        $this->foodType->updated_user_id = auth()->id();

        $this->foodCategories = FoodCategory::all('id', 'food_category_name');

        $this->showFoodTypeEditForm = true;
    }

    public function render()
    {
        return view('livewire.live-food-type-edit');
    }
}
