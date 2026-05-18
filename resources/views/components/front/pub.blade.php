{{--
<div id='{{$id}}'>
    <script>
        googletag.cmd.push(function() {
            googletag.display('{{$id}}');
        });
    </script>
</div>
--}}
@php
    $classes = [
        '300x250' => 'w-[300px] h-[250px]',
        '970x90' => 'w-[970px] h-[90px]',
    ];
    $pub_class = $classes[$size] ?? '';
@endphp
<div class="bg-breeder-greige text-breeder-deepblue font-semibold rounded-lg mx-auto flex flex-col items-center justify-center max-w-full {{$pub_class}} ">
    PUB {{$size}}
</div>
