<?php

namespace App\Http\Livewire;

use App\Models\Expense;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LiveExpenseDelete extends Component
{
    use AuthorizesRequests;

    public $expense;
    public $showExpenseDeleteModal = false;

    protected $listeners = ['deleteExpense'];

    public function delete()
    {
        try {
            DB::transaction(function () {
                $this->expense->delete();
                $this->emit('expenseDeleted');
                $this->showExpenseDeleteModal = false;
            });
        } catch (QueryException $queryException) {
            $this->showExpenseDeleteModal = false;
            $this->dispatchBrowserEvent('failure-notify', ['title' => "Expense Delete Unsuccessful", 'body' => "Cannot delete expense cause other related data exist. Please delete related data first to delete this expense."]);
        } catch (\Exception $exception) {
            dd(get_class($exception));
        }
    }

    public function deleteExpense(Expense $expense)
    {
        $this->authorize('delete', $expense);

        $this->expense = $expense;
        $this->showExpenseDeleteModal = true;
    }

    public function render()
    {
        return view('livewire.live-expense-delete');
    }
}
