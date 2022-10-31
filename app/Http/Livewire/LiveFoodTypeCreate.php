<?php

namespace App\Http\Livewire;

use App\Models\FoodCategory;
use App\Models\FoodType;
use App\Models\PrinterType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class LiveFoodTypeCreate extends Component
{
    use AuthorizesRequests;

    public $foodType;
    public $foodCategories;
    public $showFoodTypeCreateForm = false;

    protected $listeners = ['createFoodType'];

    protected $rules = [
        'foodType.food_category_id' => 'required|integer',
        'foodType.food_type_name' => 'required|string',
        'foodType.created_user_id' => 'required|integer',
    ];

    public function create()
    {
        $this->validate();

        $this->foodType->save();
        $this->emit('foodTypeCreated');
        $this->showFoodTypeCreateForm = false;
    }

    public function createFoodType()
    {
        $this->authorize('add food and beverage');
        $this->resetValidation();
        $this->reset();

        $this->foodType = new FoodType();
        $this->foodCategories = FoodCategory::all('id', 'food_category_name');

        $this->foodType->food_category_id = 1;
        $this->foodType->created_user_id = auth()->id();

        $this->showFoodTypeCreateForm = true;
    }

    public function render()
    {
        return view('livewire.live-food-type-create');
    }
}
