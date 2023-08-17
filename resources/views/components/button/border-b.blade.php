@props(['color', 'label', 'icon'])

@php
$color = [
    'primary' => 'border-primary-800 hover:text-primary-500 text-primary-600 dark:focus:text-primary-600 dark:hover:text-primary-600',
    'red' => 'border-red-800 hover:text-red-500 text-red-600 dark:focus:text-red-600 dark:hover:text-red-600',
    'sky' => 'border-sky-800 hover:text-sky-500 text-sky-600 dark:focus:text-sky-600 dark:hover:text-sky-600',
    'amber' => 'border-amber-800 hover:text-amber-500 text-amber-600 dark:focus:text-amber-600 dark:hover:text-amber-600',
    'orange' => 'border-orange-800 hover:text-orange-500 text-orange-600 dark:focus:text-orange-600 dark:hover:text-orange-600',
    'pink' => 'border-pink-800 hover:text-pink-500 text-pink-600 dark:focus:text-pink-600 dark:hover:text-pink-600',
    'green' => 'border-green-800 hover:text-green-500 text-green-600 dark:focus:text-green-600 dark:hover:text-green-600',
][$color ?? 'border-gray-800 text-gray-600 hover:text-gray-500'];

$icon = [
    'right-left' => 'fa-solid fa-right-left',
    'person-walking-dashed-line-arrow-right' => 'fa-solid fa-person-walking-dashed-line-arrow-right',
    'file-waveform' => 'fa-solid fa-file-waveform',
    'house-chimney-user' => 'fa-solid fa-house-chimney-user',
    'user-plus' => 'fa-solid fa-user-plus',
    'user-clock' => 'fa-solid fa-user-clock'

][$icon ?? ''];
@endphp

<button
    aria-current="true"
    type="button"
    {{  $attributes->merge(['class' => $color.' border-b block w-full cursor-pointer rounded-lg p-4 text-left transition duration-500 hover:bg-neutral-100 hover:text-neutral-500 focus:bg-neutral-100 focus:text-neutral-500 focus:ring-0 dark:hover:bg-neutral-700  dark:focus:bg-neutral-700']) }}>
        <i class="{{ $icon }} text-lg mr-2"></i> <span class="text-gray-700 dark:text-gray-100">{{ $label ?? '' }}</span>
</button>
