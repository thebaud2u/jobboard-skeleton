<div>
	<div x-data="{}" x-init="$nextTick(() => { $dispatch('open-modal', 'complete_my_profile') })">
		<x-front.modal name="complete_my_profile" :class="'w-full max-w-[600px]'" focusable>
			<x-front.form-part-title :class="'mb-4'">
				{{ __('Welcome') }} !
			</x-front.form-part-title>

			<div class="flex flex-row text-jobboard-deepblue text-base font-medium">
				@if($user->hasRole('adopter'))
					{{ __('To personalize your experience and provide you with the services that interest you, tell us more about yourself.') }}
				@elseif($user->hasRole(['breeder', 'professionnal_breeder', 'individual_breeder']))
					{{ __('Fill now your profile to publish your ads and be referenced among all our breeders.') }}
				@endif
			</div>

			<div class="flex flex-row mt-4 text-jobboard-deepblue text-base font-medium">
				@if($user->hasRole('adopter'))
					{{ __('I\'m interested by :') }}
				@elseif($user->hasRole(['breeder', 'professionnal_breeder', 'individual_breeder']))
					{{ __('I\'m raising :') }}
				@elseif($user->hasRole('professionnal'))
					{{ __('Complete your profile right now to get access to publish your offers') }}
				@endif
			</div>

			@if($user->hasRole(['adopter', 'breeder', 'professionnal_breeder', 'individual_breeder']))
				<div class="flex flex-col max-sm:items-center gap-y-4 sm:flex-row sm:justify-between mt-4 text-jobboard-deepblue">
					<div class="flex flex-col items-center justify-center">
						<input type="radio" name="interestedIn" value="dogs" id="dogs" wire:model="interestedIn"
							class="peer hidden" />
						<label for="dogs"
							class="block cursor-pointer border border-jobboard-greige rounded-xl hover:bg-jobboard-cream peer-checked:bg-jobboard-cream">
							<div>
								<h3
									class="w-[150px] md:w-[170px] h-[150px] md:h-[184px] text-base font-medium flex flex-col items-center justify-center gap-y-4">
									<svg width="48" height="47" viewBox="0 0 48 47" fill="none"
										xmlns="http://www.w3.org/2000/svg">
										<circle cx="9" cy="37" r="8" fill="#FF7E71" />
										<ellipse cx="35.5" cy="8" rx="4.5" ry="5"
											fill="#FF7E71" />
										<path
											d="M34.4217 4.15137C34.4217 4.15137 35.401 6.63682 35.1165 11.8384C35.0675 12.7345 33.2167 12.5414 31.4848 12.0403C29.8629 11.5713 28.3655 10.8672 27.9987 9.53282C27.5085 7.74931 27.6374 4.78708 28.2232 3.34128M37.8833 18.5299C37.6487 15.8259 37.8833 15.0224 38.8471 14.6682C39.8109 14.3139 41.8729 15.0578 44.4775 13.6407C45.9993 12.8129 46.5051 10.9963 46.9108 9.83854C47.1865 9.05052 46.803 8.18525 46.0338 7.84974L41.9886 6.06071C41.9886 6.06071 41.3638 4.68113 40.29 3.32142C39.1117 1.82927 37.2975 0.978346 35.3877 1.00042C29.9474 1.06333 28.1421 2.33254 26.7848 6.12361C26.0967 7.7758 25.5253 9.60236 25.0451 11.2843C24.5382 13.0601 24.1402 15.6703 22.664 17.4295C18.9822 21.8133 8.29614 27.4408 7.94487 38.3627C7.94487 43.8898 11.7911 46 11.7911 46H27.2895C27.7575 46 28.1065 45.5751 28.0176 45.1182C27.6141 43.0499 26.3668 41.5787 24.2047 41.5787H20.5185C20.5185 41.5787 25.0039 36.3308 24.0446 32.021C23.6111 30.0753 22.156 28.9738 21.1499 28.7145M28.9936 26.7521C29.555 30.5443 31.1468 41.2101 31.5615 43.1857C32.0672 45.5972 33.6869 45.9989 33.6869 45.9989H39.0194C39.464 45.9989 39.8053 45.6148 39.7564 45.1756C39.6152 43.9218 38.9705 41.6781 36.158 41.6781L35.3777 27.8845C35.3777 27.8845 36.3259 26.6892 37.1908 24.994C38.1312 23.1498 38.129 21.3563 37.8844 18.5288M5.29252 37.2149C3.38718 35.2514 2.53012 32.2274 1.92539 30.498C1.69306 30.9063 1.46629 31.5354 1.28731 32.3102C-0.228949 38.9001 4.45213 45.3201 10.7162 45.8996L11.79 45.9989M30.2375 35.0285C27.8442 37.8594 25.6076 40.9463 23.8623 41.5776"
											stroke="#0E1954" stroke-width="2" stroke-linecap="round"
											stroke-linejoin="round" />
									</svg>

									{{ __('dogs') }}
								</h3>
							</div>
						</label>
					</div>

					<div class="flex flex-col items-center justify-center">
						<input type="radio" name="interestedIn" value="cats" id="cats"
							wire:model="interestedIn" class="peer hidden" />
						<label for="cats"
							class="block cursor-pointer border border-jobboard-greige rounded-xl hover:bg-jobboard-cream peer-checked:bg-jobboard-cream">
							<div>
								<h3 class="w-[150px] md:w-[170px] h-[150px] md:h-[184px] text-base font-medium flex flex-col items-center justify-center gap-y-4">
									<svg width="43" height="46" viewBox="0 0 43 46" fill="none" xmlns="http://www.w3.org/2000/svg">
										<circle cx="8" cy="38" r="8" fill="#3DD8AC"/>
										<ellipse cx="34.5" cy="9" rx="4.5" ry="5" fill="#3DD8AC"/>
										<path d="M24.228 40.6197C24.228 40.6197 27.6264 40.0409 28.3541 34.6554C28.7216 32.1248 27.3086 29.5423 27.3086 29.5423M13.2396 44.3372H30.0073C30.3696 44.3372 30.6636 44.042 30.6636 43.6783V43.2106C30.6636 41.7858 29.5021 40.6197 28.0829 40.6197H24.229M28.2724 32.341L30.8365 42.6712C31.0797 43.6502 31.9555 44.3372 32.9596 44.3372H36.8663C37.2286 44.3372 37.5226 44.042 37.5226 43.6783V42.902C37.5226 41.6413 36.5051 40.6197 35.2494 40.6197L34.1583 30.489C34.1583 30.489 36.7742 27.3141 37.444 23.6995C37.9822 20.7917 36.4543 18.7339 37.2545 16.3852C37.6872 15.1163 38.9325 15.1994 39.9884 14.4927C41.0443 13.786 41.9387 11.4186 40.682 10.6069C39.6251 9.92413 39.507 6.72737 37.8984 5.91986C36.2897 5.11236 35.6366 4.79122 35.6366 4.79122C35.6873 2.72206 34.9275 1 34.9275 1C34.9275 1 31.7454 2.67321 28.9711 6.16097C28.2506 7.06617 27.554 8.3403 27.262 9.53025C26.7372 12.0079 27.496 16.9527 24.4226 18.1686C10.4426 23.6975 9.53064 30.4308 10.9002 40.1645M10.9002 40.1635C13.9632 40.1635 16.8948 40.2841 18.0521 40.5553C19.5107 40.8972 19.961 41.7068 19.9662 42.479C19.9703 43.2543 19.5221 43.9921 17.7923 44.1782C16.8721 44.2769 14.5108 44.3382 12.6134 44.3382C6.47896 44.3382 4.95312 43.6793 4.95312 42.0965C4.95312 40.5137 9.46232 39.3602 10.5016 36.4242" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>

									{{ __('cats') }}
								</h3>
							</div>
						</label>
					</div>

					<div class="flex flex-col items-center justify-center">
						<input type="radio" name="interestedIn" value="both" id="both"
							wire:model="interestedIn" class="peer hidden" />
						<label for="both"
							class="block cursor-pointer border border-jobboard-greige rounded-xl hover:bg-jobboard-cream peer-checked:bg-jobboard-cream">
							<div>
								<h3
									class="w-[150px] md:w-[170px] h-[150px] md:h-[184px] text-base font-medium flex flex-col items-center justify-center text-center gap-y-4">
									<svg width="103" height="47" viewBox="0 0 103 47" fill="none"
										xmlns="http://www.w3.org/2000/svg">
										<circle cx="9.03906" cy="37" r="8" fill="#FF7E71" />
										<ellipse cx="35.5391" cy="8" rx="4.5" ry="5"
											fill="#FF7E71" />
										<path
											d="M34.4607 4.15137C34.4607 4.15137 35.4401 6.63682 35.1555 11.8384C35.1066 12.7345 33.2557 12.5414 31.5238 12.0403C29.9019 11.5713 28.4046 10.8672 28.0377 9.53282C27.5475 7.74931 27.6765 4.78708 28.2623 3.34128M37.9224 18.5299C37.6878 15.8259 37.9224 15.0224 38.8861 14.6682C39.8499 14.3139 41.912 15.0578 44.5166 13.6407C46.0384 12.8129 46.5442 10.9963 46.9499 9.83854C47.2256 9.05052 46.8421 8.18525 46.0728 7.84974L42.0276 6.06071C42.0276 6.06071 41.4029 4.68113 40.329 3.32142C39.1507 1.82927 37.3365 0.978346 35.4268 1.00042C29.9864 1.06333 28.1811 2.33254 26.8238 6.12361C26.1357 7.7758 25.5644 9.60236 25.0841 11.2843C24.5772 13.0601 24.1793 15.6703 22.703 17.4295C19.0213 21.8133 8.33521 27.4408 7.98393 38.3627C7.98393 43.8898 11.8302 46 11.8302 46H27.3285C27.7965 46 28.1456 45.5751 28.0566 45.1182C27.6531 43.0499 26.4059 41.5787 24.2437 41.5787H20.5576C20.5576 41.5787 25.043 36.3308 24.0837 32.021C23.6501 30.0753 22.195 28.9738 21.189 28.7145M29.0327 26.7521C29.594 30.5443 31.1859 41.2101 31.6005 43.1857C32.1063 45.5972 33.726 45.9989 33.726 45.9989H39.0584C39.5031 45.9989 39.8444 45.6148 39.7955 45.1756C39.6543 43.9218 39.0095 41.6781 36.1971 41.6781L35.4167 27.8845C35.4167 27.8845 36.365 26.6892 37.2298 24.994C38.1703 23.1498 38.168 21.3563 37.9235 18.5288M5.33158 37.2149C3.42625 35.2514 2.56918 32.2274 1.96445 30.498C1.73212 30.9063 1.50535 31.5354 1.32638 32.3102C-0.189887 38.9001 4.49119 45.3201 10.7552 45.8996L11.8291 45.9989M30.2766 35.0285C27.8832 37.8594 25.6466 40.9463 23.9014 41.5776"
											stroke="#0E1954" stroke-width="2" stroke-linecap="round"
											stroke-linejoin="round" />
										<circle cx="8" cy="8" r="8"
											transform="matrix(-1 0 0 1 102.961 29)" fill="#3DD8AC" />
										<ellipse cx="4.5" cy="5" rx="4.5" ry="5"
											transform="matrix(-1 0 0 1 72.9609 3)" fill="#3DD8AC" />
										<path
											d="M79.1075 40.6197C79.1075 40.6197 75.709 40.0409 74.9813 34.6554C74.6138 32.1248 76.0268 29.5423 76.0268 29.5423M90.0958 44.3372H73.3281C72.9658 44.3372 72.6718 44.042 72.6718 43.6783V43.2106C72.6718 41.7858 73.8333 40.6197 75.2525 40.6197H79.1065M75.0631 32.341L72.499 42.6712C72.2557 43.6502 71.38 44.3372 70.3758 44.3372H66.4691C66.1068 44.3372 65.8128 44.042 65.8128 43.6783V42.902C65.8128 41.6413 66.8304 40.6197 68.0861 40.6197L69.1771 30.489C69.1771 30.489 66.5612 27.3141 65.8915 23.6995C65.3532 20.7917 66.8811 18.7339 66.0809 16.3852C65.6482 15.1163 64.4029 15.1994 63.347 14.4927C62.2912 13.786 61.3968 11.4186 62.6535 10.6069C63.7104 9.92413 63.8284 6.72737 65.4371 5.91986C67.0457 5.11236 67.6989 4.79122 67.6989 4.79122C67.6482 2.72206 68.408 1 68.408 1C68.408 1 71.5901 2.67321 74.3643 6.16097C75.0848 7.06617 75.7815 8.3403 76.0734 9.53025C76.5982 12.0079 75.8395 16.9527 78.9129 18.1686C92.8928 23.6975 93.8048 30.4308 92.4353 40.1645M92.4353 40.1635C89.3722 40.1635 86.4406 40.2841 85.2833 40.5553C83.8247 40.8972 83.3745 41.7068 83.3693 42.479C83.3651 43.2543 83.8134 43.9921 85.5431 44.1782C86.4634 44.2769 88.8246 44.3382 90.7221 44.3382C96.8565 44.3382 98.3823 43.6793 98.3823 42.0965C98.3823 40.5137 93.8731 39.3602 92.8338 36.4242"
											stroke="#0E1954" stroke-width="2" stroke-linecap="round"
											stroke-linejoin="round" />
									</svg>

									{{ __('dogs & cats') }}
								</h3>
							</div>
						</label>
					</div>
				</div>

				@error('interestedIn')
					<span class="error text-danger-700">
						{{ $message }}
					</span>
				@enderror
			@endif

			<div class="flex s:flex-row flex-col items-center max-s:space-y-5 justify-between mt-10">
				<button type="button" wire:click="later" x-data="" x-on:interest-saved.window="$dispatch('close');" class="text-sm font-bold text-jobboard-deepblue hover:underline hover:underline-offset-4">
					{{ __('Later') }}
				</button>

				<x-front.primary-button :class="'ml-4'" wire:click="completeProfile">
					{{ __('I complete my profile') }}

					<svg class="ml-4" width="10" height="13" viewBox="0 0 10 13"
						fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M1.86035 1.5L7.3149 6.5L1.86035 11.5" stroke="#F7F6EF" stroke-width="2"
							stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</x-front.primary-button>
			</div>
		</x-front.modal>
	</div>
</div>
