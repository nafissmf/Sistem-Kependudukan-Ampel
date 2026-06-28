@props(['name', 'class' => 'size-5'])

@php
    static $icons = null;
    $icons ??= require resource_path('icons.php');
    $inner = $icons[$name] ?? $icons['circle'];
@endphp

<svg
    xmlns="http://www.w3.org/2000/svg"
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    stroke-width="2"
    stroke-linecap="round"
    stroke-linejoin="round"
    {{ $attributes->merge(['class' => $class]) }}
    aria-hidden="true"
>{!! $inner !!}</svg>
