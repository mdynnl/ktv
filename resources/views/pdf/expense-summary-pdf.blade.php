<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">

    <title>Expense Summary</title>

    <link rel="stylesheet" href="{{ asset('css/mpdf.css') }}">

</head>

<body class="text-gray-700" style="background: white">
    <x-header-mpdf appName="{{ config('app.name') }}" appAddress="{{ config('app.address') }}" />

    <div class="text-center mt-8">
        <p>Expense Summary</p>
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

    <table border="1" style="width: 100%; border-collapse: collapse">
        <thead>
            <x-tr-mpdf-bg-primary>
                <x-th-mpdf width="80px" align="center">Sr. No</x-th-mpdf>
                <x-th-mpdf>Expense Type</x-th-mpdf>
                <x-th-mpdf width="150px" align="center">Amount</x-th-mpdf>
            </x-tr-mpdf-bg-primary>
        </thead>
        <tbody class="bg-white text-xs">
            @foreach ($data['expenseTypes'] as $index => $type)
                <tr>
                    <x-td-mpdf align="center">{{ $index + 1 }}</x-td-mpdf>
                    <x-td-mpdf align="left">{{ $type->expense_type_name }}</x-td-mpdf>
                    <x-td-mpdf align="right">{{ number_format($type->expenses->sum('amount'), 0, '.', ',') }}
                    </x-td-mpdf>
                </tr>
            @endforeach
        </tbody>
    </table>

    <x-mpdf-page-footer />
</body>

</html>
