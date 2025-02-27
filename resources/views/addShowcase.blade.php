<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dodaj Puchar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Display Validation Errors -->
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Oopaaa!</strong> Twoja karta posiada błędy! Popraw je:
                            <ul class="mt-3 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('showcase.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf


                        <div class="flex-wrap">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <x-input-label class="flex ml-3" for=photo :value="__('Zdjęcie')"/>
                                    <input class="flex ml-3" type="file" id="photo" name="photo" required/>
                                </div>
                                <div class="flex items-center">
                                    <x-input-label for=name :value="__('Nazwa')"/>
                                    <x-text-input class="flex ml-3" type="text" id="name" name="name" value="{{ old('name') }}" required/>
                                </div>
                                <div class="flex items-center">
                                    <x-input-label class="flex ml-3" for=user :value="__('Dla gracza')"/>
                                    <x-text-input class="flex ml-3" type="text" id="user" name="user" value="{{ old('user') }}" required/>
                                </div>
                                
                                
                            </div>
                            <div class="flex items-center justify-center">
                                <x-primary-button class="ms-3 mt-6" type="submit">
                                    {{ __('Dodaj') }}
                                </x-primary-button>
                            </div>
                            
                        </div>

                        
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
