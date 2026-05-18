<div>
	<div class="flex flex-col gap-y-4 mt-8">
		@if($case == 'company-about-breed')
			<p class="text-breeder-deepblue text-[18px] font-bold">
				{{ __('Share your knowledge with the community to gain visibility') }}

				<span class="text-breeder-orange">
					{{ __(' to gain visibility') }}
				</span>
			</p>

			<p class="text-base text-breeder-deepblue">
				{{ __('Explain why you chose to breed these breeds.') }}<br>
				{{ __('Your story will appear in the breed profile, which can be viewed by all visitors.') }}
			</p>

			<p class="flex flex-row text-xs text-breeder-deepblue italic">
				{{ __('Interact in the pages of races, answer the questions of the adopters to appear in company suggested in the sheet after 10 contributions.') }}
			</p>

			@if($target->isNotEmpty())
				@foreach($target as $index => $breed)
					@php
						$comment = $breed->commentsReceived()
							->whereHasMorph('source', [\App\Models\Company::class], function($whereHasMorph) use($source) {
								$whereHasMorph->where('id', $source->id);
							})
							->first();
					@endphp

					<livewire:front.comments.comment
						:comment="$comment"
						:target="$breed"
						:source="$source"
						:case="$case"
						:create="$create"
						:update="$update"
						:inModal="$inModal"
						:contentLabel="__('Your experience with the breed :breed', ['breed' => $breed->name])"
						:componentGivenKey="$index"
						:key="'comment-'.$commentComponentKey" />

					@if($index <= count($target)-1)
						<hr/>
					@endif
				@endforeach
			@else
				{{ __('You currently have no breeds') }}
			@endif
		@elseif($case == 'breed')
			@if($comments->isNotEmpty() || $userCommentSet)
				@if($userCommentSet)
					<livewire:front.comments.comment
						:comment="$userComment"
						:target="$breed"
						:source="$company"
						:case="$case"
						:update="true"
						:componentGivenKey="$commentComponentKey"
						:key="'comment-'.$commentComponentKey" />
				@endif

				@foreach($comments as $index => $comment)
					<livewire:front.comments.comment
						:comment="$comment"
						:target="$breed"
						:source="$company"
						:update="false"
						:componentGivenKey="$index"
						:key="'comment-'.$commentComponentKey" />

					@if($index < count($company->breeds)-1)
						<hr/>
					@endif
				@endforeach
			@else
				{{ __('There are no comments for this breed yet') }}
			@endif
		@elseif($case == 'user-about-breed')
			@if($source)
				<livewire:front.comments.comment
					:comment="$comment"
					:target="$target"
					:source="$source"
					:case="$case"
					:create="true"
					:update="false"
					:inModal="$inModal"
					:contentLabel="__('Your experience with this breed')"
					:componentGivenKey="$commentComponentKey"
					:key="'comment-'.$commentComponentKey" />
			@else
				@if(!Auth::guard('web')->check())
					<div class="flex flex-row justify-center gap-x-1">
						<span class="font-bold">{{ __('Log in to share your experience') }}</span> {{ __('on the :breed breed', ['breed' => $target->name]) }}
					</div>

					<div class="flex flex-row justify-center" wire:click="redirectToRegister">
						<x-front.primary-button>
							{{ __('Log in') }}
						</x-front.primary-button>
					</div>
				@endif
			@endif
		@elseif($case == 'user-about-company')
			<livewire:front.comments.comment
				:comment="$comment"
				:target="$target"
				:source="$source"
				:case="$case"
				:create="true"
				:update="false"
				:inModal="$inModal"
				:contentLabel="__('Your experience with this company')"
				:componentGivenKey="$commentComponentKey"
				:key="'comment-'.$commentComponentKey" />
		@endif
	</div>
</div>
