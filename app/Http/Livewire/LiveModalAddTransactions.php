<?php

namespace App\Http\Livewire;

use App\Models\Currency;
use App\Models\IncomeTransaction;
use App\Models\Inhouse;
use App\Models\Transaction;
use Livewire\Component;

class LiveModalAddTransactions extends Component
{
    public ?Inhouse $inhouse = null;
    public ?IncomeTransaction $incomeTransaction = null;
    public $transactions;
    public $currencies;

    public $showAddTransactionsForm = false;

    protected $listeners = ['addTransactions'];

    protected $rules = [
        'incomeTransaction.operation_date' => 'required|date',
        'incomeTransaction.inhouse_id' => 'required|integer',
        'incomeTransaction.transaction_id' => 'required|integer',
        // 'incomeTransaction.currency_code' => 'required|string',
        'incomeTransaction.amount' => 'required|numeric|between:0,999999999.99',
        // 'incomeTransaction.payment' => 'required|string',
        'incomeTransaction.remark' => 'nullable|string',
        'incomeTransaction.created_user_id' => 'required|integer',
    ];

    public function saveIncomeTransaction()
    {
        $this->incomeTransaction->operation_date = app('OperationDate');

        $this->validate();

        $this->incomeTransaction->save();

        $this->emit('incomeTransactionAdded');
        $this->closeAddTransactionForm();
    }

    public function addTransactions(Inhouse $inhouse)
    {
        $this->inhouse = $inhouse;
        // $this->currencies = Currency::all('currency_code');

        $this->transactions = Transaction::all();

        $this->incomeTransaction = new IncomeTransaction();
        $this->incomeTransaction->inhouse_id = $inhouse->id;
        // $this->incomeTransaction->payment = 'Cash';
        $this->incomeTransaction->created_user_id = auth()->id();
        // $this->incomeTransaction->currency_code = 'MMK';

        $this->showAddTransactionsForm = true;
    }

    public function closeAddTransactionForm()
    {
        $this->showAddTransactionsForm = false;
        $this->resetValidation();
        $this->reset();
    }

    public function render()
    {
        return view('livewire.live-modal-add-transactions');
    }
}
