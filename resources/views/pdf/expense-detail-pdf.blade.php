<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">

    <title>Expense Detail</title>

    <link rel="stylesheet" href="{{ asset('css/mpdf.css') }}">

</head>

<body class="text-gray-700" style="background: white">
    <x-header-mpdf appName="{{ config('app.name') }}" appAddress="{{ config('app.address') }}" />

    <div class="text-center mt-8">
        <p>Expense Detail</p>
    </div>

    <div class="mb-5">
        <div style="float: left; width: 40%;" class="text-xs">
            <div>
                Date From: {{ $data['fromDate'] }}
            </div>
            <div>
                Date To: {{ $data['toDate'] }}
            </div>
        </div>
        <div style="float: right; width: 50%;" class="text-xs">
        </div>
        <div style="float: right; width: 50%;" class="text-right text-xs"></div>
        <div style="clear: both; margin: 0pt; padding: 0pt; "></div>
    </div>

    @foreach ($data['expenseGroup'] as $key => $expenses)
        <div style="margin-bottom: 20px">
            <table border="1" style="width: 100%; border-collapse: collapse">
                <thead>
                    <tr style="border: none">
                        <x-th-mpdf-dark-text style="border: none" colspan="3">
                            <span>Expense Type: {{ $key }}</span>
                        </x-th-mpdf-dark-text>
                    </tr>
                    <x-tr-mpdf-bg-primary>
                        <x-th-mpdf width="80px" align="center">Sr. No</x-th-mpdf>
                        <x-th-mpdf width="80px" align="center">Reg No</x-th-mpdf>
                        <x-th-mpdf width="150px">Date</x-th-mpdf>
                        <x-th-mpdf width="150px">Expense Type</x-th-mpdf>
                        <x-th-mpdf>Description</x-th-mpdf>
                        <x-th-mpdf width="80px" align="center">Price</x-th-mpdf>
                        <x-th-mpdf width="80px" align="center">Qty</x-th-mpdf>
                        <x-th-mpdf width="80px" align="center">Amount</x-th-mpdf>
                    </x-tr-mpdf-bg-primary>
                </thead>
                <tbody class="bg-white text-xs">
                    @foreach ($expenses as $index => $expense)
                        <tr>
                            <x-td-mpdf align="center">{{ $index + 1 }}</x-td-mpdf>
                            <x-td-mpdf align="center">{{ $expense->id }}</x-td-mpdf>
                            <x-td-mpdf align="left">{{ $expense->expense_date }}</x-td-mpdf>
                            <x-td-mpdf align="left">{{ $expense->expenseType->expense_type_name }}</x-td-mpdf>
                            <x-td-mpdf align="left">{{ $expense->description }}</x-td-mpdf>
                            <x-td-mpdf align="right">{{ number_format($expense->price, 0, '.', ',') }}</x-td-mpdf>
                            <x-td-mpdf align="center">{{ $expense->qty }}</x-td-mpdf>
                            <x-td-mpdf align="right">{{ number_format($expense->price * $expense->qty, 0, '.', ',') }}
                            </x-td-mpdf>
                        </tr>
                    @endforeach
                    <tr>
                        <x-td-mpdf colspan="7" align="center"><span>Total</span>
                        </x-td-mpdf>
                        <x-td-mpdf colspan="1" align="right">
                            <span>
                                {{ number_format($expenses->sum('amount'), 0, '.', ',') }}
                            </span>
                        </x-td-mpdf>
                    </tr>
                </tbody>
            </table>
        </div>
    @endforeach

    <x-mpdf-page-footer />
</body>

</html>
