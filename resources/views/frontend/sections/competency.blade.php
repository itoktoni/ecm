@php
    $slides = $data['competency'] ?? [];
@endphp

<section class="py-32 bg-background">
    <div class="max-w-7xl mx-auto px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-8">
            <div class="max-w-2xl">
                <h2 class="font-headline-lg text-headline-lg text-on-surface mb-4">Keunggulan <span class="text-primary italic">Teknis Kami</span></h2>
                <p class="text-on-surface-variant text-body-lg">Lebih dari sekadar kalibrasi, kami menyediakan jaminan teknis menyeluruh untuk lingkungan medis paling kritis.</p>
            </div>
            <div class="cmp-nav shrink-0">
                <button class="cmp-btn cmp-prev" aria-label="Prev"><span class="material-symbols-outlined text-on-surface">chevron_left</span></button>
                <button class="cmp-btn cmp-next" aria-label="Next"><span class="material-symbols-outlined text-on-surface">chevron_right</span></button>
            </div>
        </div>
        {{-- Swiper untuk competency - fix kepotong jika 5 gambar --}}
        <div class="swiper cmpSwiper">
            <div class="swiper-wrapper">
                @foreach($slides as $slide)
                    <div class="swiper-slide !h-auto">
                        <div class="group rounded-2xl overflow-hidden bg-white shadow-sm border border-outline-variant/30 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 h-full">
                            <div class="h-48 overflow-hidden relative bg-surface-container-low">
                                @if(!empty($slide['image']))
                                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                        data-alt="{{ $slide['title'] ?? '' }}"
                                        src="{{ $slide['image'] }}" loading="lazy" onerror="this.style.display='none'" />
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-outline-variant">
                                        <span class="material-symbols-outlined text-5xl">image</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-6">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-10 h-10 rounded-lg bg-primary-container/10 flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">{{ $slide['icon'] ?? '' }}</span>
                                    </div>
                                    <h4 class="font-headline-md text-headline-md group-hover:text-primary transition-colors">{{ $slide['title'] ?? '' }}</h4>
                                </div>
                                <p class="text-on-surface-variant text-sm">{{ $slide['description'] ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="cmp-dots swiper-pagination !static mt-6 flex justify-center"></div>
    </div>
</section>
