<section class="mt-20 md:mt-24" wire:poll.10s="loadTestimonials">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h3 class="hp-title hp-headline text-amber-200 mb-3">
                <span data-vi="Câu Chuyện Từ Khách Hàng" data-en="Customer Stories"></span>
            </h3>
            <p class="text-stone-300/70"><span data-vi="Những trải nghiệm phép thuật được chia sẻ" data-en="Shared magical experiences"></span></p>
            <div class="w-24 h-px hp-divider mx-auto mt-6"></div>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($testimonials as $item)
                <figure class="hp-card rounded-2xl p-6 hp-hover transition-all duration-500 ease-out hover:scale-[1.02] hover:shadow-[0_0_40px_rgba(255,215,0,0.15)]">
                    <div class="mb-4">
                        {{-- Hiển thị 5 sao --}}
                        <div class="text-amber-300 text-lg mb-2">
                            @for ($i = 0; $i < 5; $i++)
                                ⭐
                            @endfor
                        </div>
                        <blockquote class="text-stone-200/90 leading-relaxed text-sm italic">
                            “{{ Str::limit($item->message, 200) }}”
                        </blockquote>
                    </div>

                    <figcaption class="flex items-center justify-between mt-3">
                        <div>
                            <div class="hp-subtitle text-amber-100 font-semibold text-sm">{{ $item->name }}</div>
                            <div class="text-stone-400/60 text-xs">
                                {{ $item->created_at->diffForHumans() }}
                            </div>
                        </div>

                        <div class="w-10 h-10 bg-gradient-to-br from-amber-400/20 to-amber-600/30 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-300" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4.583 17.321C3.553 16.227 3 15 3 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 01-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179zm10 0C13.553 16.227 13 15 13 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 01-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179z"/>
                            </svg>
                        </div>
                    </figcaption>
                </figure>
            @empty
                <div class="col-span-full text-center text-stone-400"><span data-vi="Hiện chưa có phản hồi nào" data-en="No reviews yet"></span></div>
            @endforelse
        </div>
    </div>
</section>
