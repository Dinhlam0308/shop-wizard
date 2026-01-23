<x-app-layout>
    {{-- === Page Title (SEO + UX) === --}}
    @section('title', "{$workshop->title} — Always Café Workshops")
    @php
        $workshopAt = \Carbon\Carbon::parse($workshop->date . ' ' . ($workshop->time ?? '23:59:59'));
        $isExpired = $workshopAt->isPast();
    @endphp


    <section class="relative mt-20 md:mt-28">

        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- === Header Section === --}}
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-8 mb-10">
                <div class="flex items-center gap-5">
                    <div
                        class="w-20 h-20 rounded-2xl overflow-hidden ring-2 ring-amber-400/20 shadow-[0_0_25px_rgba(255,215,0,0.1)] flex-shrink-0">
                        <x-fallback-image src="{{ $workshop->image ?? '/images/workshop-ink.jpg' }}"
                            alt="{{ $workshop->title }}" class="w-full h-full object-cover" />
                    </div>

                    <div>
                        <h1
                            class="text-3xl md:text-4xl font-semibold text-amber-100 font-[Playfair_Display] tracking-tight drop-shadow-[0_1px_4px_rgba(0,0,0,0.7)]">
                            {{ $workshop->title }}
                        </h1>
                        <p class="text-stone-300/70 text-sm mt-1 flex items-center gap-2">
                            <i data-lucide="calendar" class="w-4 h-4 text-amber-300"></i>
                            {{ \Illuminate\Support\Carbon::parse($workshop->date . ' ' . $workshop->time)->format('d/m/Y • H:i') }}
                        </p>
                    </div>
                </div>

                {{-- === Price & Register Button === --}}
                <div class="flex flex-col items-end gap-3">
                    <p class="text-amber-200 font-semibold text-xl flex items-center gap-2">
                        <i data-lucide="coins" class="w-5 h-5 text-amber-300"></i>
                        {{ number_format($workshop->price, 0, ',', '.') }}đ
                    </p>

                    @if ($isExpired)
                        <button type="button" disabled
                            class="inline-flex items-center gap-3 rounded-2xl px-6 py-3 text-base font-semibold
               bg-white/10 text-stone-300 border border-white/10
               cursor-not-allowed opacity-70 grayscale
               shadow-[0_8px_25px_rgba(0,0,0,0.35)]">
                            <i data-lucide="ban" class="w-5 h-5 text-rose-300"></i>
                            <span data-vi="Đã quá hạn" data-en="Expired"></span>
                        </button>
                    @else
                        <a href="{{ route('user.workshop_registrations.create', $workshop->id) }}"
                            class="hp-btn-primary inline-flex items-center gap-3 rounded-2xl px-6 py-3 text-base font-semibold hp-hover hp-glow">
                            <i data-lucide="calendar-plus" class="w-5 h-5"></i>
                            <span data-vi="Đăng ký" data-en="Register"></span>
                        </a>
                    @endif
                </div>
            </div>

            {{-- === Main Card === --}}
            <div
                class="hp-card rounded-3xl p-8 backdrop-blur-xl bg-gradient-to-br from-white/5 via-white/5 to-transparent border border-white/10 shadow-[0_8px_40px_rgba(0,0,0,0.4)] mb-10">

                {{-- === Description === --}}
                <div class="mb-8">
                    <h2 class="text-amber-200 font-semibold text-lg flex items-center gap-2 mb-3">
                        <i data-lucide="book-open-text" class="w-5 h-5 text-amber-300"></i>
                        <span data-vi="Giới thiệu Workshop" data-en="Workshop Introduction"></span>
                    </h2>
                    <p class="text-stone-300/80 leading-relaxed text-[15px]">
                        {{ $workshop->description ?? 'Thông tin chi tiết về workshop đang được cập nhật...' }}
                    </p>
                </div>

                {{-- === Info Grid === --}}
                <div class="grid md:grid-cols-2 gap-8">
                    {{-- Left Info --}}
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 text-stone-200/90">
                            <div
                                class="w-10 h-10 rounded-xl bg-amber-400/10 border border-amber-400/20 flex items-center justify-center">
                                <i data-lucide="map-pin" class="w-5 h-5 text-amber-300"></i>
                            </div>
                            <div>
                                <p class="text-sm text-stone-400/70"><span data-vi="Địa điểm" data-en="Location"></span>
                                </p>
                                <p class="font-medium text-amber-100">{{ $workshop->location }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 text-stone-200/90">
                            <div
                                class="w-10 h-10 rounded-xl bg-amber-400/10 border border-amber-400/20 flex items-center justify-center">
                                <i data-lucide="users" class="w-5 h-5 text-amber-300"></i>
                            </div>
                            <div>
                                <p class="text-sm text-stone-400/70"><span data-vi="Số lượng tham dự tối đa"
                                        data-en="Maximum participants"></span></p>
                                <p class="font-medium text-amber-100">{{ $workshop->max_participants }} <span
                                        data-vi="người" data-en="people"></span></p>
                            </div>
                        </div>
                    </div>

                    {{-- Right Info --}}
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 text-stone-200/90">
                            <div
                                class="w-10 h-10 rounded-xl bg-amber-400/10 border border-amber-400/20 flex items-center justify-center">
                                <i data-lucide="clock-4" class="w-5 h-5 text-amber-300"></i>
                            </div>
                            <div>
                                <p class="text-sm text-stone-400/70"><span data-vi="Thời gian bắt đầu"
                                        data-en="Start time"></span></p>
                                <p class="font-medium text-amber-100">
                                    {{ \Illuminate\Support\Carbon::parse($workshop->time)->format('H:i') }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 text-stone-200/90">
                            <div
                                class="w-10 h-10 rounded-xl bg-amber-400/10 border border-amber-400/20 flex items-center justify-center">
                                <i data-lucide="calendar-days" class="w-5 h-5 text-amber-300"></i>
                            </div>
                            <div>
                                <p class="text-sm text-stone-400/70"><span data-vi="Ngày tổ chức"
                                        data-en="Event Date"></span></p>
                                <p class="font-medium text-amber-100">
                                    {{ \Illuminate\Support\Carbon::parse($workshop->date)->translatedFormat('d F, Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- === Back Button === --}}
            <div class="flex justify-center pb-4">
                <a href="{{ route('user.workshops.index') }}"
                    class="inline-flex items-center gap-2 text-stone-300/80 hover:text-amber-300 transition-colors text-sm font-medium">
                    <i data-lucide="arrow-left-circle" class="w-5 h-5"></i>
                    <span data-vi="Quay lại danh sách Workshop" data-en="Back to Workshop List"></span>
                </a>
            </div>
        </div>
    </section>
</x-app-layout>
