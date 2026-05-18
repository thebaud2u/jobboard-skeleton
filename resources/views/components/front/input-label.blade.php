@props([
	'value',
	'required' => false
])

<label {{ $attributes->merge(['class' => 'font-medium text-sm text-breeder-deepblue']) }}>
	{{ $value ?? $slot }}

	@if($required)
		<span class="text-breeder-violet">*</span>
	@endif
</label>
