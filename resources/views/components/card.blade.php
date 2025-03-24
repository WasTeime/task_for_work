@props(['title', 'href'])

<a href="{{ $href }}" class="block">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-200">
        <div class="p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ $title }}</h2>
            {{ $slot }}
        </div>
    </div>
</a> 