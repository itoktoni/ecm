@php
    $cards = $data['certifications'] ?? [];
@endphp

<section class="py-24 bg-surface-container-low">
    <div class="max-w-7xl mx-auto px-8">
        <div class="text-center mb-16">
            <h2 class="font-headline-lg text-headline-lg text-on-surface">Standar Kualitas Kami</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($cards as $card)
                <div class="glass-card p-8 rounded-xl flex flex-col items-center text-center group hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                    <div class="absolute inset-0 gold-shimmer opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="mb-6 relative w-full aspect-[4/3] overflow-hidden rounded-xl bg-white border border-outline-variant/30">
                        @if(!empty($card['image']))
                            <img class="w-full h-full object-cover object-center cert-popup-img cursor-zoom-in hover:opacity-90 transition-opacity" data-alt="{{ $card['text'] ?? '' }}" src="{{ $card['image'] }}" title="Klik untuk memperbesar" />
                        @endif
                    </div>
                    <h3 class="font-headline-md text-headline-md mb-2">{{ $card['text'] ?? '' }}</h3>
                    <p class="text-on-surface-variant font-body-md">{{ $card['description'] ?? '' }}</p>
                    @if(!empty($card['link_text']))
                        <div class="mt-6 text-secondary-container flex items-center gap-2 font-label-md">
                            {{ $card['link_text'] }} <span class="material-symbols-outlined text-sm">open_in_new</span>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Lightbox Popup untuk image sertifikasi --}}
<div id="certLightbox" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/80 backdrop-blur-sm p-4 md:p-8" onclick="closeCertLightbox(event)">
    <button type="button" onclick="closeCertLightbox(event)" class="absolute top-4 right-4 text-white hover:text-white/80 bg-white/10 hover:bg-white/20 rounded-full p-2 transition-colors" aria-label="Close">
        <span class="material-symbols-outlined">close</span>
    </button>
    <img id="certLightboxImg" src="" alt="" class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl bg-white p-1" onclick="event.stopPropagation()" />
</div>
<script>
(function() {
    document.querySelectorAll('.cert-popup-img').forEach(function(img) {
        img.addEventListener('click', function() {
            var src = this.getAttribute('src');
            var alt = this.getAttribute('data-alt') || this.alt || '';
            var lbImg = document.getElementById('certLightboxImg');
            var lb = document.getElementById('certLightbox');
            if (!lbImg || !lb) return;
            lbImg.src = src;
            lbImg.alt = alt;
            lb.classList.remove('hidden');
            lb.classList.add('flex');
            document.body.style.overflow = 'hidden';
        });
    });
    window.closeCertLightbox = function(e) {
        if (e) {
            // only close if clicking backdrop or close button
            if (e.target.id !== 'certLightbox' && !e.target.closest('button')) return;
        }
        var lb = document.getElementById('certLightbox');
        if (!lb) return;
        lb.classList.add('hidden');
        lb.classList.remove('flex');
        document.body.style.overflow = '';
    };
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            var lb = document.getElementById('certLightbox');
            if (lb && !lb.classList.contains('hidden')) {
                lb.classList.add('hidden');
                lb.classList.remove('flex');
                document.body.style.overflow = '';
            }
        }
    });
})();
</script>
