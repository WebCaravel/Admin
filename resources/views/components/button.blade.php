@props([
    'tag' => 'button',          // for example: button|a
    'type' => '',               // for example: submit|button
    'icon' => '',               // You can use x-icon-names
    'color' => 'secondary',     // options: primary|secondary|third|success|danger|warning
    'size' => 'md',             // for example: xs|sm|md|lg|xl
    'iconRight' => false,       // icon on the right side of the button?
    'iconClass' => 'w-4 h-4 flex-shrink-0'
])
@php
    switch($color) {
        case 'primary': $colorClasses = 'text-white bg-primary-500 hover:bg-primary-600 active:bg-gray-900'; break;
        default: case 'secondary': $colorClasses = 'text-white bg-secondary-500 hover:bg-secondary-600 active:bg-gray-900'; break;
        case 'third': $colorClasses = 'text-white bg-third-500 hover:bg-third-600 active:bg-gray-900'; break;
        case 'success': $colorClasses = 'text-white bg-success-500 hover:bg-success-600 active:bg-gray-900'; break;
        case 'danger': $colorClasses = 'text-white bg-danger-500 hover:bg-danger-600 active:bg-gray-900'; break;
        case 'warning': $colorClasses = 'text-white bg-warning-500 hover:bg-warning-600 active:bg-gray-900'; break;
        case 'white': $colorClasses = 'text-primary hover:text-white bg-white-100 hover:bg-white-600 active:bg-gray-900'; break;
    }
    switch($size) {
        case 'xs': $sizeClass = 'text-xs'; break;
        case 'sm': $sizeClass = 'text-sm'; break;
        default: case 'md': $sizeClass = 'text-md'; break;
        case 'lg': $sizeClass = 'text-lg'; break;
        case 'xl': $sizeClass = 'text-xl'; break;
    }
    $att = $attributes->merge([
        'class' => 'px-4 py-2 border rounded-md tracking-widest focus:ring focus:ring-gray-300 disabled:opacity-25 transition focus:border-gray-900 focus:outline-none cursor-pointer ' .
           trim($sizeClass . ' ' . $colorClasses),
        'type'  => $type,
        "x-on:click" => $attributes->get("onclick")
    ])->except(["onclick"]);
@endphp

<{{ $tag }} {{ $att }}>
@if($icon && !$iconRight)<x-icon :name="$icon" class="{{ $iconClass }} mr-2" />@endif
{{ $slot }}
@if($icon && $iconRight)<x-icon :name="$icon" class="{{ $iconClass }} ml-2" />@endif
</{{ $tag }}>
