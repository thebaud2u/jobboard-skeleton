<div>
	<div x-data="{
		k: @entangle('key').live,
		mediaId: @entangle('mediaId').live,
		collection: @entangle('collection').live,
		clearUppy:function() { window.uppy.cancelAll() },
		mediaValues:function(index, id) {
			this.k = index;
			this.mediaId = id;
			this.uppyUploaderCollection = this.collection;
			this.uppyUploaderMediaId = id;
		}}"
		x-on:uploaded.window="window.Livewire.dispatch('saveMedia'+uppyUploaderCollection, {
			collection: $event.detail.collection,
			file: $event.detail.file,
			extension: $event.detail.extension,
			path: $event.detail.path
		})">
		@if(!empty($mediable->id))
			<div class="{{ $gridClass }}">
				@php 
					$nb_medias = 0;
				@endphp
				@foreach($medias as $index => $media)
					@php
						$nb_medias += 1;
					@endphp
					@if($index < $maxMedias)
						<input type="hidden" name="medias[]" value="{{ $media->id }}" />

						<div class="group">
							<div class="overflow-hidden rounded-md {{ $aspectRatio }} relative max-sm:mb-4 transition duration-300 ease-in-out">
								<div class="z-20 opacity-0 group-hover:opacity-100 transition duration-300 ease-in-out absolute from-black to-transparent bg-gradient-to-t inset-x-0 -bottom-2 pt-30 text-white flex items-end">
									<div class="w-full">
										<div class="p-4 space-y-3 text-sm group-hover:opacity-100 group-hover:translate-y-0 translate-y-4 pb-4 transform transition duration-300 ease-in-out">
											<div class="flex flex-row items-center space-x-4">
												<div class="grow-0">
													@if($index == 0)
														<span class="text-vjcyan-500" title="{{ __('Main image') }}">
															<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
																<path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
															</svg>
														</span>
													@else
														<span wire:click="setMain({{ $media->id }})" class="ml-auto hover:text-vjcyan-300 transition ease-in-out duration-150 cursor-pointer" title="{{ __('Select this image as main') }}">
															<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
																<path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
															</svg>
														</span>
													@endif
												</div>

												<div class="grow flex">
													<a href="#" x-on:click.prevent="mediaValues({{ $index + 1 }}, {{ $media->id }}); clearUppy(); $dispatch('open-modal','add_photo');" class="ml-auto hover:text-breeder-deepblue transition ease-in-out duration-150" title="{{ __('Replace image') }}">
														<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
															<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
														</svg>
													</a>
												</div>

												<div class="grow-0">
													<a href="#" x-on:click.prevent="mediaValues({{ $index + 1 }}, {{ $media->id }}); $dispatch('open-modal','delete_photo');" class="hover:text-breeder-deepblue transition ease-in-out duration-150" title="{{ __('Delete image') }}">
														<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
															<path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
														</svg>
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>

								<img alt="" src="{{ $media->getAvailableUrl(['optimized']) }}" class="{{ $objectFit }} w-full {{ $aspectRatio }} group-hover:scale-105 transition duration-300 ease-in-out">
							</div>
						</div>
					@endif
				@endforeach

				@if($nb_medias < $maxMedias)
					<div class="overflow-hidden rounded-md aspect-video relative group max-sm:mb-4">
						<div class="z-20 opacity-0 group-hover:opacity-100 transition duration-300 ease-in-out absolute from-black/60 to-transparent bg-gradient-to-t inset-x-0 -bottom-2 pt-30 text-white flex items-end">
							<div class="w-full">
								<div class="p-4 space-y-3 text-xl group-hover:opacity-100 group-hover:translate-y-0 translate-y-4 pb-4 transform transition duration-300 ease-in-out">
									<div class="flex flex-row space-x-4">
										<div>
											<a href="#" x-on:click.prevent="mediaValues(0,0); clearUppy(); $dispatch('open-modal','add_photo');" class="hover:text-breeder-deepblue transition ease-in-out duration-150" title="{{ __('Add image') }}">
												<svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
													<rect x="0.75" y="0.75" width="25.5" height="25.5" rx="12.75" stroke="currentColor" stroke-width="1.5"/>
													<line x1="13.75" y1="8" x2="13.75" y2="19" stroke="currentColor" stroke-width="1.5"/>
													<line x1="19" y1="13.75" x2="8" y2="13.75" stroke="currentColor" stroke-width="1.5"/>
												</svg>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="h-full w-full flex items-center justify-center bg-gray-200 group-hover:bg-breeder-deepblue text-white group-hover:scale-105 transition duration-300 ease-in-out">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
								<path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
								<path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
							</svg>
						</div>
					</div>
				@endif
			</div>
		@endif
	</div>
</div>
