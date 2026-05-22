{{-- CTA Create post --}}
<div class="flex flex-col md:flex-row w-full">
	<div class="flex-1 flex sm:justify-center bg-jobboard-violet px-8 py-8 md:py-16 w-full">
		<div class="flex flex-col items-start w-full sm:max-w-[340px] lg:max-w-[441px] text-jobboard-deepblue">
			<h3 class="font-semibold text-[25px] md:text-[32px] lg:text-[40px]">
				{{ __('You are breeder') }} ?
			</h3>

			<p class="text-base hidden s:block">
				Portées, étalons ou adultes retraités, diffusez vos annonces et mettez en avant votre entreprise auprès d'adoptants potentiels
			</p>

			<div class="mt-4 w-full">
				<a href="{{ route('home.breeder') }}" class="btn-primary border-jobboard-deepblue">
					 {{ __('Create my post') }}
				</a>
			</div>
		</div>
	</div>

	<div class="flex-1 flex sm:justify-center bg-jobboard-deepblue px-8 py-8 md:py-16 w-full">
		<div class="flex flex-col items-start text-white w-full sm:max-w-[340px] lg:max-w-[520px]">
			<h3 class= "font-semibold text-[25px] md:text-[32px] lg:text-[40px]">
				{{ __('You are professional') }} ?
			</h3>

			<p class="text-base hidden s:block lg:min-h-[72px]">
				{{ __('Boarding kennels, groomers, trainers... Let our community know about your business') }}
			</p>

			<div class="mt-4 w-full">
				<a href="{{ route('home.pro') }}" class="btn-primary">{{ __('Create my post') }}
				</a>
			</div>
		</div>
	</div>
</div>
{{-- END Create post --}}
