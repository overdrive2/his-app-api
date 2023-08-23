<button
  type="button"
  {{  $attributes->merge(['class'=>'inline-block rounded bg-primary-100 px-4 pb-[5px] pt-[6px] text-sm font-medium uppercase leading-normal text-primary-700 transition duration-150 ease-in-out hover:bg-primary-accent-100 focus:bg-primary-accent-100 focus:outline-none focus:ring-0 active:bg-primary-accent-200'])}}>
  {{ $slot }}
</button>
