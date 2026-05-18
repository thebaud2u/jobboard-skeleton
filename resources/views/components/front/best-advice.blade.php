<div class="flex justify-center w-full bg-breeder-cream pb-20 pt-12">
    <div class="flex flex-col items-center gap-y-8 w-full max-w-[1200px]">
        <h3 class="font-semibold text-breeder-deepblue text-[25px] sm:text-[40px] text-center">
            {{ __('All our advices') }}
        </h3>
        <div class="flex max-w-[1200px] w-full justify-center items-center relative px-4" x-data="{
            canScrollLeft: false,
            canScrollRight: false,

            init() {
                this.$nextTick(() => this.updateArrows());
            },

            updateArrows() {
                const el = this.$refs.scrollable;
                if (!el) return;

                const tolerance = 5;
                this.canScrollLeft = el.scrollLeft > tolerance;
                this.canScrollRight = (el.scrollLeft + el.clientWidth) < (el.scrollWidth - tolerance);
            }
        }" x-init="init">
            {{-- Chevron gauche --}}
            <div x-show="canScrollLeft" @click="$refs.scrollable.scrollBy({ left: -300, behavior: 'smooth' }); updateArrows()" class="mr-10 cursor-pointer absolute z-20 left-[15px] rounded-l-md h-[339px] flex items-center bg-gradient-to-l from-transparent to-breeder-cream">
                <svg width="101" height="101" viewBox="0 0 101 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g filter="url(#filter0_d_5245_39654)">
                    <path d="M50.5 81C33.6553 81 20 67.3447 20 50.5C20 33.6553 33.6553 20 50.5 20C67.3447 20 81 33.6553 81 50.5C81 67.3447 67.3447 81 50.5 81Z" fill="#F7F6EF"></path>
                    </g>
                    <path d="M56.0454 36.6364L42.1818 50.5L56.0454 64.3636" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    <defs>
                    <filter id="filter0_d_5245_39654" x="0" y="0" width="101" height="101" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                    <feOffset></feOffset>
                    <feGaussianBlur stdDeviation="10"></feGaussianBlur>
                    <feComposite in2="hardAlpha" operator="out"></feComposite>
                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0"></feColorMatrix>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_5245_39654"></feBlend>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_5245_39654" result="shape"></feBlend>
                    </filter>
                    </defs>
                </svg>
            </div>

            <div x-ref="scrollable" @scroll="updateArrows" class="flex items-stretch flex-row gap-x-4 w-full max-w-[1200px] overflow-x-auto overflow-y-visible scrollbar-none py-12 -my-12">
                <a href="{{ route('article.index', ['arg1' => 'nutrition']) }}"  class="group overflow-visible">
                    <div class="flex flex-col w-[200px] h-[278px] overflow-visible rounded-md">
                        <div class="relative bg-breeder-coral w-full h-[155px] rounded-t-md group-hover:bg-breeder-coralhover">
                            <div class="absolute w-[173px] h-[168px] left-[18px] -top-[13px]">
                                <img src="{{ asset('/storage/advice_nutrition.png') }}" alt="" class="w-full" />
                            </div>
                        </div>

                        <div class="w-full flex flex-col items-center justify-between text-breeder-deepblue bg-white rounded-b-md py-3 px-2 h-[104px]">
                            <h4 class="text-[18px] font-bold text-center">
                                {{ __('Nutrition') }}
                            </h4>

                            <svg width="36" height="17" viewBox="0 0 36 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M27 16L34.5 8.5L27 1" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M34.5 8.5H1.5" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>
                </a>

                <a href="{{ route('article.index', ['arg1' => 'sante']) }}" class="group overflow-visible">
                    <div class="flex flex-col w-[200px] h-[278px] overflow-visible rounded-md">
                        <div class="relative bg-breeder-coral w-full h-[155px] rounded-t-md group-hover:bg-breeder-coralhover overflow-visible">
                            <div class="overflow-y-visible absolute w-[203px] h-[174px] left-0 -top-[15px]">
                                <img src="{{ asset('/storage/home_dog_advice_1.png') }}" alt="" class="w-full" />
                            </div>
                        </div>

                        <div class="w-full flex flex-col items-center justify-between text-breeder-deepblue bg-white rounded-b-md py-3 px-2 h-[104px]">
                            <h4 class="text-[18px] font-bold text-center">
                                {{ __('Health') }}
                            </h4>

                            <svg width="36" height="17" viewBox="0 0 36 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M27 16L34.5 8.5L27 1" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M34.5 8.5H1.5" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>
                </a>

                <a href="{{ route('article.index', ['arg1' => 'conseils-entretien']) }}" class="group overflow-visible">
                    <div class="flex flex-col w-[200px] h-[278px] overflow-visible rounded-md">
                        <div class="relative bg-breeder-coral w-full h-[155px] rounded-t-md group-hover:bg-breeder-coralhover overflow-visible">
                            <div class="overflow-y-visible absolute w-[199px] h-[174px] left-0 -top-[19px]">
                                <img src="{{ asset('/storage/advice_conseils_entretien.png') }}" alt="" class="w-full" />
                            </div>
                        </div>

                        <div class="w-full flex flex-col items-center justify-between text-breeder-deepblue bg-white rounded-b-md py-3 px-2 h-[104px]">
                            <h4 class="text-[18px] font-bold text-center">
                                {{ __('Conseils & entretien') }}
                            </h4>

                            <svg width="36" height="17" viewBox="0 0 36 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M27 16L34.5 8.5L27 1" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M34.5 8.5H1.5" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>
                </a>

                <a href="{{ route('article.index', ['arg1' => 'education-comportement']) }}"  class="group overflow-visible">
                    <div class="flex flex-col w-[200px] h-[278px] overflow-visible rounded-md">
                        <div class="relative bg-breeder-coral w-full h-[155px] rounded-t-md group-hover:bg-breeder-coralhover">
                            <div class="absolute w-[158px] h-[175px] left-[23px] -top-[18px]">
                                <img src="{{ asset('/storage/home_dog_advice_2.png') }}" alt="" class="w-full" />
                            </div>
                        </div>

                        <div class="w-full flex flex-col items-center justify-between text-breeder-deepblue bg-white rounded-b-md py-3 px-2 h-[104px]">
                            <h4 class="text-[18px] font-bold text-center">
                                {{ __('Éducation & comportement') }}
                            </h4>

                            <svg width="36" height="17" viewBox="0 0 36 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M27 16L34.5 8.5L27 1" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M34.5 8.5H1.5" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>
                </a>

                <a href="{{ route('article.index', ['arg1' => 'reproduction-genetique']) }}"  class="group overflow-visible">
                    <div class="flex flex-col w-[200px] h-[278px] overflow-visible rounded-md">
                        <div class="relative bg-breeder-violet w-full h-[155px] rounded-t-md group-hover:bg-breeder-violethover">
                            <div class="absolute w-[208px] h-[178px] -left-[9px] -top-[15px]">
                                <img src="{{ asset('/storage/advice_reproduction_genetique.png') }}" alt="" class="w-full">
                            </div>
                        </div>

                        <div class="w-full flex flex-col items-center justify-between text-breeder-deepblue bg-white rounded-b-md py-3 px-2 h-[104px]">
                            <h4 class="text-[18px] font-bold text-center">
                                {{ __('Reproduction & génétique') }}
                            </h4>

                            <svg width="36" height="17" viewBox="0 0 36 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M27 16L34.5 8.5L27 1" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M34.5 8.5H1.5" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>
                </a>

                <a href="{{ route('article.index', ['arg1' => 'prevention']) }}"  class="group overflow-visible">
                    <div class="flex flex-col w-[200px] h-[278px] overflow-visible rounded-md">
                        <div class="relative bg-breeder-violet w-full h-[155px] rounded-t-md group-hover:bg-breeder-violethover">
                            <div class="absolute w-[200px] h-[174px] left-0 -top-[19px]">
                                <img src="{{ asset('/storage/advice_prevention.png') }}" alt="" class="w-full">
                            </div>
                        </div>

                        <div class="w-full flex flex-col items-center justify-between text-breeder-deepblue bg-white rounded-b-md py-3 px-2 h-[104px]">
                            <h4 class="text-[18px] font-bold text-center">
                                {{ __('Prévention') }}
                            </h4>

                            <svg width="36" height="17" viewBox="0 0 36 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M27 16L34.5 8.5L27 1" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M34.5 8.5H1.5" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>
                </a>

                <a href="{{ route('article.index', ['arg1' => 'gestion-elevage']) }}"  class="group overflow-visible">
                    <div class="flex flex-col w-[200px] h-[278px] overflow-visible rounded-md">
                        <div class="relative bg-breeder-violet w-full h-[155px] rounded-t-md group-hover:bg-breeder-violethover">
                            <div class="absolute w-[117px] h-[174px] left-[51px] -top-[19px]">
                                <img src="{{ asset('/storage/advice_gestion_elevage.png') }}" alt="" class="w-full">
                            </div>
                        </div>

                        <div class="w-full flex flex-col items-center justify-between text-breeder-deepblue bg-white rounded-b-md py-3 px-2 h-[104px]">
                            <h4 class="text-[18px] font-bold text-center">
                                {{ __('Gestion d\'entreprise') }}
                            </h4>

                            <svg width="36" height="17" viewBox="0 0 36 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M27 16L34.5 8.5L27 1" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M34.5 8.5H1.5" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>
                </a>

                <a href="{{ route('article.index', ['arg1' => 'legislation']) }}"  class="group overflow-visible">
                    <div class="flex flex-col w-[200px] h-[278px] overflow-visible rounded-md">
                        <div class="relative bg-breeder-violet w-full h-[155px] rounded-t-md group-hover:bg-breeder-violethover">
                            <div class="absolute w-[187px] h-[172px] -left-[10px] -top-[17px]">
                                <img src="{{ asset('/storage/advice_legisaltion.png') }}" alt="" class="w-full">
                            </div>
                        </div>

                        <div class="w-full flex flex-col items-center justify-between text-breeder-deepblue bg-white rounded-b-md py-3 px-2 h-[104px]">
                            <h4 class="text-[18px] font-bold text-center">
                                {{ __('Législation') }}
                            </h4>

                            <svg width="36" height="17" viewBox="0 0 36 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M27 16L34.5 8.5L27 1" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M34.5 8.5H1.5" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>
                </a>

                <a href="{{ route('article.index', ['arg1' => 'produits']) }}"  class="group overflow-visible">
                    <div class="flex flex-col w-[200px] h-[278px] overflow-visible rounded-md">
                        <div class="relative bg-breeder-orange w-full h-[155px] rounded-t-md group-hover:bg-breeder-darkorange">
                            <div class="absolute w-[200px] h-[108px] -left-[3px] top-[47px]">
                                <img src="{{ asset('/storage/advice_produits.png') }}" alt="" class="w-full">
                            </div>
                        </div>

                        <div class="w-full flex flex-col items-center justify-between text-breeder-deepblue bg-white rounded-b-md py-3 px-2 h-[104px]">
                            <h4 class="text-[18px] font-bold text-center">
                                {{ __('Produits') }}
                            </h4>

                            <svg width="36" height="17" viewBox="0 0 36 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M27 16L34.5 8.5L27 1" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M34.5 8.5H1.5" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>
                </a>

                <a href="{{ route('article.index', ['arg1' => 'marches-entreprises']) }}"  class="group overflow-visible">
                    <div class="flex flex-col w-[200px] h-[278px] overflow-visible rounded-md">
                        <div class="relative bg-breeder-orange w-full h-[155px] rounded-t-md group-hover:bg-breeder-darkorange">
                            <div class="absolute w-[143px] h-[195px] left-[29px] -top-[40px]">
                                <img src="{{ asset('/storage/advice_marches_entreprises.png') }}" alt="" class="w-full">
                            </div>
                        </div>

                        <div class="w-full flex flex-col items-center justify-between text-breeder-deepblue bg-white rounded-b-md py-3 px-2 h-[104px]">
                            <h4 class="text-[18px] font-bold text-center">
                                {{ __('Marchés & entreprises') }}
                            </h4>

                            <svg width="36" height="17" viewBox="0 0 36 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M27 16L34.5 8.5L27 1" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M34.5 8.5H1.5" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>
                </a>
                <a href="{{ route('article.index', ['arg1' => 'agenda']) }}"  class="group overflow-visible">
                    <div class="flex flex-col w-[200px] h-[278px] overflow-visible rounded-md">
                        <div class="relative bg-breeder-orange w-full h-[155px] rounded-t-md group-hover:bg-breeder-darkorange">
                            <div class="absolute w-[200px] h-[212px] left-0 -top-[57px]">
                                <img src="{{ asset('/storage/advice_agenda.png') }}" alt="" class="w-full">
                            </div>
                        </div>

                        <div class="w-full flex flex-col items-center justify-between text-breeder-deepblue bg-white rounded-b-md py-3 px-2 h-[104px]">
                            <h4 class="text-[18px] font-bold text-center">
                                {{ __('Agenda') }}
                            </h4>

                            <svg width="36" height="17" viewBox="0 0 36 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M27 16L34.5 8.5L27 1" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M34.5 8.5H1.5" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>
                </a>

                <a href="{{ route('article.index', ['arg1' => 'inspiration']) }}"  class="group overflow-visible">
                    <div class="flex flex-col w-[200px] h-[278px] overflow-visible rounded-md">
                        <div class="relative bg-breeder-orange w-full h-[155px] rounded-t-md group-hover:bg-breeder-darkorange">
                            <div class="absolute w-[181px] h-[185px] left-[5px] -top-[30px]">
                                <img src="{{ asset('/storage/advice_inspiration.png') }}" alt="" class="w-full">
                            </div>
                        </div>

                        <div class="w-full flex flex-col items-center justify-between text-breeder-deepblue bg-white rounded-b-md py-3 px-2 h-[104px]">
                            <h4 class="text-[18px] font-bold text-center">
                                {{ __('Inspiration') }}
                            </h4>

                            <svg width="36" height="17" viewBox="0 0 36 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M27 16L34.5 8.5L27 1" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M34.5 8.5H1.5" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Chevron droit --}}
            <div x-show="canScrollRight" @click="$refs.scrollable.scrollBy({ left: 300, behavior: 'smooth' }); updateArrows()" class="ml-10 cursor-pointer absolute z-20 right-[15px] h-[339px] flex items-center bg-gradient-to-r from-transparent to-breeder-cream">
                <svg width="101" height="101" viewBox="0 0 101 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g filter="url(#filter0_d_2188_51292)">
                    <path d="M50.5 81C67.3447 81 81 67.3447 81 50.5C81 33.6553 67.3447 20 50.5 20C33.6553 20 20 33.6553 20 50.5C20 67.3447 33.6553 81 50.5 81Z" fill="#F7F6EF"></path>
                    </g>
                    <path d="M44.9546 36.6364L58.8182 50.5L44.9546 64.3636" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    <defs>
                    <filter id="filter0_d_2188_51292" x="0" y="0" width="101" height="101" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                    <feOffset></feOffset>
                    <feGaussianBlur stdDeviation="10"></feGaussianBlur>
                    <feComposite in2="hardAlpha" operator="out"></feComposite>
                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0"></feColorMatrix>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2188_51292"></feBlend>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2188_51292" result="shape"></feBlend>
                    </filter>
                    </defs>
                </svg>
            </div>
        </div>
    </div>
</div>