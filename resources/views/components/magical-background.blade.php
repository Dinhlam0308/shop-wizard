<div aria-hidden="true"
     class="pointer-events-none fixed top-0 left-0 w-full h-full -z-10 overflow-hidden gpu-accelerated will-change-transform">
    
    {{-- Deep magical gradient background --}}
    <div class="absolute inset-0 bg-gradient-to-b from-[#0b0d11] via-[#161a20] to-[#090a0f]"></div>

    {{-- Magical aura overlays --}}
    <div class="absolute inset-0 bg-[radial-gradient(1000px_800px_at_15%_20%,var(--hp-gold-soft,rgba(255,215,0,0.08)),transparent_60%)]"></div>
    <div class="absolute inset-0 bg-[radial-gradient(900px_700px_at_85%_25%,var(--hp-amethyst-soft,rgba(153,102,255,0.08)),transparent_65%)]"></div>
    <div class="absolute inset-0 bg-[radial-gradient(700px_400px_at_50%_80%,rgba(255,140,0,0.05),transparent_70%)]"></div>


    {{-- Starfield (canvas) --}}
    <canvas id="starfield" class="absolute inset-0 opacity-60 mix-blend-screen"></canvas>

    {{-- Floating magical particles --}}
    @foreach ([
        ['top-24 left-12','w-3 h-3 bg-amber-400/70 hp-particle','0s'],
        ['top-32 right-20','w-2 h-2 bg-yellow-300/60 hp-particle-slow','2s'],
        ['top-48 left-1/4','w-1.5 h-1.5 bg-amber-500/50 hp-particle-reverse','4s'],
        ['top-56 right-1/3','w-2.5 h-2.5 bg-yellow-200/40 hp-particle-spiral','1s'],
        ['top-72 left-16','w-1 h-1 bg-amber-300/80 hp-particle','6s'],
        ['top-80 right-12','w-2 h-2 bg-yellow-400/60 hp-particle-slow','3s'],
        ['top-[40rem] left-12','w-2 h-2 bg-yellow-400/50 hp-particle-spiral','5s'],
        ['top-[52rem] right-1/3','w-1.5 h-1.5 bg-amber-500/50 hp-particle-reverse','6.5s'],
        ['top-[60rem] left-1/4','w-3 h-3 bg-amber-400/70 hp-particle','4.5s'],
        ['top-[72rem] right-20','w-1 h-1 bg-yellow-300/80 hp-particle-slow','2.5s'],
        ['top-[80rem] left-12','w-2 h-2 bg-amber-500/50 hp-particle-reverse','3.5s'],
        ['top-[88rem] right-12','w-2.5 h-2.5 bg-yellow-200/40 hp-particle-spiral','1.5s'],
        ['top-[96rem] left-16','w-1.5 h-1.5 bg-yellow-400/60 hp-particle','0.5s'],
        ['top-[104rem] right-1/4','w-2 h-2 bg-amber-300/80 hp-particle-slow','1s'],
        ['top-[112rem] left-12','w-1 h-1 bg-yellow-300/70 hp-particle-reverse','3s'],
        ['top-[120rem] right-20','w-3 h-3 bg-amber-400/60 hp-particle-spiral','2s'],
        ['top-[128rem] left-1/3','w-2 h-2 bg-yellow-400/50 hp-particle','1s'],
        ['top-[136rem] right-16','w-1.5 h-1.5 bg-amber-500/70 hp-particle-slow','2s'],
        ['top-[144rem] left-20','w-2.5 h-2.5 bg-yellow-200/40 hp-particle-reverse','3s'],
        ['top-[152rem] right-12','w-1 h-1 bg-yellow-300/80 hp-particle-spiral','1.5s'],
        ['top-[160rem] left-16','w-2 h-2 bg-amber-400/60 hp-particle','14s'],
        ['top-[168rem] right-1/4','w-1.5 h-1.5 bg-yellow-400/50 hp-particle-slow','1.5s'],
        ['top-[176rem] left-12','w-3 h-3 bg-amber-500/70 hp-particle-reverse','4s'],
        ['top-[184rem] right-20','w-2 h-2 bg-yellow-200/40 hp-particle-spiral','2.5s'],
        ['top-[192rem] left-1/3','w-1 h-1 bg-yellow-300/80 hp-particle','3.5s'],
        ['top-[200rem] right-16','w-2.5 h-2.5 bg-amber-400/60 hp-particle-slow','0.5s'],
        ['top-[208rem] left-20','w-1.5 h-1.5 bg-yellow-400/50 hp-particle-reverse','2.5s'],
        ['top-[216rem] right-12','w-2 h-2 bg-amber-500/70 hp-particle-spiral','3.5s'],
        ['top-[224rem] left-16','w-1 h-1 bg-yellow-200/40 hp-particle','4.5s'],
    ] as [$pos, $style, $delay])
        <div class="absolute {{ $pos }} {{ $style }} rounded-full blur-[1px]" 
             style="animation-delay: {{ $delay }}"></div>
    @endforeach

    {{-- Subtle vignette for cinematic depth --}}
    <div class="absolute inset-0 bg-gradient-to-r from-black/20 via-transparent to-black/20"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black/10"></div>
</div>
