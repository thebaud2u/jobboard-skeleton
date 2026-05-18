<a {{
	$attributes->merge([
		'class' => 'block w-full px-4 py-2 hover:border-l-4 '.
				'text-left text-[12px] leading-5 font-bold hover:text-white hover:font-bold '.
				'border-transparent hover:border-breeder-deepblue focus:border-breeder-deepblue hover:bg-breeder-deepblue focus:bg-breeder-deepblue focus:outline-none '.
				'transition duration-150 ease-in-out'
	])
}}>{{ $slot }}</a>
