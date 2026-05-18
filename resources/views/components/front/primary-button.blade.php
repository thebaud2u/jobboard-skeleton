@props(['centered' => false])

@php
	$classes = 'inline-flex items-center gap-x-2 px-5 py-3 whitespace-nowrap ' .
			   'rounded-full text-sm ' .
			   'focus:outline-none focus:ring-0 transition ease-in-out duration-150 ' .
			   'text-breeder-cream font-bold bg-breeder-deepblue border-breeder-deepblue hover:bg-breeder-deepbluehover hover:border-breeder-deepbluehover';

	if ($centered) {
		$classes .= ' justify-center w-full text-center';
	}
@endphp

<button {{ $attributes->merge([
	'type' => 'submit',
	'class' => $classes
]) }}>
	{{ $slot }}
</button>
