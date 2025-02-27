<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('patch')
        
        <div class="flex justify-between">
            <div class="w-1/2">
                <div class="mt-6 space-y-6">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Informacje o profilu') }}
                        </h2>
                
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __("W tym miejscu możesz zmienić adres email i zdjęcie profilowe.") }}
                        </p>
                    </header>

                    <!-- Nick i email -->
                    <div>
                        <x-input-label for="name" :value="__('Nickname')" />
                        {{-- <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autocomplete="name" /> --}}
                        <strong>{{ $user->name }}</strong>
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('E-mail')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div>
                                <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                                    {{ __('Twój adres Email nie jest zweryfikowany.') }}

                                    <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                        {{ __('Wyślij ponownie email weryfikacyjny.') }}
                                    </button>
                                </p>

                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                        {{ __('Nowy link weryfikacyjny został wysłany na twój adres email.') }}
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Opis')" />
                        <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" :value="old('email', $user->description)"/>
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Zapisz') }}</x-primary-button>

                        @if (session('status') === 'profile-updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600 dark:text-gray-400"
                            >{{ __('Zapisano.') }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- zdjecie -->
            <div class="w-1/2">
                <div class="mb-4 mt-6 space-y-6">
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $user->profile_picture_path) }}" alt="Photo" style="width: 200px; height: 200px; object-fit: cover;" padding-top:"30px">
                    </div>
                    {{-- <x-input-label for="photo" :value="__('Profile picture')" /> --}}
                    <input type="file" id="photo" name="photo">
                </div>
            </div>

        </div>
    </form>
</section>
