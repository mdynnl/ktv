<?php

namespace App\Http\Livewire;

use App\Models\FoodType;
use Livewire\Component;

class LiveFoodTypeDelete extends Component
{
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
        $this->reset();

        $this->foodType = $foodType;
        $this->showFoodTypeDeleteModal = true;
    }

    public function render()
    {
        return view('livewire.live-food-type-delete');
    }
}
