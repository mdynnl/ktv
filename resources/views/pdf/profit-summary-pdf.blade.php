<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">

    <title>Profit Summary</title>

    <link rel="stylesheet" href="{{ asset('css/mpdf.css') }}">

</head>

<body class="text-gray-700" style="background: white">
    <x-header-mpdf appName="{{ config('app.name') }}" appAddress="{{ config('app.address') }}" />

    <div class="text-center mt-8">
        <p>Profit Summary</p>
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
                <x-th-mpdf>Income</x-th-mpdf>
                <x-th-mpdf width="150px" align="center">Amount</x-th-mpdf>
                <x-th-mpdf>Expense</x-th-mpdf>
                <x-th-mpdf width="150px" align="center">Amount</x-th-mpdf>
            </x-tr-mpdf-bg-primary>
        </thead>
        <tbody class="bg-white text-xs">
            @for ($i = 0; $i < $data['range']; $i++)
                {{-- <tr> --}}
                <tr
                    class="divide-x bg-white text-gray-900">
                    <x-td-mpdf align="left">{{ isset($data['incomes'][$i]) ? $data['incomes'][$i]->income : '' }}</x-td-mpdf>
                    <x-td-mpdf align="right">
                        {{ isset($data['incomes'][$i]) ? number_format($data['incomes'][$i]->amount, 0, '.', ',') : '' }}
                    </x-td-mpdf>

                    {{-- Expense --}}
                    <x-td-mpdf align="left">{{ isset($data['expenses'][$i]) ? $data['expenses'][$i]->expense : '' }}
                    </x-td-mpdf>
                    <x-td-mpdf align="right">
                        {{ isset($data['expenses'][$i]) ? number_format($data['expenses'][$i]->amount, 0, '.', ',') : '' }}
                    </x-td-mpdf>
                </tr>
            @endfor
            <tr>
                <x-td-mpdf align="left"><span>Total Income</span></x-td-mpdf>
                <x-td-mpdf align="right"><span>{{ number_format($data['total_income'], 0, '.', ',') }}</span>
                </x-td-mpdf>
                <x-td-mpdf align="left"><span>Total Expense</span></x-td-mpdf>
                <x-td-mpdf align="right"><span>{{ number_format($data['total_expense'], 0, '.', ',') }}</span>
                </x-td-mpdf>
            </tr>
            <tr>
                <x-td-mpdf align="center" colspan=3><span>Profit</span></x-td-mpdf>
                <x-td-mpdf align="right">
                    <span>{{ number_format($data['profit'], 0, '.', ',') }}</span>
                </x-td-mpdf>
            </tr>
        </tbody>
    </table>

    <x-mpdf-page-footer />
</body>

</html>
