<div class="w-full bg-white shadow-[0_0_20px_0_rgba(0,44,106,0.2)] px-6 py-10 rounded-md">
	<div class="flex flex-row justify-between items-center gap-x-1">
		<x-front.space-title>
			{{ __('Comment') }}
		</x-front.space-title>

		<div class="flex justify-end gap-x-2">
			<x-front.secondary-button x-on:click.prevent="$dispatch('open-modal', 'modify-comment');" class="mr-4">
				{{ __('Update comment\'s content') }}
			</x-front.secondary-button>
		</div>
	</div>

	<div class="grid grid-cols-4 gap-y-4 mt-4 pl-6">
		<div>
			<div class="flex flex-row">
				<x-front.input-label for="source" :value="__('From')" />
			</div>

			<p>
				{{ $moderation->model->source->name }}
			</p>
		</div>

		<div>
			<div class="flex flex-row">
				<x-front.input-label for="target" :value="__('To')" />
			</div>

			<p>
				{{ $moderation->model->target->name }}
			</p>
		</div>

		<div>
			<div class="flex flex-row">
				<x-front.input-label for="content" :value="__('Comment\'s content')" />
			</div>

			<p>
				"{{ $moderation->model->content }}"
			</p>
		</div>
	</div>
</div>

<x-front.modal name="modify-comment" :class="'w-full max-w-2xl'" focusable>
	<form method="POST" action="{{ route('admin.moderations.update-comment') }}">
		@csrf

		<input type="hidden" name="moderation_id" value="{{ $moderation->id }}" />

		<section class="p-10 flex flex-col content-center gap-y-4">
			<div>
				<div class="flex flex-row">
					<x-front.input-label for="newContent" :value="__('Moderated comment\'s content')" />
				</div>

				<textarea rows="5" name="newContent" id="newContent" placeholder="{{ __('Moderated comment\'s content') }}" class="border-breeder-greige focus:border-breeder-deepblue focus:ring-breeder-deepblue rounded-md shadow-sm text-breeder-deepblue placeholder:text-gray-400 mt-1 block w-full">{{ $moderation->model->content }}</textarea>
			</div>

			<div class="flex s:flex-row flex-col items-center max-s:space-y-5 justify-end mt-10">
				<x-front.secondary-button x-on:click.prevent="$dispatch('close');" class="mr-4">
						{{ __('Cancel') }}
				</x-front.secondary-button>

				<x-front.primary-button>
						{{ __('Update') }}
				</x-front.primary-button>
			</div>
		</section>
	</form>
</x-front.modal>
