<?php

namespace App\Http\Livewire;

use App\Models\Food;
use App\Models\FoodCategory;
use App\Models\FoodType;
use Livewire\Component;

class LiveFoodCreate extends Component
{
    public $food;
    public $foodCategories;
    public $foodTypes;
    public $selectedFoodCategory;
    public $showFoodCreateForm = false;

    protected $listeners = ['createFood'];

    protected $rules = [
        'food.food_type_id' => 'required|integer',
        'food.food_name' => 'required|string',
        'food.price' => 'required|between:0,999999999.99',
        'food.created_user_id' => 'required|integer',
    ];

    public function create()
    {
        $this->validate();
        $this->food->save();
        $this->emit('foodCreated');
        $this->showFoodCreateForm = false;
    }

    public function createFood(FoodType $foodType)
    {
        $this->resetValidation();
        $this->reset();

        $this->food = new Food();
        $this->food->food_type_id = $foodType->id;
        $this->food->created_user_id = auth()->id();

        $this->selectedFoodCategory = $foodType->foodCategory->id;

        $this->foodCategories = FoodCategory::all('id', 'food_category_name');

        $this->showFoodCreateForm = true;
    }

    public function render()
    {
        $this->foodTypes = FoodType::select('id', 'food_type_name')->where('food_category_id', $this->selectedFoodCategory)->get();
        return view('livewire.live-food-create');
    }
}