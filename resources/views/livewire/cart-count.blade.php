<div wire:poll.keep-alive.1s="refreshCartCount">
    <span
        class="inline-flex items-center justify-center w-5 h-5 rounded-full 
             bg-gradient-to-r from-amber-400 to-yellow-500 
             text-black text-xs font-semibold shadow-md">
        {{ $this->count }}
    </span>
</div>
