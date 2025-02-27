<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Wyniki kart') }}
        </h2>
    </x-slot>
    <div class="flex-wrap">
        @foreach ($templates as $index => $template)
            
            <div>
                <div class="flex items-center justify-center mt-6">
                    <h2>Wyniki Karty Tygodnia</h2>
                    <span>&nbsp;</span>
                    <p>{{ $template->week }}</p>
                </div>
                <div class="flex items-center justify-center mt-2">
                    @if ($outcomes[$index] === "-")
                    <a href="{{ route('weekly-pick-outcome.show', ['weekly_pick_outcome' => $template->week]) }}">
                        <x-primary-button class="ms-3 mb-3">
                            {{ __('Dodaj Wyniki') }}
                        </x-primary-button>
                    </a>
                    @else 
                    <a href="{{ route('weekly-pick-outcome.show', ['weekly_pick_outcome' => $template->week]) }}">
                        <x-secondary-button class="ms-3 mb-3">
                            {{ __('Edytuj') }}
                        </x-secondary-button>
                    </a>
                    <form action="{{ route('weekly-pick-outcome.destroy', $template->week) }}" method="POST" onsubmit="return confirm('Czy na pewno chcesz usunąć wyniki karty z tygodnia {{ $template->week }}?');">
                        @csrf
                        @method('DELETE')
                        <x-danger-button type="submit" class="ms-3 mb-3">
                            {{ __('Usuń') }}
                        </x-danger-button>
                    </form>
                    @endif
                </div>
            </div>
            
            
        @endforeach
    </div>
    
</x-app-layout>