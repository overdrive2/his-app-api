<!-- Discord -->
<button
  type="button"
  data-te-ripple-init
  data-te-ripple-color="light"
  {{ $attributes->merge(['class' => 'mb-2 inline-block bg-secondary-600 rounded px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-md transition duration-150 ease-in-out hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg']) }}
>
  {{ $slot }}
</button>
