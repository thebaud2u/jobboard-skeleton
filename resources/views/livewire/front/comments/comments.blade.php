<div>
	<div class="flex flex-col gap-y-4 mt-8">
		@if($case == 'user-about-company')
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
