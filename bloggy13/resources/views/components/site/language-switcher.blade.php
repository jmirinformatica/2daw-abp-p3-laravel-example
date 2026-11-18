<flux:dropdown position="bottom" align="end">
    <flux:button
        variant="ghost"
        size="sm"
        icon:trailing="chevron-down"
        icon:trailing:variant="micro"
    >
        {{ $availableLocales[$currentLocale] ?? $currentLocale }}
        ({{ $currentLocale }})
    </flux:button>

    <flux:navmenu>
        @foreach ($availableLocales as $locale => $localeName)
            @if ($locale !== $currentLocale)
                <flux:navmenu.item :href="route('language', $locale)">
                    {{ $localeName }} ({{ $locale }})
                </flux:navmenu.item>
            @endif
        @endforeach
    </flux:navmenu>
</flux:dropdown>