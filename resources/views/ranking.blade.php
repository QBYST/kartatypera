<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ranking') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if ($names && count($names) > 2)
                        <div class="flex justify-center items-end">
                            <!-- Drugie miejsce -->
                            <div class="w-1/3 text-center mt-3">
                                <a href="/profile-page/{{ $names[1] }}">
                                    <img src="{{ asset('storage/' . $paths[1]) }}" alt="Photo" style="width: 150px; height: 150px; object-fit: cover;">
                                </a>
                                <strong>Miejsce 2.</strong>
                                <p>{{ $names[1] }} - {{ $points[1] }}</p>
                            </div>
                        
                            <!-- Pierwsze miejsce (wiekszy obrazek) -->
                            <div class="w-1/3 text-center">
                                <a href="/profile-page/{{ $names[0] }}">
                                    <img src="{{ asset('storage/' . $paths[0]) }}" alt="Photo" style="width: 200px; height: 200px; object-fit: cover;">
                                </a>
                                <strong>Miejsce 1.</strong>
                                <p>{{ $names[0] }} - {{ $points[0] }}</p>
                            </div>
                        
                            <!-- Trzecie miejsce -->
                            <div class="w-1/3 text-center mt-3">
                                <a href="/profile-page/{{ $names[2] }}">
                                    <img src="{{ asset('storage/' . $paths[2]) }}" alt="Photo" style="width: 150px; height: 150px; object-fit: cover;">
                                </a>
                                <strong>Miejsce 3.</strong>
                                <p>{{ $names[2] }} - {{ $points[2] }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col items-center justify-center">
                            <div class="flex-wrap justify-center">
                                @for ($i = 3; $i < count($names); $i++)
                                    <a href="/profile-page/{{ $names[$i] }}">
                                        <div class="flex items-center mt-2">
                                            <strong class="flex mr-3" style="min-width: 20px; text-align: right;">{{ $i + 1 }}.</strong>  
                                            <img src="{{ asset('storage/' . $paths[$i]) }}" alt="Photo" style="width: 50px; height: 50px; object-fit: cover; margin-right: 5px;">
                                            <p class="ml-2" style="margin-left: 20px;">{{ $names[$i] }} - {{ $points[$i] }}</p>
                                        </div>
                                    </a>
                                @endfor
                            </div>
                        </div>
                    @else
                        <!-- <4 zawodnikow -->
                        <div class="flex flex-col items-center justify-center">
                            <div class="flex-wrap justify-center">
                                @for ($i = 0; $i < count($names); $i++)
                                    <a href="/profile-page/{{ $names[$i] }}">
                                        <div class="flex items-center mt-2">
                                            <strong class="flex mr-3" style="min-width: 20px; text-align: right;">{{ $i + 1 }}.</strong>  
                                            <img src="{{ asset('storage/' . $paths[$i]) }}" alt="Photo" style="width: 50px; height: 50px; object-fit: cover; margin-right: 5px;">
                                            <p class="ml-2" style="margin-left: 20px;">{{ $names[$i] }} - {{ $points[$i] }}</p>
                                        </div>
                                    </a>
                                @endfor
                            </div>
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
