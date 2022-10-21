<?php

namespace App\Http\Livewire;

use App\Models\Food;
use App\Models\FoodCategory;
use App\Models\FoodType;
use Livewire\Component;

class LiveFoodEdit extends Component
{
    public $food;
    public $foodCategories;
    public $foodTypes;
    public $selectedFoodCategory;
    public $showFoodEditForm = false;
    protected $listeners = ['editFood'];

    protected $rules = [
        'food.food_type_id' => 'required|integer',
        'food.food_name' => 'required|string',
        'food.price' => 'required|between:0,999999999.99',
        'food.updated_user_id' => 'required|integer',
    ];

    public function update()
    {
        $this->validate();
        $this->food->update();
        $this->emit('foodUpdated');
        $this->showFoodEditForm = false;
    }

    public function editFood(Food $food)
    {
        $this->resetValidation();
        $this->reset();

        $this->food = $food;
        $this->food->updated_user_id = auth()->id();
        $this->foodCategories = FoodCategory::all('id', 'food_category_name');

        $this->selectedFoodCategory = $food->foodType->foodCategory->id;

        $this->showFoodEditForm = true;
    }

    public function render()
    {
        $this->foodTypes = FoodType::select('id', 'food_type_name')->where('food_category_id', $this->selectedFoodCategory)->get();
        return view('livewire.live-food-edit');
    }
}
