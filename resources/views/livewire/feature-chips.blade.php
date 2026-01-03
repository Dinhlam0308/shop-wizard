<div wire:poll.5000ms="refresh" class="flex flex-wrap gap-3 pt-2">
    @foreach ($chips as $chip)
        <span
            class="hp-caption rounded-full hp-card px-4 py-2 text-amber-200 border border-amber-400/20 hp-hover">
            {{ $chip }}
        </span>
    @endforeach
</div>
