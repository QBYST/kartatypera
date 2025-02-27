<x-app-layout>
    <head>
        <link rel="stylesheet" href="/css/friends.css" />
        <style>
            .trophy-gallery {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 20px;
                justify-items: center;
                padding: 20px;
            }
            .trophy-item {
                text-align: center;
            }
            .trophy-image {
                width: 300px;
                height: 300px;
                object-fit: cover;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            }
            .trophy-name {
                margin-top: 10px;
                font-size: 1rem;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex items-center">
                            <img src="{{ asset('storage/' . $user->profile_picture_path) }}" alt="Photo" style="width: 200px; height: 200px; object-fit: cover;">
                            
                            <div class="flex justify-between w-full items-center" style="margin-left: 1rem">
                                <div class="flex flex-col">
                                    <strong>{{ $user->name }}</strong>
                                    <p>Dołączył {{ $user->created_at->locale('pl')->isoFormat('D MMMM YYYY') }}</p>
                                </div>
                            
                            </div>
                        </div>
                        <div>
                            <p class="mt-3">{{ $user->description }}</p>
                        </div>
                        <div class="trophy-gallery">
                            @if ($trophy_names && count($trophy_names) > 0)
                                @for ($i = 0; $i < count($trophy_names); $i++)
                                    <div class="trophy-item">
                                        <img src="{{ asset('storage/' . $trophy_paths[$i]) }}" alt="Trophy" class="trophy-image">
                                        <p class="trophy-name">{{ $trophy_names[$i] }}</p>
                                    </div>
                                @endfor
                            @else
                                <p>Brat jeszcze nie ma pucharów 🥲</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    
</x-app-layout>