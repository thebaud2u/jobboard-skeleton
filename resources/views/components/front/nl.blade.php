{{-- NL inscription --}}
<div class="w-full flex justify-center p-8 lg:py-16">
	<div class="lg:min-h-[338px] w-full max-w-[1200px] rounded-3xl {{ $bgcolor ?? 'bg-jobboard-orange' }}  flex flex-row max-lg:justify-center p-4 sm:p-6 md:py-12 md:px-14">
		<div class="flex-1 flex max-lg:justify-center">
			<div class="flex flex-col text-jobboard-deepblue max-w-[450px]">
				<h4 class="s:text-[40px] text-[25px] leading-tight font-semibold mb-6 s:mb-0 max-s:text-center">
					{{ __('Join our community') }}
				</h4>

				<p class="text-base mb-6 hidden s:block mt-4">
					{{ __('and stay informed about news and the best advice for adopting or caring for your animals.') }}
				</p>

				<form method="POST" action="{{ route('newsletter.subscribe') }}" class="rounded-full bg-white p-2 flex justify-between items-center w-full text-base">
					 @csrf

					<input type="hidden" name="optins[]" value="OPTIN_NL_ADOPTANT">
					<input type="text" name="email" id="email" value="{{ old('email') }}" required placeholder="Votre adresse email" class="border-0 rounded-full text-jobboard-deepblue focus:ring-0 focus:outline-none focus:border-none placeholder:text-jobboard-deepblue w-2/3">

					<button type="submit" class="font-semibold mr-4 hidden s:block w-[102px]">
						{{ __('I\'m signing up') }}
					</button>

					<svg class="block s:hidden mr-4 w-[35px] max-xs:w-[20px]" viewBox="0 0 35 18" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M26.5 16.2144L34 8.71436L26.5 1.21436" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
						<path d="M34 8.71436H1" stroke="#0E1954" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</form>
			</div>
		</div>

		<div class="flex-1 max-lg:hidden">
			<div class="relative w-full">
				<div class="absolute md:w-[447px] md:h-[386px] -top-[94px] left-[25px]">
					<img src="{{ asset('/storage/home_nl.png') }}" alt="" class="w-full">
				</div>
			</div>
		</div>
	</div>
</div>
{{-- End NL inscription --}}
