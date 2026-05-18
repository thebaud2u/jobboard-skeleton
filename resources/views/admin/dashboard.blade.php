@extends('admin.layouts.app')

@section('body')
	<h1 class="text-gray-700 text-3xl font-medium">{{ __('Dashboard') }}</h1>

	<div class="mt-4">
		<div class="flex flex-wrap gap-y-4">
			<div class="px-6 sm:w-1/2 xl:w-1/3 sm:mt-0">
				<a href="{{ route('admin.posts.index') }}">
					<div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white">
						<button type="button" class="text-white bg-gradient-to-r from-purple-500 to-pink-500 hover:bg-gradient-to-l focus:ring-4 focus:outline-none focus:ring-purple-200 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-3 py-2.5 text-center mr-2 mb-2">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"class="size-6">
								<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
							</svg>
						</button>

						<div class="mx-5">
							<h4 class="text-2xl font-semibold text-gray-700">
								{{ $countPosts }}
							</h4>

							<div class="text-gray-500">
								{{ __('Currently published posts') }}
							</div>
						</div>
					</div>
				</a>
			</div>

			<div class="px-6 sm:w-1/2 xl:w-1/3 xl:mt-0">
				<div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white">
					<button type="button" class="text-gray-900 bg-gradient-to-r from-teal-200 to-lime-200 hover:bg-gradient-to-l hover:from-teal-200 hover:to-lime-200 focus:ring-4 focus:outline-none focus:ring-lime-200 dark:focus:ring-teal-700 font-medium rounded-lg text-sm px-3 py-2.5 text-center mr-2 mb-2">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"class="size-6">
							<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
						</svg>
					</button>

					<div class="mx-5">
						<h4 class="text-2xl font-semibold text-gray-700">
							{{ $countUsers }}
						</h4>

						<div class="text-gray-500">
							{{ __('Users') }}
						</div>
					</div>
				</div>
			</div>

			<div class="px-6 sm:w-1/2 xl:w-1/3 xl:mt-0">
				<a href="{{ route('admin.moderations.index') }}">
					<div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white">
						<button type="button" class="text-gray-900 bg-gradient-to-r from-red-200 via-red-300 to-yellow-200 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-red-100 dark:focus:ring-red-400 font-medium rounded-lg text-sm px-3 py-2.5 text-center me-2 mb-2">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
								<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
							</svg>
						</button>

						<div class="mx-5">
							<h4 class="text-2xl font-semibold text-gray-700">
								{{ $countModerations }}
							</h4>

							<div class="text-gray-500">
								{{ __($countModerations > 1 ? 'Moderations waiting' : 'Moderation waiting') }}
							</div>
						</div>
					</div>
				</a>
			</div>

			<div class="px-6 sm:w-1/2 xl:w-1/3 sm:mt-0">
				<a href="{{ route('admin.companies.index') }}">
					<div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white">
						<button type="button" class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-3 py-2.5 text-center me-2 mb-2">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
								<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205 3 1m1.5.5-1.5-.5M6.75 7.364V3h-3v18m3-13.636 10.5-3.819" />
							</svg>
						</button>

						<div class="mx-5">
							<h4 class="text-2xl font-semibold text-gray-700">
								{{ $countCompanies }}
							</h4>

							<div class="text-gray-500">
								{{ __('Currently published companies') }}
							</div>
						</div>
					</div>
				</a>
			</div>

			<div class="px-6 sm:w-1/2 xl:w-1/3 xl:mt-0">
				<a href="{{ route('admin.animals.index') }}">
					<div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white">
						<button type="button" class="text-white bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-3 py-2.5 text-center me-2 mb-2">
							<svg class="shrink-0" width="30" height="27" viewBox="0 0 30 27" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M14.9629 9.90039C14.9613 9.90036 14.939 9.90081 14.9043 9.90137C14.8672 9.90196 14.8144 9.90277 14.748 9.90625C14.6152 9.91321 14.4271 9.92883 14.1992 9.96094C13.7441 10.0251 13.1257 10.1577 12.4688 10.4336C11.149 10.9879 9.67365 12.1206 9.05664 14.4062C8.47873 16.547 7.37119 17.7135 6.36328 18.7725C5.81276 19.3509 5.26718 19.9216 4.91992 20.5889C4.56505 21.2709 4.41947 22.0473 4.63867 23.0312C4.87599 24.0948 5.42417 24.9097 6.28125 25.4531C7.1311 25.9919 8.26295 26.25 9.64941 26.25C10.2595 26.25 10.9215 26.2 11.6348 26.1006C13.8494 25.7932 16.0949 25.7933 18.3096 26.1006C20.2851 26.3751 21.8811 26.2739 23.0635 25.7676C24.2615 25.2544 25.0162 24.333 25.3066 23.0312C25.5272 22.0412 25.3823 21.2597 25.0283 20.5723C24.6816 19.8991 24.1357 19.3223 23.585 18.7373C22.5894 17.6804 21.4943 16.5145 20.8857 14.3975C20.2309 12.1175 18.7569 10.9879 17.4443 10.4346C16.7911 10.1592 16.1784 10.0262 15.7266 9.96191C15.313 9.90308 15.0024 9.90004 14.9834 9.90137L14.9736 9.90039H14.9629ZM14.9639 11.0986L14.9707 11.0977C15.0407 11.0954 15.9689 11.0832 17.0068 11.5332C18.0348 11.9789 19.1752 12.879 19.7041 14.7207C20.3935 17.1204 21.6776 18.4811 22.6826 19.5479C23.2188 20.1173 23.6486 20.576 23.9111 21.0732C24.1649 21.5538 24.2634 22.076 24.1074 22.7764C23.8959 23.7248 23.3547 24.3626 22.4531 24.7188C21.5324 25.0823 20.2213 25.1566 18.4814 24.915L18.0439 24.8584C17.2261 24.7592 16.4047 24.7003 15.583 24.6807L15.5928 24.6719H14.9727C13.7999 24.6719 12.6276 24.7532 11.4629 24.915C9.72242 25.1569 8.41171 25.0815 7.49121 24.7178C6.58959 24.3615 6.04847 23.7238 5.83691 22.7754L5.79102 22.5244C5.71017 21.9558 5.81365 21.5098 6.03516 21.0947C6.29732 20.6036 6.72561 20.1502 7.26074 19.5879C8.27978 18.5168 9.58286 17.1497 10.2412 14.7119C10.7368 12.8757 11.8767 11.9782 12.9111 11.5332C13.9549 11.0843 14.8945 11.096 14.9561 11.0977L14.9639 11.0986ZM25.8877 9.01465C24.9356 9.01478 24.0899 9.52218 23.4902 10.3057C22.8906 11.0891 22.5264 12.1601 22.5264 13.3311C22.5264 14.5019 22.8907 15.5728 23.4902 16.3564C24.0899 17.1401 24.9356 17.6473 25.8877 17.6475C26.8402 17.6475 27.6865 17.141 28.2861 16.3574C28.8857 15.5739 29.25 14.5023 29.25 13.3311C29.25 12.1599 28.8856 11.089 28.2861 10.3057C27.6864 9.52214 26.8399 9.01465 25.8877 9.01465ZM4.1123 9.01465C3.16006 9.01465 2.3136 9.52208 1.71387 10.3057C1.11431 11.0891 0.75 12.1601 0.75 13.3311C0.750017 14.5019 1.11438 15.5729 1.71387 16.3564C2.31358 17.1402 3.16002 17.6475 4.1123 17.6475C5.06458 17.6473 5.9102 17.1408 6.50977 16.3574C7.1093 15.5739 7.47362 14.5023 7.47363 13.3311C7.47363 12.1598 7.10931 11.089 6.50977 10.3057C5.91009 9.52225 5.06437 9.01478 4.1123 9.01465ZM25.8877 10.2119C26.4426 10.2119 26.9716 10.5309 27.3711 11.0947C27.77 11.6578 28.0244 12.4482 28.0244 13.3311C28.0244 14.214 27.77 15.0043 27.3711 15.5674C26.9717 16.1312 26.443 16.4492 25.8877 16.4492C25.3326 16.4491 24.8046 16.131 24.4053 15.5674C24.0064 15.0043 23.751 14.214 23.751 13.3311C23.751 12.4481 24.0064 11.6578 24.4053 11.0947C24.8046 10.5311 25.3325 10.2121 25.8877 10.2119ZM4.1123 10.2119C4.66707 10.2121 5.19528 10.531 5.59473 11.0947C5.99369 11.6578 6.24902 12.4482 6.24902 13.3311C6.24901 14.214 5.99363 15.0043 5.59473 15.5674C5.1954 16.131 4.66743 16.4491 4.1123 16.4492C3.55701 16.4492 3.02833 16.1312 2.62891 15.5674C2.23 15.0043 1.9756 14.214 1.97559 13.3311C1.97559 12.4482 2.23004 11.6578 2.62891 11.0947C3.02833 10.5309 3.55701 10.2119 4.1123 10.2119ZM19.9111 0.75C18.9591 0.750172 18.1133 1.25746 17.5137 2.04102C16.9142 2.8245 16.5498 3.8953 16.5498 5.06641C16.5498 6.23775 16.914 7.30922 17.5137 8.09277C18.1133 8.87629 18.9591 9.38264 19.9111 9.38281H20.1611V9.36914C21.0115 9.2892 21.7636 8.80632 22.3105 8.0918C22.9102 7.30826 23.2744 6.23663 23.2744 5.06543C23.2743 3.89422 22.9093 2.82332 22.3096 2.04004C21.7096 1.25663 20.8633 0.75 19.9111 0.75ZM10.0889 0.75C9.13627 0.75 8.2901 1.2573 7.69043 2.04102C7.091 2.82453 6.7266 3.89526 6.72656 5.06641C6.72656 6.23775 7.09079 7.30922 7.69043 8.09277C8.29016 8.87642 9.13664 9.38281 10.0889 9.38281H10.3389V9.36914C11.1888 9.28892 11.9398 8.80604 12.4863 8.0918C13.0859 7.30823 13.4502 6.23674 13.4502 5.06543C13.4501 3.89428 13.0858 2.82335 12.4863 2.04004C11.8868 1.25671 11.0412 0.750172 10.0889 0.75ZM19.9111 1.94824C20.4664 1.94824 20.9951 2.26634 21.3945 2.83008C21.7934 3.39313 22.0478 4.18351 22.0479 5.06641C22.0479 5.94931 21.7934 6.73966 21.3945 7.30273C20.9951 7.86653 20.4664 8.18555 19.9111 8.18555C19.356 8.18536 18.828 7.86637 18.4287 7.30273C18.0298 6.73966 17.7754 5.94931 17.7754 5.06641C17.7754 4.18351 18.0298 3.39313 18.4287 2.83008C18.828 2.26651 19.356 1.94843 19.9111 1.94824ZM10.0889 1.94824C10.6436 1.94843 11.1719 2.2664 11.5713 2.83008C11.9703 3.39314 12.2246 4.18355 12.2246 5.06641C12.2246 5.94931 11.9702 6.73966 11.5713 7.30273C11.172 7.86637 10.644 8.18536 10.0889 8.18555C9.53357 8.18555 9.00489 7.86653 8.60547 7.30273C8.2066 6.73966 7.95215 5.94931 7.95215 5.06641C7.95218 4.18351 8.20658 3.39313 8.60547 2.83008C9.00489 2.26634 9.5336 1.94824 10.0889 1.94824Z" fill="#0E1954" stroke="#0E1954" stroke-width="0.5"></path>
							</svg>
						</button>

						<div class="mx-5">
							<h4 class="text-2xl font-semibold text-gray-700">
								{{ $countAnimals }}
							</h4>

							<div class="text-gray-500">
								{{ __('Animals') }}
							</div>
						</div>
					</div>
				</a>
			</div>

			<div class="px-6 sm:w-1/2 xl:w-1/3 xl:mt-0">
				<a href="{{ route('admin.subscriptions.index') }}">
					<div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white">
						<button type="button" class="text-white bg-gradient-to-br from-pink-500 to-orange-400 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800 font-medium rounded-lg text-sm px-3 py-2.5 text-center me-2 mb-2">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
								<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
							</svg>
						</button>

						<div class="mx-5">
							<h4 class="text-2xl font-semibold text-gray-700">
								{{ $countSubscriptions }}
							</h4>

							<div class="text-gray-500">
								{{ __('Subscriptions') }}
							</div>
						</div>
					</div>
				</a>
			</div>

			<div class="px-6 sm:w-1/2 xl:w-1/3 xl:mt-0">
				<a href="{{ route('admin.professionnal-activities.index') }}">
					<div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white">
						<button type="button" class="text-white bg-gradient-to-br from-pink-500 to-orange-400 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800 font-medium rounded-lg text-sm px-3 py-2.5 text-center me-2 mb-2">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
								<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
							</svg>
						</button>

						<div class="mx-5">
							<h4 class="text-2xl font-semibold text-gray-700">
								{{ $countProfessionnalActivities }}
							</h4>

							<div class="text-gray-500">
								{{ __('Currently published professionnal activities') }}
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>
	</div>

	<div class="mt-8">
		<h1 class="text-gray-700 text-3xl font-medium">
			{{ __('Users') }}
		</h1>

		<div class="container mt-4">
			<livewire:admin.users />
		</div>
	</div>
@endsection

@push('scripts')
	<script src="{{ asset('js/datepicker.js') }}"></script>
@endpush
