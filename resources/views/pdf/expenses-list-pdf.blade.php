<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">

    <title>Expense List</title>

    <link rel="stylesheet" href="{{ asset('css/mpdf.css') }}">

</head>

<body class="text-gray-700" style="background: white">
    <x-header-mpdf appName="{{ config('app.name') }}" appAddress="{{ config('app.address') }}" />

    <div class="text-center mt-8">
        <p>Expense List {{ isset($data['selected_type']) ? '(' . $data['selected_type'] . ')' : '' }}</p>
    </div>

    <table border="1" style="width: 100%; border-collapse: collapse">
        <thead>
            <x-tr-mpdf-bg-primary>
                <x-th-mpdf width="80px" align="center">Sr. No</x-th-mpdf>
                <x-th-mpdf width="80px" align="center">Reg No</x-th-mpdf>
                <x-th-mpdf width="100px">Date</x-th-mpdf>
                <x-th-mpdf width="150px">Expense Type</x-th-mpdf>
                <x-th-mpdf>Description</x-th-mpdf>
                <x-th-mpdf width="100px" align="center">Price</x-th-mpdf>
                <x-th-mpdf width="80px" align="center">Qty</x-th-mpdf>
                <x-th-mpdf width="100px" align="center">Amount</x-th-mpdf>
            </x-tr-mpdf-bg-primary>
        </thead>
        <tbody class="bg-white text-xs">
            @foreach ($data['expenses'] as $index => $expense)
                <tr>
                    <x-td-mpdf align="center">{{ $index + 1 }}</x-td-mpdf>
                    <x-td-mpdf align="center">{{ $expense->id }}</x-td-mpdf>
                    <x-td-mpdf>{{ $expense->expense_date }}</x-td-mpdf>
                    <x-td-mpdf>{{ $expense->expenseType->expense_type_name }}</x-td-mpdf>
                    <x-td-mpdf>{{ $expense->description }}</x-td-mpdf>
                    <x-td-mpdf align="right">{{ number_format($expense->price, 0, '.', ',') }}</x-td-mpdf>
                    <x-td-mpdf align="center">{{ $expense->qty }}</x-td-mpdf>
                    <x-td-mpdf align="right">{{ number_format($expense->price * $expense->qty, 0, '.', ',') }}</x-td-mpdf>
                </tr>
            @endforeach

        </tbody>
    </table>

    <x-mpdf-page-footer />
</body>

</html>
