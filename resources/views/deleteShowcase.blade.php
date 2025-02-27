<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Usuń Puchar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex-wrap justify-center gap-4">
                        @for ($i = 0; $i < count($trophy_names); $i++)
                            <div class="flex items-center border p-4 rounded-lg shadow-md">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('storage/' . $trophy_paths[$i]) }}" alt="Trophy Image" style="width: 100px; height: 100px; object-fit: cover;">
                                </div>
                                <div class="flex items-center">
                                    <p class="text-lg font-semibold ml-3">{{ $trophy_owners[$i] }} - {{ $trophy_names[$i] }}</p>
                                    <!-- Form for deleting the trophy -->
                                    <form action="{{ route('showcase.destroy', $trophy_ids[$i]) }}" method="POST" onsubmit="return confirm('Czy na pewno chcesz usunąć ten puchar?');">
                                        @csrf
                                        @method('DELETE')
                                        <x-primary-button class="ml-3" type="submit">
                                            {{ __('Usuń') }}
                                        </x-primary-button>
                                    </form>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>