@props([
    'src' => '',
    'alt' => '',
    'class' => ''
])

<div class="relative aspect-[4/3] overflow-hidden rounded-2xl {{ $class }}">
    <img 
        src="{{ $src }}" 
        alt="{{ $alt }}"
        class="h-full w-full object-cover transition-transform duration-700 hover:scale-[1.02]"
        onerror="
            this.classList.add('hidden');
            this.nextElementSibling.classList.remove('hidden');
        "
    />
    <div class="absolute inset-0 hidden flex flex-col items-center justify-center 
        bg-gradient-to-br from-stone-100 to-stone-200 
        dark:from-stone-800 dark:to-stone-700 
        text-stone-500 dark:text-stone-300 
        animate-fade-in">
        <svg xmlns='http://www.w3.org/2000/svg' class='h-10 w-10 mb-2 opacity-60' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M3 3l18 18M3 21h18M3 3v18'/>
        </svg>
        <span class="text-sm font-medium">Image not available</span>
    </div>
</div>
