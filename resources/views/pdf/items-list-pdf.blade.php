<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">

    <title>Items List</title>

    <link rel="stylesheet" href="{{ asset('css/mpdf.css') }}">

</head>

<body class="text-gray-700" style="background: white">
    <x-header-mpdf appName="{{ config('app.name') }}" appAddress="{{ config('app.address') }}" />

    <div class="text-center mt-8">
        <p>Items List ({{ $data['list_type'] }})</p>
    </div>

    <table border="1" style="width: 100%; border-collapse: collapse">
        <thead>
            <x-tr-mpdf-bg-primary>
                {{-- <x-th-mpdf>Date</x-th-mpdf> --}}
                <x-th-mpdf>Item</x-th-mpdf>
                <x-th-mpdf width="120px">Recipe Unit</x-th-mpdf>
                <x-th-mpdf width="120px">Recipe Price</x-th-mpdf>
                <x-th-mpdf align="center" width="120px">Reorder</x-th-mpdf>
                <x-th-mpdf align="center" width="120px">Current Qty</x-th-mpdf>
            </x-tr-mpdf-bg-primary>
        </thead>
        <tbody class="bg-white text-xs">
            @foreach ($data['data'] as $item)
                <tr>
                    {{-- <x-td-mpdf>{{ $item->date }}</x-td-mpdf> --}}
                    <x-td-mpdf>{{ $item->item_name }}</x-td-mpdf>
                    <x-td-mpdf>{{ $item->recipe_unit }}</x-td-mpdf>
                    <x-td-mpdf align="right">{{ number_format($item->recipe_price, 0, '.', ',') }}</x-td-mpdf>
                    <x-td-mpdf align="center">{{ $item->reorder }}</x-td-mpdf>
                    <x-td-mpdf align="center">{{ $item->current_qty }}</x-td-mpdf>
                </tr>
            @endforeach

        </tbody>
    </table>

    <x-mpdf-page-footer />
</body>

</html>
