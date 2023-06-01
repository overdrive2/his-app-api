<li class="inline-flex items-center">
    <a {{ $attributes->merge(['class'=>'text-sm text-gray-700 hover:text-gray-900 inline-flex items-center dark:text-gray-400 dark:hover:text-white']) }} >
        {{ $slot }}
    </a>
</li>
