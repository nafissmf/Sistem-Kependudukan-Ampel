@props(['name', 'type' => 'text'])

<input
    id="{{ $name }}" name="{{ $name }}" type="{{ $type }}"
    value="{{ old($name, $value ?? '') }}"
    {{ $attributes->merge(['class' => 'flex h-10 w-full rounded-xl border border-[var(--border)] bg-[var(--card-bg)] px-3.5 py-2 text-sm shadow-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 ' . ($errors->has($name) ? 'border-danger-500' : '')]) }}
>
