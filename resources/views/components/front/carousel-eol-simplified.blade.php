<div class="flex overflow-x-hidden w-full rounded-t-xl"  x-data="{
    medias: {{$medias}},
    currentSlideIndex: 1,
    previous() {
        if (this.currentSlideIndex > 1) {
            this.currentSlideIndex = this.currentSlideIndex - 1
        } else {
            // If it's the first media, go to the last media
            this.currentSlideIndex = this.medias.length
        }
    },
    next() {
        if (this.currentSlideIndex < this.medias.length) {
            this.currentSlideIndex = this.currentSlideIndex + 1
        } else {
            // If it's the last media, go to the first media
            this.currentSlideIndex = 1
        }
    }, 
    }">
{{-- nav Left --}}
<div class="relative">
    <div class="absolute top-[50%] transform translate-y-[-50%] cursor-pointer z-10" x-on:click="previous();">
        <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g filter="url(#filter0_d_2400_38252)">
            <path d="M30 50C18.9543 50 10 41.0457 10 30C10 18.9543 18.9543 10 30 10C41.0457 10 50 18.9543 50 30C50 41.0457 41.0457 50 30 50Z" fill="white"/>
            </g>
            <path d="M33.6367 20.9092L24.5458 30.0001L33.6367 39.091" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <defs>
            <filter id="filter0_d_2400_38252" x="0" y="0" width="60" height="60" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
            <feOffset/>
            <feGaussianBlur stdDeviation="5"/>
            <feComposite in2="hardAlpha" operator="out"/>
            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2400_38252"/>
            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2400_38252" result="shape"/>
            </filter>
            </defs>
        </svg>
    </div>
</div>

<div class="flex flex-col w-full">
    {{-- <div class="relative w-full">
        {{-- modal zoom
        <div class="absolute right-0 cursor-pointer z-10">
            <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg" x-on:click.prevent="$dispatch('open-modal', 'full_screen_carousel');">
                <g filter="url(#filter0_d_2366_32955)">
                <rect x="10" y="10" width="40" height="40" rx="12" fill="white" shape-rendering="crispEdges"/>
                <path d="M17.5 35.6816V42.4998M17.5 42.4998H24.3182M17.5 42.4998L26.5909 33.4092M35.6818 42.4998H42.5M42.5 42.4998V35.6816M42.5 42.4998L33.4091 33.4092M17.5 24.3182V17.5M17.5 17.5H24.3182M17.5 17.5L26.5909 26.5909M35.6818 17.5H42.5M42.5 17.5V24.3182M42.5 17.5L33.4091 26.5909" stroke="#0E1954" stroke-linecap="round" stroke-linejoin="round"/>
                </g>
                <defs>
                <filter id="filter0_d_2366_32955" x="0" y="0" width="60" height="60" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                <feOffset/>
                <feGaussianBlur stdDeviation="5"/>
                <feComposite in2="hardAlpha" operator="out"/>
                <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
                <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2366_32955"/>
                <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2366_32955" result="shape"/>
                </filter>
                </defs>
            </svg>
        </div>
    </div> --}}

    <div class="flex flex-row w-full max-w-[870px] aspect-[100/61] relative">
        <template x-for="(media, index) in medias">
            <div>
                <template x-if="media.type === 'video'">
                    <div x-show="currentSlideIndex == index + 1" class="absolute inset-0 max-w-[870px] aspect-[100/61]" x-transition.opacity.duration.1000ms>
                        <iframe class="absolute w-full inset-0 max-w-[870px] aspect-[100/61]"
                        x-bind:src="media.url + (media.url.includes('?') ? '&' : '?') + 'rel=0'"
                        title="Chiots et chatons, trois mois pour devenir grand" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                </template>
                <template x-if="media.type === 'image'">
                    <div x-show="currentSlideIndex == index + 1" class="absolute inset-0 max-w-[870px] aspect-[100/61]" x-transition.opacity.duration.1000ms>
                        <img class="absolute w-full inset-0 object-cover text-on-surface dark:text-on-surface-dark max-w-[870px] aspect-[100/61]" x-bind:src="media.url" x-bind:alt="media.url" />
                    </div>
                </template>
            </div>
        </template>
    </div>

    <div class="relative w-full">
        <div class="absolute left-[50%] transform translate-x-[-50%] translate-y-[-150%] flex gap-x-4 z-10">
            <template x-for="(media, index) in medias">
                <button class="w-[12px] h-[12px] bg-white cursor-pointer rounded-full" x-on:click="currentSlideIndex = index + 1" x-bind:class="[currentSlideIndex === index + 1 ? 'opacity-100' : 'opacity-75']" x-bind:aria-label="'media ' + (index + 1)"></button>
            </template>
        </div>
    </div>
</div>

<div class="relative">
    {{-- nav Right --}}
    <div class="absolute top-[50%] transform translate-y-[-50%] translate-x-[-100%] cursor-pointer z-10" x-on:click="next()">
        <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g filter="url(#filter0_d_2400_38251)">
            <path d="M30 50C41.0457 50 50 41.0457 50 30C50 18.9543 41.0457 10 30 10C18.9543 10 10 18.9543 10 30C10 41.0457 18.9543 50 30 50Z" fill="white"/>
            </g>
            <path d="M26.3633 20.9092L35.4542 30.0001L26.3633 39.091" stroke="#0E1954" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <defs>
            <filter id="filter0_d_2400_38251" x="0" y="0" width="60" height="60" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
            <feOffset/>
            <feGaussianBlur stdDeviation="5"/>
            <feComposite in2="hardAlpha" operator="out"/>
            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2400_38251"/>
            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2400_38251" result="shape"/>
            </filter>
            </defs>
        </svg>
    </div>
</div>
</div>