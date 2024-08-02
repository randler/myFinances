<div>
    <x-filament::dropdown>
        <x-slot name="trigger">
            <x-filament::icon
            icon="heroicon-o-chat-bubble-left-right"
            class="h-7 w-7 text-gray-500 dark:text-gray-400"/>
        </x-slot>

        <x-filament::dropdown.list>
            <x-filament::dropdown.list.item
                    wire:click="openModalNewChat()" 
                    icon="fas-circle-plus">
                    New Chat
                </x-filament::dropdown.list.item>
                <hr class="my-2" />
                <livewire:rooms />
        </x-filament::dropdown.list>
    </x-filament::dropdown>
</div>