<div class="mx-auto max-w-[1200px] w-full flex flex-col md:flex-row items-center max-md:gap-y-4 rounded-md bg-breeder-violet justify-between px-8 lg:px-20 max-lg:py-8 my-2 md:my-10 lg:my-20">
	<div class="flex items-center gap-x-8">
		<div class="relative w-[120px] md:h-[122px] max-lg:hidden">
			<div class="absolute w-[212px] h-[161px] -right-[16px] bottom-[12px]">
				<img src="{{ asset('/storage/home_breeder_frame_woman.png') }}" alt="">
			</div>
		</div>

		<div class="flex flex-col max-md:items-center text-breeder-deepblue">
			<h6 class="font-semibold text-[20px] sm:text-[28px] max-md:text-center">
				{{ __('Are you a breeder ?') }}
			</h6>

			<p class="text-[20px] sm:text-base max-md:text-center">
				{{ __('Create your post and find a adopter easily !') }}
			</p>
		</div>
	</div>

	<div class="flex justify-center min-w-[225px]">
		<a href="{{ route('space.posts.show-offers') }}" class="flex justify-center items-center gap-x-1 rounded-full text-breeder-cream text-sm font-semibold bg-breeder-deepblue hover:bg-breeder-deepbluehover py-4 px-6">
			{{ __('I create my post') }}

			<svg width="11" height="13" viewBox="0 0 11 13" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M2.36237 1.5L7.81691 6.5L2.36237 11.5" stroke="#F7F6EF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
			</svg>
		</a>
	</div>
</div>
