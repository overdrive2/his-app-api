<a
    aria-selected="true"
    role="button"
    data-te-ripple-color="light"
    data-te-toggle="pill"
    data-te-target="#{{ $tabName }}"
    aria-controls="{{$tabName}}"
    {{  $attributes->merge(['class'=>'my-2 block border-x-0 border-b-2 border-t-0 border-transparent lg:px-7 px-5 pb-3.5 pt-4 text-md font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400']) }}
>
    {{ $slot }}
</a>
