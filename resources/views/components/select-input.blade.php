@props(['name', 'options' => [], 'placeholder' => '— Pilih —', 'optionValue' => 'id', 'optionLabel' => 'name'])

@php $selected = old($name, $value ?? ''); @endphp

<select
    id="{{ $name }}" name="{{ $name }}"
    {{ $attributes->merge(['class' => 'flex h-10 w-full rounded-xl border border-[var(--border)] bg-[var(--card-bg)] px-3.5 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 ' . ($errors->has($name) ? 'border-danger-500' : '')]) }}
>
    <option value="">{{ $placeholder }}</option>
    @foreach ($options as $option)
        @php $value_ = is_array($option) ? $option[$optionValue] : $option->{$optionValue}; @endphp
        @php $label_ = is_array($option) ? $option[$optionLabel] : $option->{$optionLabel}; @endphp
        <option value="{{ $value_ }}" @selected((string) $selected === (string) $value_)>{{ $label_ }}</option>
    @endforeach
</select>
