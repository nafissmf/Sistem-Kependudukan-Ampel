@props(['status'])

@php
    $status = $status instanceof \App\Enums\VerificationStatus ? $status : \App\Enums\VerificationStatus::from($status);
@endphp

<span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium {{ $status->badgeClass() }}">
    {{ $status->label() }}
</span>
