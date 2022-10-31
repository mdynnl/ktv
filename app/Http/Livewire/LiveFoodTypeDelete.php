<?php

namespace App\Http\Livewire;

use App\Models\FoodType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class LiveFoodTypeDelete extends Component
{
    use AuthorizesRequests;

    public $foodType;
    public $showFoodTypeDeleteModal = false;

    protected $listeners = ['deleteFoodType'];

    public function delete()
    {
        $this->foodType->delete();
        $this->emit('foodTypeDeleted');
        $this->showFoodTypeDeleteModal = false;
    }

    public function deleteFoodType(FoodType $foodType)
    {
        $this->authorize('delete food and beverage');
        $this->reset();

        $this->foodType = $foodType;
        $this->showFoodTypeDeleteModal = true;
    }

    public function render()
    {
        return view('livewire.live-food-type-delete');
    }
}
