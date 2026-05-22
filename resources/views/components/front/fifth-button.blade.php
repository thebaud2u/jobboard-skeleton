<button {{ $attributes->merge([
	'type' => 'submit',
	'class' => 'inline-flex items-center px-3 py-1.5 whitespace-nowrap '.
				'hover:bg-jobboard-deepblue hover:text-white border-2 border-jobboard-deepblue rounded-full '.
				'text-sm xl:text-base text-jobboard-deepblue font-medium '.
				'focus:outline-none focus:ring-0 transition ease-in-out duration-150 uppercase '
]) }}>
	{{ $slot }}
</button>
