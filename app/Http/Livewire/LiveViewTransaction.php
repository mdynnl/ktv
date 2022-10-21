<?php

namespace App\Http\Livewire;

use App\Models\Inhouse;
use Livewire\Component;

class LiveViewTransaction extends Component
{
    public ?Inhouse $inhouse = null;
    public $showTransactionsView = false;

    protected $listeners = ['viewTransactions', 'incomeTransactionAdded' => '$refresh'];

    public function viewTransactions(Inhouse $inhouse)
    {
        $this->inhouse = $inhouse->load('incomeTransactions');

        $this->showTransactionsView = true;
    }

    public function render()
    {
        return view('livewire.live-view-transaction');
    }
}
