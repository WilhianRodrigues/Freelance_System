@props(['type' => 'success', 'message'])

@php
    $colors = [
        'success' => 'green',
        'error' => 'red',
        'warning' => 'yellow',
        'info' => 'blue',
    ];
    $color = $colors[$type] ?? 'green';
@endphp

<div class="p-4 mb-4 rounded-md bg-{{ $color }}-50">
    <div class="flex">
        <div class="flex-shrink-0">
            <svg class="w-5 h-5 text-{{ $color }}-400" viewBox="0 0 20 20" fill="currentColor">
                @if ($type === 'success')
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                @elseif($type === 'error')
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                @endif
            </svg>
        </div>
        <div class="ml-3">
            <p class="text-sm font-medium text-{{ $color }}-800">{{ $message }}</p>
        </div>
    </div>
</div>
