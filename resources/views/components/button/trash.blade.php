<button
  type="button"
  data-te-ripple-init
  data-te-ripple-color="light"
  {{ $attributes->merge(['class' => 'inline-block rounded bg-red-100 px-6 pb-2 pt-2.5 text-md font-medium uppercase leading-normal text-red-700 transition duration-150 ease-in-out hover:bg-red-accent-100 focus:bg-red-accent-100 focus:outline-none focus:ring-0 active:bg-red-accent-200']) }} >
  {{ $slot }}
</button>
