<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">

    <title>Commission Detail</title>

    <link rel="stylesheet" href="{{ asset('css/mpdf.css') }}">

</head>

<body class="text-gray-700" style="background: white">
    <x-header-mpdf appName="{{ config('app.name') }}" appAddress="{{ config('app.address') }}" />

    <div class="text-center mt-8">
        <p>Commission Detail</p>
    </div>

    <div class="mb-5">
        <div style="float: left; width: 40%;" class="text-xs">
            <div>
                Date From: {{ $data['date_from'] }}
            </div>
            <div>
                Date To: {{ $data['date_to'] }}
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
                <x-th-mpdf align="center" width="100px">Sr. No</x-th-mpdf>
                <x-th-mpdf align="center" width="100px">Reg. No</x-th-mpdf>
                <x-th-mpdf width="100px">Room</x-th-mpdf>
                <x-th-mpdf>Date</x-th-mpdf>
                <x-th-mpdf>Name</x-th-mpdf>
                <x-th-mpdf align="center">Sessions</x-th-mpdf>
                <x-th-mpdf align="center">Rate</x-th-mpdf>
                <x-th-mpdf align="center">Commission</x-th-mpdf>
                <x-th-mpdf align="center" width="180px">Commission Amount</x-th-mpdf>
            </x-tr-mpdf-bg-primary>
        </thead>
        <tbody class="bg-white text-xs">
            @foreach ($data['inhouseServices'] as $index => $detail)
                <tr>
                    <x-td-mpdf align="center">{{ $index + 1 }}</x-td-mpdf>
                    <x-td-mpdf align="center">{{ $detail->inhouse_id }}</x-td-mpdf>
                    <x-td-mpdf>{{ $detail->inhouse->room->room_no }}</x-td-mpdf>
                    <x-td-mpdf>{{ $detail->operation_date }}</x-td-mpdf>
                    <x-td-mpdf>{{ $detail->serviceStaff->nick_name }}</x-td-mpdf>
                    <x-td-mpdf align="center">{{ $detail->session_hours }}</x-td-mpdf>
                    <x-td-mpdf align="right">
                        {{ number_format($detail->service_staff_rate, 0, '.', ',') }}
                    </x-td-mpdf>
                    <x-td-mpdf align="right">
                        {{ number_format($data['commission'], 0, '.', ',') }}
                    </x-td-mpdf>
                    <x-td-mpdf align="right">
                        {{ number_format($data['commission'] * $detail->session_hours, 0, '.', ',') }}
                    </x-td-mpdf>
                </tr>
            @endforeach
        </tbody>
    </table>

    <x-mpdf-page-footer />
</body>

</html>
