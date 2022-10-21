<htmlpagefooter name="page-footer">
    <div style="float: left; width: 50%;" class="text-xs">
        Printed Date: {{ now()->format('Y-m-d g:i A') }} &nbsp;&nbsp;&nbsp;&nbsp; Printed By: {{ auth()->user()->name }}
    </div>
    <div style="float: right; width: 50%;" class="text-right text-xs">
        Page {PAGENO} of {nbpg}
    </div>
    <div style="clear: both; margin: 0pt; padding: 0pt; "></div>
</htmlpagefooter>
