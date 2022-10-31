<?php

namespace App\Http\Livewire;

use App\Models\Food;
use App\Models\FoodCategory;
use App\Models\FoodType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;

class LiveFoodCreate extends Component
{
    use AuthorizesRequests;
    use WithFileUploads;

    public $food;
    public $image;
    public $foodCategories;
    public $foodTypes;
    public $selectedFoodCategory;
    public $showFoodCreateForm = false;

    protected $listeners = ['createFood'];

    protected $rules = [
        'image' => 'nullable|image|max:512',
        'food.food_type_id' => 'required|integer',
        'food.food_name' => 'required|string',
        'food.price' => 'required|numeric|between:0,999999999.99',
        'food.created_user_id' => 'required|integer',
    ];

    public function create()
    {
        $this->validate();
        if ($this->image) {
            $this->food->food_image = $this->image->store('fnb');
        }
        $this->food->save();
        $this->emit('foodCreated');
        $this->showFoodCreateForm = false;
    }

    public function createFood(FoodType $foodType)
    {
        $this->authorize('add food and beverage');
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
