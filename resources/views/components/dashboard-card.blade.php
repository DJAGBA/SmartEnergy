@props(['title', 'count', 'color'])

<div class="bg-{{ $color }}-100 p-4 rounded shadow text-center">
    <h2 class="text-2xl font-bold text-{{ $color }}-800">{{ $count }}</h2>
    <p class="text-sm text-{{ $color }}-600">{{ $title }}</p>
</div>