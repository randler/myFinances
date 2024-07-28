<x-filament::dropdown>
    <x-slot name="trigger">
        <x-filament::icon
        icon="heroicon-o-chat-bubble-left-right"
        class="h-7 w-7 text-gray-500 dark:text-gray-400"/>
    </x-slot>

    <x-filament::dropdown.list>
        <x-filament::dropdown.list.item icon="fas-circle-user">
            username
        </x-filament::dropdown.list.item>
    </x-filament::dropdown.list>
</x-filament::dropdown>