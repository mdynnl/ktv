<span
      @class([
          'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium',
          'bg-green-100 text-green-800' => $bool,
          'bg-red-100 text-red-800' => !$bool,
      ])>
    {{ $slot }}
</span>
