<?php

namespace App\Http\Livewire;

use App\Models\Food;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class LiveFoodDelete extends Component
{
    use AuthorizesRequests;
    public $food;
    public $showFoodDeleteModal = false;

    protected $listeners = ['deleteFood'];

    public function delete()
    {
        $this->food->delete();
        $this->emit('foodDeleted');
        $this->showFoodDeleteModal = false;
    }

    public function deleteFood(Food $food)
    {
        $this->authorize('delete food and beverage');
        $this->reset();

        $this->food = $food;
        $this->showFoodDeleteModal = true;
    }
    public function render()
    {
        return view('livewire.live-food-delete');
    }
}
