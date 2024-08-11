

<x-filament::modal id="chat-room-message"
    width="5xl"
    :close-by-escaping="false"
    :close-by-clicking-away="false"
    >
    <x-slot name="heading">
        <div class="flex items-center">
            <x-filament::icon
                icon="heroicon-o-chat-bubble-left-right"
                class="h-7 w-7 text-gray-500 dark:text-gray-400"
    
            />
            <span class="ml-5">{{ $receiverName }}</span>

        </div>
        
    </x-slot>

    <div class="h-96 overflow-y-auto p-4 border-t border-b border-gray-200 dark:border-gray-700">
        @forelse($messages as $message)
            @if ($message->content != '')
            @php $isOwn = $message->sender == auth()->id() @endphp
                <div @class([
                        'flex',
                        'justify-start' => $isOwn,
                        'justify-end' => !$isOwn,
                    ])>
                    <div>
                        <span class="font-bold">{{ $message->user->name }}</span>
                        <span class="text-gray-500 dark:text-gray-400">{{ $message->created_at->diffForHumans() }}</span>
                        <p>{{ $message->content }}</p>
                    </div>
                </div>
            @endif
        @empty
            <p class="text-gray-500 dark:text-gray-400 text-center">No messages</p>
        @endforelse
    </div>
    <div class="flex w-full">
        <x-filament::input.wrapper>
            <x-filament::input
                type="text"
                width="full"
                wire:model="message"
                placeholder="Type a message"
            />
        </x-filament::input.wrapper>
        <x-filament::button
            wire:click="sendMessage"
            class="ml-2"
            >
            Send
        </x-filament::button>
    </div>

</x-filament::modal>