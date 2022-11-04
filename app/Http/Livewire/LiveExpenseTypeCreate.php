<?php

namespace App\Http\Livewire;

use App\Models\ExpenseType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class LiveExpenseTypeCreate extends Component
{
    use AuthorizesRequests;

    public $expense_type_name;
    public $created_user_id;

    public $showExpenseTypeCreateForm = false;

    protected $listeners = ['createExpenseType'];

    protected $rules = [
        'expense_type_name' => 'required|string',
        'created_user_id' => 'required|integer',
    ];

    public function create()
    {
        $this->created_user_id = auth()->id();

        $validated = $this->validate();

        ExpenseType::create($validated);

        $this->emit('expenseTypeCreated');
        $this->showExpenseTypeCreateForm = false;
    }

    public function createExpenseType()
    {
        $this->authorize('create', ExpenseType::class);

        $this->resetValidation();
        $this->reset();

        $this->showExpenseTypeCreateForm = true;
    }

    public function render()
    {
        return view('livewire.live-expense-type-create');
    }
}
