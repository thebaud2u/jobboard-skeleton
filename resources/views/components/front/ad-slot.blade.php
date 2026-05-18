@props([
    'slotName' => null,
    'variant' => 'all',
    'targeting' => [],
    'size' => null,
    'class' => 'ad-slot',
])

@php
    $adService = app(\App\Services\GoogleAdManagerService::class);
    // Détection initiale côté serveur
    $adConfig = $adService->getAdSlotConfig($slotName, $variant, $targeting);
    $divId = $adConfig['div_id'];
    $sizes = $size ? json_encode(is_array($size) ? $size : [$size]) : json_encode($adConfig['sizes']);
    $path = $adConfig['path'];
    $targetingData = json_encode($adConfig['targeting']);
@endphp

<div id="{{ $divId }}" class="{{ $class }} ad-slot"></div>

@push('scripts')
<script>
    googletag = window.googletag || { cmd: [] };
    googletag.cmd.push(function() {
        var isMobile = window.innerWidth <= 768;
        var slotConfig = {
            path: '{{ $path }}',
            sizes: {!! $sizes !!},
            divId: '{{ $divId }}',
            targeting: {!! $targetingData !!}
        };

        // Ajustement si détection serveur/client diffère
        if (isMobile && '{{ $adConfig['targeting']['device'] }}' === 'desktop') {
            slotConfig = {
                path: '{{ $adService->getAdSlotConfig($slotName, $variant, $targeting, 'mobile')['path'] }}',
                sizes: {!! json_encode($adService->getAdSlotConfig($slotName, $variant, $targeting, 'mobile')['sizes']) !!},
                divId: '{{ $adService->getAdSlotConfig($slotName, $variant, $targeting, 'mobile')['div_id'] }}',
                targeting: {!! json_encode($adService->getAdSlotConfig($slotName, $variant, $targeting, 'mobile')['targeting']) !!}
            };
            document.getElementById('{{ $divId }}').id = slotConfig.divId;
        } else if (!isMobile && '{{ $adConfig['targeting']['device'] }}' === 'mobile') {
            slotConfig = {
                path: '{{ $adService->getAdSlotConfig($slotName, $variant, $targeting, 'desktop')['path'] }}',
                sizes: {!! json_encode($adService->getAdSlotConfig($slotName, $variant, $targeting, 'desktop')['sizes']) !!},
                divId: '{{ $adService->getAdSlotConfig($slotName, $variant, $targeting, 'desktop')['div_id'] }}',
                targeting: {!! json_encode($adService->getAdSlotConfig($slotName, $variant, $targeting, 'desktop')['targeting']) !!}
            };
            document.getElementById('{{ $divId }}').id = slotConfig.divId;
        }

        var slot = googletag.defineSlot(slotConfig.path, slotConfig.sizes, slotConfig.divId)
            .addService(googletag.pubads());

        for (var key in slotConfig.targeting) {
            if (slotConfig.targeting.hasOwnProperty(key)) {
                slot.setTargeting(key, slotConfig.targeting[key]);
            }
        }

        googletag.enableServices();
        googletag.display(slotConfig.divId);
    });
</script>
@endpush