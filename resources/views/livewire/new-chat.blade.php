<x-filament::modal id="new-chat"
    :close-by-escaping="false"
    :close-by-clicking-away="false"
    >
    <x-slot name="heading">
        Users
    </x-slot>

    <x-slot name="description">
        <x-filament::input.wrapper
            suffix-icon="fas-search"
            >
            <x-filament::input
                type="text"
                wire:model.live="searchName"
            />
        </x-filament::input.wrapper>
    </x-slot>

    <x-filament::dropdown.list>
        @forelse($users as $user)
            <x-filament::dropdown.list.item
                wire:click="createChatRom({{ $user->id }})" 
                icon="fas-circle-user">
                {{ $user->name }}
            </x-filament::dropdown.list.item>
        @empty
            <x-filament::dropdown.list.item 
                class="text-gray-500 dark:text-gray-400 cursor-not-allowed text-center"
                icon="fas-ban">
                No users
            </x-filament::dropdown.list.item>
        @endforelse
    </x-filament::dropdown.list>

</x-filament::modal>