<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">

    <title>Sales Summary</title>

    <link rel="stylesheet" href="{{ asset('css/mpdf.css') }}">

</head>

<body class="text-gray-700" style="background: white">
    <x-header-mpdf appName="{{ config('app.name') }}" appAddress="{{ config('app.address') }}" />

    <div class="text-center mt-8">
        <p>Sales Summary</p>
    </div>

    <div class="mb-5">
        <div style="float: left; width: 40%;" class="text-xs">
            <div>
                Date From: {{ $data['date_from'] }}
            </div>
            <div>
                Date To: {{ $data['date_to'] }}
            </div>
            <div>
                {{-- Selected Reports: {{ $data['selected_reports'] }} --}}
            </div>
            {{-- <div>
                Check Out: {{ $data['departure'] }}
            </div> --}}
        </div>
        <div style="float: right; width: 50%;" class="text-xs">
        </div>
        <div style="float: right; width: 50%;" class="text-right text-xs"></div>
        <div style="clear: both; margin: 0pt; padding: 0pt; "></div>

    </div>


    {{-- <div class="mt-8">
        <div style="float: left; width: 50%;" class="text-xs">
            Printed Date: {{ now()->format('Y-m-d g:i A') }}
        </div>
        <div style="float: right; width: 50%;" class="text-right text-xs">
            User Name: {{ auth()->user()->name }}
        </div>
        <div style="clear: both; margin: 0pt; padding: 0pt; "></div>
    </div> --}}

    <table border="1" style="width: 100%; border-collapse: collapse">
        <thead>
            <x-tr-mpdf-bg-primary>
                <x-th-mpdf width="80px" align="center">Sr. No</x-th-mpdf>
                <x-th-mpdf width="80px" align="center">Reg No</x-th-mpdf>
                <x-th-mpdf>Date</x-th-mpdf>
                <x-th-mpdf>Room</x-th-mpdf>
                <x-th-mpdf align="center">Room Amount</x-th-mpdf>
                <x-th-mpdf align="center">F&B Amount</x-th-mpdf>
                <x-th-mpdf align="center">Service Amount</x-th-mpdf>
                <x-th-mpdf align="center">Cash</x-th-mpdf>
                <x-th-mpdf align="center">Card</x-th-mpdf>
                <x-th-mpdf align="center">Credit</x-th-mpdf>
                <x-th-mpdf align="center">Total Amount</x-th-mpdf>
                <x-th-mpdf align="center">Tax</x-th-mpdf>
                <x-th-mpdf align="center">Service</x-th-mpdf>
                <x-th-mpdf align="center">Net Amount</x-th-mpdf>
            </x-tr-mpdf-bg-primary>
        </thead>
        <tbody class="bg-white text-xs">
            @foreach ($data['salesSummary'] as $index => $summary)
                <tr>
                    <x-td-mpdf align="center">{{ $index + 1 }}</x-td-mpdf>
                    <x-td-mpdf align="center">{{ $summary->id }}</x-td-mpdf>
                    <x-td-mpdf>{{ $summary->operation_date }}</x-td-mpdf>
                    <x-td-mpdf>{{ $summary->room_no }}</x-td-mpdf>
                    <x-td-mpdf align="right">{{ number_format($summary->room_amount, 0, '.', ',') }}</x-td-mpdf>
                    <x-td-mpdf align="right">{{ number_format($summary->fb_amount, 0, '.', ',') }}</x-td-mpdf>
                    <x-td-mpdf align="right">{{ number_format($summary->service_amount, 0, '.', ',') }}</x-td-mpdf>
                    <x-td-mpdf align="right">{{ number_format($summary->cash, 0, '.', ',') }}</x-td-mpdf>
                    <x-td-mpdf align="right">{{ number_format($summary->card, 0, '.', ',') }}</x-td-mpdf>
                    <x-td-mpdf align="right">{{ number_format($summary->credit, 0, '.', ',') }}</x-td-mpdf>
                    <x-td-mpdf align="right">{{ number_format($summary->total_amount, 0, '.', ',') }}</x-td-mpdf>
                    <x-td-mpdf align="right">{{ number_format($summary->tax, 0, '.', ',') }}</x-td-mpdf>
                    <x-td-mpdf align="right">{{ number_format($summary->service, 0, '.', ',') }}</x-td-mpdf>
                    <x-td-mpdf align="right">{{ number_format($summary->net_amount, 0, '.', ',') }}</x-td-mpdf>
                </tr>
            @endforeach

            {{-- <tr style="border: none">
                <x-td-mpdf style="border: none" colspan="4" align="right">Sub Total:</x-td-mpdf>
                <x-td-mpdf style="border: none" align="right">{{ number_format($data['sub_total'], 0, '.', ',') }}</x-td-mpdf>
            </tr>
            <tr style="border: none">
                <x-td-mpdf style="border: none" colspan="4" align="right">{{ $data['commercial_tax'] }}% Commercial Tax:</x-td-mpdf>
                <x-td-mpdf style="border: none" align="right">{{ number_format($data['ct_amount'], 0, '.', ',') }}</x-td-mpdf>
            </tr>
            <tr style="">
                <x-td-mpdf style="border: none" colspan="4" align="right">{{ $data['service_tax'] }}% Service Tax:</x-td-mpdf>
                <x-td-mpdf style="border-top: none; border-right: none; border-left: none" align="right">
                    {{ number_format($data['st_amount'], 0, '.', ',') }}
                </x-td-mpdf>
            </tr>
            <tr style="border: none">
                <x-td-mpdf style="border: none" colspan="4" align="right">Total:</x-td-mpdf>
                <x-td-mpdf style="border: none" align="right">{{ number_format($data['total'], 0, '.', ',') }}
                </x-td-mpdf>
            </tr> --}}
        </tbody>
    </table>


    {{-- <htmlpagefooter name="page-footer">
        <div style="float: left; width: 50%;" class="text-xs">
            Printed Date: {{ now()->format('Y-m-d g:i A') }} &nbsp;&nbsp;&nbsp;&nbsp; Printed By: {{ auth()->user()->name }}
        </div>
        <div style="float: right; width: 50%;" class="text-right text-xs">
            Page No: {PAGENO}
        </div>
        <div style="clear: both; margin: 0pt; padding: 0pt; "></div>
    </htmlpagefooter> --}}
    <x-mpdf-page-footer />
</body>

</html>
