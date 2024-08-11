<div>
    @forelse($rooms as $room)
        <x-filament::dropdown.list.item
            wire:click="openRoomChatMessage({{ $room->id }})" 
            icon="fas-circle-user">
            {{ $room->getUserRoom()->name }}
        </x-filament::dropdown.list.item>
    @empty
        <x-filament::dropdown.list.item 
            class="text-gray-500 dark:text-gray-400 cursor-not-allowed text-center"
            icon="fas-ban">
            No chats
        </x-filament::dropdown.list.item>
    @endforelse
</div>
