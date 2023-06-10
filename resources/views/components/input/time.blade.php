<div
    x-data="{
        model: '12:00:00'
    }"
    x-init="
        timepicker = new Timepicker($refs.timepicker, { format24:true, inline: true, });
        $watch('model', value => console.log(value))
    "
>
    <div
      class="relative"
      x-bind:value="model"
      x-ref="timepicker"
      data-te-input-wrapper-init
    >
      <input
        type="text"
        class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[2.15] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
        id="form3" />
      <label
        for="form3"
        class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[2.15] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary"
        >Select a time</label
      >
    </div>
</div>
