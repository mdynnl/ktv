<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">

    <title>Commission Summary</title>

    <link rel="stylesheet" href="{{ asset('css/mpdf.css') }}">

</head>

<body class="text-gray-700" style="background: white">
    <x-header-mpdf appName="{{ config('app.name') }}" appAddress="{{ config('app.address') }}" />

    <div class="text-center mt-8">
        <p>Commission Summary ({{ $data['filter'] }})</p>
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

    <table border="1" style="width: 100%; border-collapse: collapse">
        <thead>
            <x-tr-mpdf-bg-primary>
                <x-th-mpdf align="center" width="100px">Sr. No</x-th-mpdf>
                <x-th-mpdf align="center" width="100px">Reg No</x-th-mpdf>
                <x-th-mpdf align="center">Name</x-th-mpdf>
                <x-th-mpdf align="center" width="150px">Sessions</x-th-mpdf>
                <x-th-mpdf align="center" width="150px">Service Rate</x-th-mpdf>
                <x-th-mpdf align="center" width="150px">Commission Rate</x-th-mpdf>
                <x-th-mpdf align="center" width="180px">Commission Amount</x-th-mpdf>
            </x-tr-mpdf-bg-primary>
        </thead>
        <tbody class="bg-white text-xs">
            @foreach ($data['commissionSummaries'] as $index => $summary)
                <tr>
                    <x-td-mpdf align="center">{{ $index + 1 }}</x-td-mpdf>
                    <x-td-mpdf align="center">{{ $summary->service_staff_id }}</x-td-mpdf>
                    <x-td-mpdf>{{ $summary->nick_name }}</x-td-mpdf>
                    <x-td-mpdf align="center">{{ $summary->session_hours }}</x-td-mpdf>
                    <x-td-mpdf align="right">{{ number_format($summary->service_staff_rate, 0, '.', ',') }}
                    </x-td-mpdf>
                    <x-td-mpdf align="right">{{ number_format($summary->service_staff_commission_rate, 0, '.', ',') }}
                    </x-td-mpdf>
                    <x-td-mpdf align="right">{{ number_format($summary->commission_amount, 0, '.', ',') }}
                    </x-td-mpdf>
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
