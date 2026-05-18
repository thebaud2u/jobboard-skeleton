<section class="bg-white">
	<div class="conteneur">
		<h2 class="text-center">{{$title}}</h2>

		<div class="w-full flex flex-wrap justify-center xl:justify-between gap-4">
			@foreach($articles as $article)
				<div class="flex flex-col text-breeder-deepblue max-w-[350px] s:max-w-[280px]">
					<a href="{{$article['url']}}">
						<div class="w-full mb-4">
							<img src="{{ asset( $article['image']) }}" alt="{{$article['title']}}" class="object-cover md:h-[280px]" loading="lazy" />
						</div>
						<h4 class="font-semibold text-[18px] mb-2">{{$article['title']}}</h4>
					</a>
					<div class="flex flex-wrap gap-4">
						@foreach($article['categories'] as $categorie)
							<a href="{{$categorie['url']}}" class="rounded-md py-2 px-3 text-center bg-breeder-cream text-xs">{{$categorie['title']}}</a>
						@endforeach
					</div>
				</div>
			@endforeach
		</div>

		<a href="{{$url}}" class="btn-secondary">{{__('All our advices')}}</a>
	</div>
</section>
