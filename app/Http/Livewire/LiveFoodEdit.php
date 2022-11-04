<?php

namespace App\Http\Livewire;

use App\Models\Food;
use App\Models\FoodCategory;
use App\Models\FoodType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class LiveFoodEdit extends Component
{
    use AuthorizesRequests;
    use WithFileUploads;

    public $food;
    public $foodCategories;
    public $foodTypes;
    public $selectedFoodCategory;
    public $showFoodEditForm = false;
    public $image;
    protected $listeners = ['editFood'];

    protected $rules = [
        'image' => 'nullable|image|max:512',
        'food.food_type_id' => 'required|integer',
        'food.food_name' => 'required|string',
        // 'food.food_image' => 'nullable|image|max:512',
        'food.price' => 'required|between:0,999999999.99',
        'food.updated_user_id' => 'required|integer',
    ];

    public function update()
    {
        $this->validate();

        if ($this->image) {
            if ($this->food->food_image) {
                Storage::delete($this->food->food_image);
            }
            $this->food->food_image = $this->image->store('fnb');
        }
        $this->food->update();
        $this->emit('foodUpdated');
        $this->showFoodEditForm = false;
    }

    public function editFood(Food $food)
    {
        $this->authorize('edit food and beverage');
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
