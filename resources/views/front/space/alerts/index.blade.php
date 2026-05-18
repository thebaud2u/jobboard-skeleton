<x-space-layout>
	<x-slot name="side_menu">
		@include('components.front.space.profile.side-menu')
	</x-slot>

	<div class="flex-1 py-5">
		<div class="w-full bg-white px-6 mb-6 rounded-md text-breeder-deepblue">
			<livewire:front.space.alerts.my-alerts :key="'alerts-component'" />
		</div>
	</div>
</x-space-layout>
