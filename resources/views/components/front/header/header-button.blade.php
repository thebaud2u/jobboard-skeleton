<button {{ $attributes->merge([
	'type' => 'button',
	'class' => 'inline-flex items-center justify-center px-5 py-3 rounded-full whitespace-nowrap '.
				'focus:outline-none transition ease-in-out duration-150 '.
				'border-2 border-breeder-violet hover:border-breeder-violethover text-breeder-deepblue bg-breeder-violet hover:bg-breeder-violethover text-sm font-semibold '.
				'hover:border-breeder-deepblue hover:text-breeder-deepblue '
]) }}>
	{{ $slot }}
</button>
