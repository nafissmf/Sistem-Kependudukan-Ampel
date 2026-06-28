@props(['label', 'name', 'required' => false])

<div>
    <label for="{{ $name }}" class="text-sm font-medium text-slate-700 dark:text-slate-200">
        {{ $label }} @if($required)<span class="text-danger-500">*</span>@endif
    </label>
    <div class="mt-1.5">
        {{ $slot }}
    </div>
    @error($name)
        <p class="mt-1 text-xs text-danger-500">{{ $message }}</p>
    @enderror
</div>
