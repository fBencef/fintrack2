@props(['title', 'id'])

<div {{ $attributes->merge(['class' => 'bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col']) }} id="card-{{ $id }}">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-bold text-gray-700">{{ $title }}</h3>
        {{ $cardActions ?? '' }}
    </div>
    
    <div class="flex-grow">
        {{ $slot }}
    </div>
</div>