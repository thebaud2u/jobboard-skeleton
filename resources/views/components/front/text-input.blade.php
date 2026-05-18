@props([
	'disabled' => false,
	'readonly' => false
])

<input type="{{ $attributes['type'] ?? 'text' }}" {{ $disabled ? 'disabled' : '' }} {{ $readonly ? 'readonly' : '' }} {!! $attributes->merge(['class' => 'border-breeder-greige '.(($disabled || $readonly) ? 'focus:border-breeder-greige focus:ring-0 focus:ring-offset-0' : 'focus:border-breeder-deepblue focus:ring-breeder-deepblue').' rounded-md shadow-sm text-breeder-deepblue placeholder:text-breeder-greige']) !!}>
