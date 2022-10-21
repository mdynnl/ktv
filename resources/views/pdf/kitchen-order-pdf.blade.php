<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">

    <title>Kitchen Order</title>

    <link rel="stylesheet" href="{{ asset('css/mpdf.css') }}">

</head>

<body class="text-gray-700" style="background: white">
    <div style="width: 70mm" class="text-xs">
        <table cellPadding="3px" style="width: 100%; border-collapse: collapse" class="text-xs">
            <thead>
                <tr>
                    <th colspan="3" align="center" class="border-b border-t font-normal">Kitchen Order</th>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2">Date: {{ now()->format('Y-m-d') }}</td>
                    <td colspan="1">Time: {{ now()->format('g:i A') }}</td>
                </tr>
                <tr>
                    <td colspan="2" valign="top">Table: {{ $data['table_name'] }}</td>
                    <td colspan="1" valign="top">Cashier: {{ $data['cashier'] }}</td>
                </tr>
                <tr>
                    <td colspan="2">Invoice: {{ $data['invoice_no'] }}</td>
                    <td colspan="1">Order Time: {{ $data['order_time'] }}</td>
                </tr>

                <tr>
                    <td class="border-t border-b" align="left" colspan="2">Item</td>
                    <td class="border-t border-b" align="right">Qty</td>
                </tr>
            </thead>
            <tbody class="bg-white text-xs">
                @foreach ($data['order_details'] as $item)
                    <tr>
                        <td class="border-dotted-b" colspan="2">{{ $item['food_name'] }} <br> {{ $item['remark'] }}</td>
                        <td class="border-dotted-b" align="right">{{ $item['qty'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
