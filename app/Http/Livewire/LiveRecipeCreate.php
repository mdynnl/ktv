<?php

namespace App\Http\Livewire;

use App\Models\Food;
use App\Models\Item;
use App\Models\Recipe;
use App\Models\RecipeView;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class LiveRecipeCreate extends Component
{
    use AuthorizesRequests;
    public $search = '';
    public $selectedFoodId;
    public $food;
    public $foods;
    public $selectedFoodRecipes;


    public $showRecipeCreateModal = false;
    public $showQtyEditModal = false;
    public $showRecipeItemDeleteConfirmationModal = false;
    public $showLoadRecipeModal = false;


    public $selectedItems = [];
    public $selectedLoadedRecipeItems = [];
    public $recipeItems = [];

    public $editingIndex;
    public $editingRecipeItem;
    public $editingRecipeQty;
    public $isDirty = false;
    public $hasRecipe;
    public $recipes;

    protected $listeners = ['createRecipe'];

    protected $rules = [
        'editingRecipeQty' => 'required|numeric|between:0,1000',
    ];

    protected $messages = [
        'editingRecipeQty.required' => 'Qty cannot be empty.',
        'editingRecipeQty.numeric' => 'Qty must be numeric.',
    ];

    public function create()
    {
        if ($this->hasRecipe) {
            $existingRecipeItems = array_filter($this->recipeItems, function ($item) {
                return $item['recipe_id'] != null;
            });
            $newRecipeItems = array_filter($this->recipeItems, function ($item) {
                return $item['recipe_id'] == null;
            });

            foreach ($existingRecipeItems as $item) {
                Recipe::find($item['recipe_id'])->update(['qty' => $item['qty']]);
            }

            foreach ($newRecipeItems as $item) {
                Recipe::create([
                    'food_id' => $this->food->id,
                    'item_id' => $item['item_id'],
                    'qty' => $item['qty']
                ]);
            }
        } else {
            foreach ($this->recipeItems as $item) {
                Recipe::create([
                    'food_id' => $this->food->id,
                    'item_id' => $item['item_id'],
                    'qty' => $item['qty']
                ]);
            }
        }

        $this->emit('recipeCreated');
        // $this->showRecipeCreateModal = false;
        $this->isDirty = false;
    }

    public function loadRecipe()
    {
        $items = $this->selectedFoodRecipes->whereIn('id', $this->selectedLoadedRecipeItems);

        foreach ($items as $item) {
            $itemExist = false;
            if (count($this->recipeItems) > 0) {
                for ($i=0; $i < count($this->recipeItems); $i++) {
                    if (!isset($this->recipeItems[$i]['recipe_id'])) {
                        if ($this->recipeItems[$i]['item_id'] == $item->item_id) {
                            $itemExist = true;

                            $this->recipeItems[$i]['qty'] = $item->qty;
                            $this->recipeItems[$i]['amount'] = $this->recipeItems[$i]['qty'] * $this->recipeItems[$i]['recipe_price'];
                        }
                    }
                }
            }

            if (!$itemExist) {
                array_push($this->recipeItems, [
                    'recipe_id' => null,
                    'item_id' => $item->item_id,
                    'item_name' => $item->item->item_name,
                    'recipe_unit' => $item->item->recipe_unit,
                    'recipe_price' => $item->item->recipe_price,
                    'qty' => $item->qty,
                    'amount' => $item->item->recipe_price * $item->qty,
                ]);
            }
        }

        $this->showLoadRecipeModal = false;
        $this->isDirty = true;
    }

    public function showLoadRecipeModal()
    {
        $this->reset(['selectedFoodId', 'foods', 'selectedLoadedRecipeItems']);
        $this->showLoadRecipeModal = true;
    }

    public function updateQty()
    {
        $this->validate();
        $this->recipeItems[$this->editingIndex]['qty'] = $this->editingRecipeQty;
        $this->recipeItems[$this->editingIndex]['amount'] = $this->recipeItems[$this->editingIndex]['qty'] * $this->recipeItems[$this->editingIndex]['recipe_price'];
        $this->showQtyEditModal = false;
        $this->reset(['editingIndex', 'editingRecipeItem', 'editingRecipeQty']);
        $this->isDirty = true;
    }

    public function showChangeQtyInput($index)
    {
        $this->resetValidation();
        $this->editingIndex = $index;
        $this->editingRecipeItem = $this->recipeItems[$index];
        $this->editingRecipeQty = $this->editingRecipeItem['qty'];
        $this->showQtyEditModal = true;
    }

    public function deleteDbRecipeItem()
    {
        $this->showRecipeItemDeleteConfirmationModal = false;
        Recipe::find($this->recipeItems[$this->editingIndex]['recipe_id'])->delete();
        unset($this->recipeItems[$this->editingIndex]);
        $this->recipeItems = array_values($this->recipeItems);
    }

    public function deleteRecipeItem($index)
    {
        if ($this->recipeItems[$index]['recipe_id']) {
            $this->editingIndex = $index;
            $this->editingRecipeItem = $this->recipeItems[$index];
            $this->showRecipeItemDeleteConfirmationModal = true;
        } else {
            unset($this->recipeItems[$index]);
            $this->recipeItems = array_values($this->recipeItems);

            $this->isDirty = count($this->recipeItems) < 1 ? false : true;
        }
    }

    public function addToRecipeItems()
    {
        $items = Item::whereIn('id', $this->selectedItems)->get();

        $this->selectedItems = [];

        foreach ($items as $item) {
            $itemExist = false;
            if (count($this->recipeItems) > 0) {
                for ($i=0; $i < count($this->recipeItems); $i++) {
                    if (!isset($this->recipeItems[$i]['recipe_id'])) {
                        if ($this->recipeItems[$i]['item_id'] == $item->id) {
                            $itemExist = true;

                            $this->recipeItems[$i]['qty']+= 1;
                            $this->recipeItems[$i]['amount'] = $this->recipeItems[$i]['qty'] * $this->recipeItems[$i]['recipe_price'];
                        }
                    }
                }
            }

            if (!$itemExist) {
                array_push($this->recipeItems, [
                    'recipe_id' => null,
                    'item_id' => $item->id,
                    'item_name' => $item->item_name,
                    'recipe_unit' => $item->recipe_unit,
                    'recipe_price' => $item->recipe_price,
                    'qty' => 1,
                    'amount' => $item->recipe_price,
                ]);
            }
        }

        $this->isDirty = true;
    }

    public function createRecipe(Food $food, $hasRecipe = false)
    {
        $this->authorize('add food and beverage');
        $this->resetValidation();
        $this->reset();

        $this->food = $food;
        $this->hasRecipe = $hasRecipe;

        if ($hasRecipe) {
            $this->recipes = $this->food->recipes()->with('item')->get();
            foreach ($this->recipes as $recipe) {
                array_push($this->recipeItems, [
                    'recipe_id' => $recipe->id,
                    'item_id' => $recipe->item_id,
                    'item_name' => $recipe->item->item_name,
                    'recipe_unit' => $recipe->item->recipe_unit,
                    'recipe_price' => $recipe->item->recipe_price,
                    'qty' => $recipe->qty,
                    'amount' => $recipe->item->recipe_price * $recipe->qty,
                ]);
            }
        }
        $this->showRecipeCreateModal = true;
    }

    public function render()
    {
        if ($this->showLoadRecipeModal) {
            $this->foods = Food::has('recipes')->with('recipes')->get();
            $this->selectedFoodRecipes = Food::with('recipes.item')->when($this->selectedFoodId, function ($query) {
                $query->where('id', $this->selectedFoodId);
            })->first()->recipes;
        }

        return view('livewire.live-recipe-create', [
            'items' => Item::when(strlen($this->search) > 1 ? $this->search : false, function ($query) {
                $query->where('item_name', 'like', '%'.$this->search.'%');
            })
            ->where('is_kitchen_item', true)
            ->orderBy('item_name')
            ->get(),
        ]);
    }
}
