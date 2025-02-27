<x-app-layout>
    <head>
        <style>
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                /* display: none; <- Crashes Chrome on hover */
                -webkit-appearance: none;
                margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
            }

            input[type=number] {
                -moz-appearance:textfield; /* Firefox */
            }

            .bet-button {
                padding: 0.5rem 1rem;
                border-radius: 0.375rem;
                background-color: #e5e7eb; /* gray-200 */
                color: #1f2937; /* gray-800 */
                cursor: pointer;
            }

            .bet-button:hover {
                background-color: #d1d5db; /* gray-300 */
            }

            .selected-bet-button {
                background-color: #3b82f6; /* blue-500 */
                color: #ffffff; /* white */
            }
            
            .selected-bet-button:hover{
                background-color: rgb(58, 58, 196);
            }

            .bet{
                flex-shrink: 0; /* Zabezpiecza przed zmniejszaniem */
                width: auto;
                padding: 10px 20px; /* Zwiększa wewnętrzne odstępy */
                display: inline-block;
            }

            .bet-beige{
                background-color: rgb(223, 203, 167);
            }

            .bet-purple{
                background-color: rgb(68, 14, 153);
                color: white;
            }

            #overlay {
                position: fixed; /* Sit on top of the page content */
                display: block; /* Hidden by default */
                width: 100%; /* Full width (cover the whole page) */
                height: 100%; /* Full height (cover the whole page) */
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.336); /* Black background with opacity */
                z-index: 2; /* Specify a stack order in case you're using a different order for other elements */
                cursor: pointer; /* Add a pointer on hover */
            }

        </style>
    </head>
    
    <body>
        <!-- overlay -->
        <div id="overlay" class="overlay"></div>

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

        <!-- Form -->
        <form action="{{ route('weekly-pick.store') }}" method="POST" style="padding-top: 20px">
            @csrf
            <div class="flex-wrap">

                <!-- tydzien i zamyka sie -->
                <div class="flex items-center justify-center mt-6">
                    <strong>Tydzień {{ $week }}</strong>
                    <input type="hidden" name="week" value="{{ $week }}">
                </div>
                <div class="flex items-center justify-center">
                    <p>Zamyka się za <span id="countdown"></span></p>
                </div>

                <!-- sekcja 1 -->
                <div class="flex items-center justify-center mt-6">
                    <strong>Sekcja 1</strong>
                </div>
                <div class="flex items-center justify-center mb-6">
                    <p>Wynik meczu</p>
                </div>

                <div class="flex items-center justify-center mb-6 gap-4">
                    <div class="w-1/3 flex flex-col items-center">
                        <x-input-label for="home" :value="$teams[0]" class="text-center"/>
                        <x-text-input type="number" step="1" name="home" id="home" value="{{ old('home', $prediction_home) }}" required class="mt-2 text-center" style="width: 5rem;" />
                    </div>
                    <div class="w-1/3 flex flex-col items-center">
                        <x-input-label for="away" :value="$teams[1]" class="text-center"/>
                        <x-text-input type="number" step="1" name="away" id="away" value="{{ old('away', $prediction_away) }}" required class="mt-2 text-center" style="width: 5rem;"/>
                    </div>
                </div>
                

                <!-- sekcja 2 -->
                <div class="flex items-center justify-center mt-6">
                    <strong>Sekcja 2</strong>
                </div>
                <div class="flex items-center justify-center mb-6">
                    <p>Punkty zawodników</p>
                </div>

                <div class="flex-wrap space-y-3">
                    <div class="flex items-center justify-center gap-6">
                        <div class="flex items-center justify-between" style="width: 200px;">
                            <input type="radio" id="home1" name="match" class="form-radio" title="Kapitan" value="1"
                            {{ old('match', $scores_captain) == '1' ? 'checked' : '' }} required>
                            <x-input-label for="home1" :value="$riders[0]" class="text-center ml-3" />
                            <x-text-input type="number" step="1" name="home1" id="home1" value="{{ old('home1', $scores_home[0] ?? '') }}" required class="mt-2 text-center ml-3" style="width: 3rem;" />
                        </div>
                        <div class="flex items-center justify-between" style="width: 200px;">
                            <input type="radio" id="away1" name="match" class="form-radio" title="Kapitan" value="9"
                            {{ old('match', $scores_captain) == '9' ? 'checked' : '' }} required>
                            <x-input-label for="away1" :value="$riders[8]" class="text-center  ml-3"/>
                            <x-text-input type="number" step="1" name="away1" id="away1" value="{{ old('away1', $scores_away[0] ?? '') }}" required class="mt-2 text-center ml-3" style="width: 3rem;" />
                        </div>
                    </div>
                    <div class="flex items-center justify-center gap-6">
                        <div class="flex items-center justify-between" style="width: 200px;">
                            <input type="radio" id="home2" name="match" class="form-radio" title="Kapitan" value="2"
                            {{ old('match', $scores_captain) == '2' ? 'checked' : '' }} required>
                            <x-input-label for="home2" :value="$riders[1]" class="text-center ml-3"/>
                            <x-text-input type="number" step="1" name="home2" id="home2" value="{{ old('home2', $scores_home[1] ?? '') }}" required class="mt-2 text-center ml-3" style="width: 3rem;" />
                        </div>
                        <div class="flex items-center justify-between" style="width: 200px;">
                            <input type="radio" id="away2" name="match" class="form-radio" title="Kapitan" value="10"
                            {{ old('match', $scores_captain) == '10' ? 'checked' : '' }} required>
                            <x-input-label for="away2" :value="$riders[9]" class="text-center ml-3"/>
                            <x-text-input type="number" step="1" name="away2" id="away2" value="{{ old('away2', $scores_away[1] ?? '') }}" required class="mt-2 text-center ml-3" style="width: 3rem;" />
                        </div>
                    </div>
                    <div class="flex items-center justify-center gap-6">
                        <div class="flex items-center justify-between" style="width: 200px;">
                            <input type="radio" id="home3" name="match" class="form-radio" title="Kapitan" value="3"
                            {{ old('match', $scores_captain) == '3' ? 'checked' : '' }} required>
                            <x-input-label for="home3" :value="$riders[2]" class="text-center ml-3"/>
                            <x-text-input type="number" step="1" name="home3" id="home3" value="{{ old('home3', $scores_home[2] ?? '') }}" required class="mt-2 text-center ml-3" style="width: 3rem;" />
                        </div>
                        <div class="flex items-center justify-between" style="width: 200px;">
                            <input type="radio" id="away3" name="match" class="form-radio" title="Kapitan" value="11"
                            {{ old('match', $scores_captain) == '11' ? 'checked' : '' }} required>
                            <x-input-label for="away3" :value="$riders[10]" class="text-center ml-3"/>
                            <x-text-input type="number" step="1" name="away3" id="away3" value="{{ old('away3', $scores_away[2] ?? '') }}" required class="mt-2 text-center ml-3" style="width: 3rem;" />
                        </div>
                    </div>
                    <div class="flex items-center justify-center gap-6">
                        <div class="flex items-center justify-between" style="width: 200px;">
                            <input type="radio" id="home4" name="match" class="form-radio" title="Kapitan" value="4"
                            {{ old('match', $scores_captain) == '4' ? 'checked' : '' }} required>
                            <x-input-label for="home4" :value="$riders[3]" class="text-center ml-3"/>
                            <x-text-input type="number" step="1" name="home4" id="home4" value="{{ old('home4', $scores_home[3] ?? '') }}" required class="mt-2 text-center ml-3" style="width: 3rem;" />
                        </div>
                        <div class="flex items-center justify-between" style="width: 200px;">
                            <input type="radio" id="away4" name="match" class="form-radio" title="Kapitan" value="12"
                            {{ old('match', $scores_captain) == '12' ? 'checked' : '' }} required>
                            <x-input-label for="away4" :value="$riders[11]" class="text-center ml-3"/>
                            <x-text-input type="number" step="1" name="away4" id="away4" value="{{ old('away4', $scores_away[3] ?? '') }}" required class="mt-2 text-center ml-3" style="width: 3rem;" />
                        </div>
                    </div>
                    <div class="flex items-center justify-center gap-6">
                        <div class="flex items-center justify-between" style="width: 200px;">
                            <input type="radio" id="home5" name="match" class="form-radio" title="Kapitan" value="5"
                            {{ old('match', $scores_captain) == '5' ? 'checked' : '' }} required>
                            <x-input-label for="home5" :value="$riders[4]" class="text-center ml-3"/>
                            <x-text-input type="number" step="1" name="home5" id="home5" value="{{ old('home5', $scores_home[4] ?? '') }}" required class="mt-2 text-center ml-3" style="width: 3rem;" />
                        </div>
                        <div class="flex items-center justify-between" style="width: 200px;">
                            <input type="radio" id="away5" name="match" class="form-radio" title="Kapitan" value="13"
                            {{ old('match', $scores_captain) == '13' ? 'checked' : '' }} required>
                            <x-input-label for="away5" :value="$riders[12]" class="text-center ml-3"/>
                            <x-text-input type="number" step="1" name="away5" id="away5" value="{{ old('away5', $scores_away[4] ?? '') }}" required class="mt-2 text-center ml-3" style="width: 3rem;" />
                        </div>
                    </div>
                    <div class="flex items-center justify-center gap-6">
                        <div class="flex items-center justify-between" style="width: 200px;">
                            <input type="radio" id="home6" name="match" class="form-radio" title="Kapitan" value="6"
                            {{ old('match', $scores_captain) == '6' ? 'checked' : '' }} required>
                            <x-input-label for="home6" :value="$riders[5]" class="text-center ml-3"/>
                            <x-text-input type="number" step="1" name="home6" id="home6" value="{{ old('home6', $scores_home[5] ?? '') }}" required class="mt-2 text-center ml-3" style="width: 3rem;" />
                        </div>
                        <div class="flex items-center justify-between" style="width: 200px;">
                            <input type="radio" id="away6" name="match" class="form-radio" title="Kapitan" value="14"
                            {{ old('match', $scores_captain) == '14' ? 'checked' : '' }} required>
                            <x-input-label for="away6" :value="$riders[13]" class="text-center ml-3"/>
                            <x-text-input type="number" step="1" name="away6" id="away6" value="{{ old('away6', $scores_away[5] ?? '') }}" required class="mt-2 text-center ml-3" style="width: 3rem;" />
                        </div>
                    </div>
                    <div class="flex items-center justify-center gap-6">
                        <div class="flex items-center justify-between" style="width: 200px;">
                            <input type="radio" id="home7" name="match" class="form-radio" title="Kapitan" value="7"
                            {{ old('match', $scores_captain) == '7' ? 'checked' : '' }} required>
                            <x-input-label for="home7" :value="$riders[6]" class="text-center ml-3"/>
                            <x-text-input type="number" step="1" name="home7" id="home7" value="{{ old('home7', $scores_home[6] ?? '') }}" required class="mt-2 text-center ml-3" style="width: 3rem;" />
                        </div>
                        <div class="flex items-center justify-between" style="width: 200px;">
                            <input type="radio" id="away7" name="match" class="form-radio" title="Kapitan" value="15"
                            {{ old('match', $scores_captain) == '15' ? 'checked' : '' }} required>
                            <x-input-label for="away7" :value="$riders[14]" class="text-center ml-3"/>
                            <x-text-input type="number" step="1" name="away7" id="away7" value="{{ old('away7', $scores_away[6] ?? '') }}" required class="mt-2 text-center ml-3" style="width: 3rem;" />
                        </div>
                    </div>
                    <div class="flex items-center justify-center gap-6">
                        <div class="flex items-center justify-between" style="width: 200px;">
                            <input type="radio" id="home8" name="match" class="form-radio" title="Kapitan" value="8"
                            {{ old('match', $scores_captain) == '8' ? 'checked' : '' }} required>
                            <x-input-label for="home8" :value="$riders[7]" class="text-center ml-3"/>
                            <x-text-input type="number" step="1" name="home8" id="home8" value="{{ old('home8', $scores_home[7] ?? '') }}" required class="mt-2 text-center ml-3" style="width: 3rem;" />
                        </div>
                        <div class="flex items-center justify-between" style="width: 200px;">
                            <input type="radio" id="away8" name="match" class="form-radio" title="Kapitan" value="16"
                            {{ old('match', $scores_captain) == '16' ? 'checked' : '' }} required>
                            <x-input-label for="away8" :value="$riders[15]" class="text-center ml-3"/>
                            <x-text-input type="number" step="1" name="away8" id="away8" value="{{ old('away8', $scores_away[7] ?? '') }}" required class="mt-2 text-center ml-3" style="width: 3rem;" />
                        </div>
                    </div>
                </div>


                <!-- sekcja 3 -->
                <div class="flex items-center justify-center mt-6">
                    <strong>Sekcja 3</strong>
                </div>
                <div class="flex items-center justify-center mb-6">
                    <p>Head 2 Head</p>
                </div>

                <div class="flex-wrap space-y-3">
                    <div class="flex items-center justify-center gap-6 mt-3">
                        <div class="flex items-center justify-between" style="width: 120px;">
                            <x-input-label for="h_duel1" :value="$h2hs[0]" class="text-center"/>
                            <input type="radio" id="h_duel1" name="duel1" class="form-radio ml-3" value="home"
                            {{ old('duel1', $h2h_picks[0] ?? '') == 'home' ? 'checked' : '' }} required>
                        </div>
                        <div class="flex items-center justify-between" style="width: 120px;">
                            <input type="radio" id="a_duel1" name="duel1" class="form-radio" value="away"
                            {{ old('duel1', $h2h_picks[0] ?? '') == 'away' ? 'checked' : '' }} required>
                            <x-input-label for="a_duel1" :value="$h2hs[5]" class="text-center  ml-3"/>
                        </div>
                    </div>
                    <div class="flex items-center justify-center gap-6 mt-3">
                        <div class="flex items-center justify-between" style="width: 120px;">
                            <x-input-label for="h_duel2" :value="$h2hs[1]" class="text-center"/>
                            <input type="radio" id="h_duel2" name="duel2" class="form-radio ml-3" value="home"
                            {{ old('duel2', $h2h_picks[1] ?? '') == 'home' ? 'checked' : '' }} required>
                        </div>
                        <div class="flex items-center justify-between" style="width: 120px;">
                            <input type="radio" id="a_duel2" name="duel2" class="form-radio" value="away"
                            {{ old('duel2', $h2h_picks[1] ?? '') == 'away' ? 'checked' : '' }} required>
                            <x-input-label for="a_duel2" :value="$h2hs[6]" class="text-center  ml-3"/>
                        </div>
                    </div><div class="flex items-center justify-center gap-6 mt-3">
                        <div class="flex items-center justify-between" style="width: 120px;">
                            <x-input-label for="h_duel3" :value="$h2hs[2]" class="text-center"/>
                            <input type="radio" id="h_duel3" name="duel3" class="form-radio ml-3" value="home"
                            {{ old('duel3', $h2h_picks[2] ?? '') == 'home' ? 'checked' : '' }} required>
                        </div>
                        <div class="flex items-center justify-between" style="width: 120px;">
                            <input type="radio" id="a_duel3" name="duel3" class="form-radio" value="away"
                            {{ old('duel3', $h2h_picks[2] ?? '') == 'away' ? 'checked' : '' }} required>
                            <x-input-label for="a_duel3" :value="$h2hs[7]" class="text-center  ml-3"/>
                        </div>
                    </div><div class="flex items-center justify-center gap-6 mt-3">
                        <div class="flex items-center justify-between" style="width: 120px;">
                            <x-input-label for="h_duel4" :value="$h2hs[3]" class="text-center"/>
                            <input type="radio" id="h_duel4" name="duel4" class="form-radio ml-3" value="home"
                            {{ old('duel4', $h2h_picks[3] ?? '') == 'home' ? 'checked' : '' }} required>
                        </div>
                        <div class="flex items-center justify-between" style="width: 120px;">
                            <input type="radio" id="a_duel4" name="duel4" class="form-radio" value="away"
                            {{ old('duel4', $h2h_picks[3] ?? '') == 'away' ? 'checked' : '' }} required>
                            <x-input-label for="a_duel4" :value="$h2hs[8]" class="text-center  ml-3"/>
                        </div>
                    </div><div class="flex items-center justify-center gap-6 mt-3">
                        <div class="flex items-center justify-between" style="width: 120px;">
                            <x-input-label for="h_duel5" :value="$h2hs[4]" class="text-center"/>
                            <input type="radio" id="h_duel5" name="duel5" class="form-radio ml-3" value="home"
                            {{ old('duel5', $h2h_picks[4] ?? '') == 'home' ? 'checked' : '' }} required>
                        </div>
                        <div class="flex items-center justify-between" style="width: 120px;">
                            <input type="radio" id="a_duel5" name="duel5" class="form-radio" value="away"
                            {{ old('duel5', $h2h_picks[4] ?? '') == 'away' ? 'checked' : '' }} required>
                            <x-input-label for="a_duel5" :value="$h2hs[9]" class="text-center  ml-3"/>
                        </div>
                    </div>
                </div>


                <!-- sekcja 4 -->
                <div class="flex items-center justify-center mt-6">
                    <strong>Sekcja 4</strong>
                </div>
                <div class="flex items-center justify-center mb-6">
                    <p>Pewniaczki buka</p>
                </div>

                <div class="flex-wrap space-y-3 mx-auto" style="width: 700px;" >

                    <!-- Fioletowe -->
                    <div class="flex items-center justify-center gap-6 mt-3">
                        <div class="flex items-center">
                            <x-input-label :value="$betText[0]" class="text-center bet bet-purple" style="width: 400px; word-wrap: break-word; white-space: normal;"/>
                        </div>
                        <div class="flex items-center">
                            <button type="button" id="yes_bet1" class="bet-button" onclick="selectBet('tak', 'bet1', 'oddBet1', 'purple', this, '{{ $oddYes[0] }}')" style="width: 100px">
                                <strong>tak</strong> x{{ $oddYes[0] }} 
                            </button>
                            <button type="button" id="no_bet1" class="bet-button ml-3" onclick="selectBet('nie', 'bet1', 'oddBet1', 'purple', this, '{{ $oddNo[0] }}')" style="width: 100px">
                                <strong>nie</strong> x{{ $oddNo[0] }}
                            </button>
                            <!-- Ukryte pole input do przechowywania wybranej wartości -->
                            <input type="hidden" name="bet1" id="bet1" value="">
                            <input type="hidden" name="oddBet1" id="oddBet1" value="">
                        </div>
                    </div>
                    <div class="flex items-center justify-center gap-6 mt-3">
                        <div class="flex items-center">
                            <x-input-label :value="$betText[1]" class="text-center bet bet-purple" style="width: 400px; word-wrap: break-word; white-space: normal;"/>
                        </div>
                        <div class="flex items-center">
                            <button type="button" id="yes_bet2" class="bet-button" onclick="selectBet('tak', 'bet2', 'oddBet2', 'purple', this, '{{ $oddYes[1] }}')" style="width: 100px">
                                <strong>tak</strong> x{{ $oddYes[1] }} 
                            </button>
                            <button type="button" id="no_bet2" class="bet-button ml-3" onclick="selectBet('nie', 'bet2', 'oddBet2', 'purple', this, '{{ $oddNo[1] }}')" style="width: 100px">
                                <strong>nie</strong> x{{ $oddNo[1] }}
                            </button>
                            <!-- Ukryte pole input do przechowywania wybranej wartości -->
                            <input type="hidden" name="bet2" id="bet2" value="">
                            <input type="hidden" name="oddBet2" id="oddBet2" value="">
                        </div>
                    </div>
                    <div class="flex items-center justify-center gap-6 mt-3">
                        <div class="flex items-center">
                            <x-input-label :value="$betText[2]" class="text-center bet bet-purple" style="width: 400px; word-wrap: break-word; white-space: normal;"/>
                        </div>
                        <div class="flex items-center">
                            <button type="button" id="yes_bet3" class="bet-button" onclick="selectBet('tak', 'bet3', 'oddBet3', 'purple', this, '{{ $oddYes[2] }}')" style="width: 100px">
                                <strong>tak</strong> x{{ $oddYes[2] }} 
                            </button>
                            <button type="button" id="no_bet3" class="bet-button ml-3" onclick="selectBet('nie', 'bet3', 'oddBet3', 'purple', this, '{{ $oddNo[2] }}')" style="width: 100px">
                                <strong>nie</strong> x{{ $oddNo[2] }}
                            </button>
                            <!-- Ukryte pole input do przechowywania wybranej wartości -->
                            <input type="hidden" name="bet3" id="bet3" value="">
                            <input type="hidden" name="oddBet3" id="oddBet3" value="">
                        </div>
                    </div>
                    <div class="flex items-center justify-center gap-6 mt-3">
                        <div class="flex items-center">
                            <x-input-label :value="$betText[3]" class="text-center bet bet-purple" style="width: 400px; word-wrap: break-word; white-space: normal;"/>
                        </div>
                        <div class="flex items-center">
                            <button type="button" id="yes_bet4" class="bet-button" onclick="selectBet('tak', 'bet4', 'oddBet4', 'purple', this, '{{ $oddYes[3] }}')" style="width: 100px">
                                <strong>tak</strong> x{{ $oddYes[3] }}  
                            </button>
                            <button type="button" id="no_bet4" class="bet-button ml-3" onclick="selectBet('nie', 'bet4', 'oddBet4', 'purple', this, '{{ $oddNo[3] }}')" style="width: 100px">
                                <strong>nie</strong> x{{ $oddNo[3] }}
                            </button>
                            <!-- Ukryte pole input do przechowywania wybranej wartości -->
                            <input type="hidden" name="bet4" id="bet4" value="">
                            <input type="hidden" name="oddBet4" id="oddBet4" value="">
                        </div>
                    </div>
                    <div class="flex items-center justify-center gap-6 mt-3">
                        <div class="flex items-center">
                            <x-input-label :value="$betText[4]" class="text-center bet bet-purple" style="width: 400px; word-wrap: break-word; white-space: normal;" />
                        </div>
                        <div class="flex items-center">
                            <button type="button" id="yes_bet5" class="bet-button" onclick="selectBet('tak', 'bet5', 'oddBet5', 'purple', this, '{{ $oddYes[4] }}')" style="width: 100px">
                                <strong>tak</strong> x{{ $oddYes[4] }}  
                            </button>
                            <button type="button" id="no_bet5" class="bet-button ml-3" onclick="selectBet('nie', 'bet5', 'oddBet5', 'purple', this, '{{ $oddNo[4] }}')" style="width: 100px">
                                <strong>nie</strong> x{{ $oddNo[4] }}
                            </button>
                            <!-- Ukryte pole input do przechowywania wybranej wartości -->
                            <input type="hidden" name="bet5" id="bet5" value="">
                            <input type="hidden" name="oddBet5" id="oddBet5" value="">
                        </div>
                    </div>

                    <!-- bezowe -->
                    <div class="flex items-center justify-center gap-6 mt-3">
                        <div class="flex items-center">
                            <x-input-label :value="$betText[5]" class="text-center bet bet-beige" style="width: 400px; word-wrap: break-word; white-space: normal;"/>
                        </div>
                        <div class="flex items-center">
                            <button type="button" id="yes_bet6" class="bet-button" onclick="selectBet('tak', 'bet6', 'oddBet6', 'beige', this, '{{ $oddYes[5] }}')" style="width: 100px">
                                <strong>tak</strong> x{{ $oddYes[5] }} 
                            </button>
                            <button type="button" id="no_bet6" class="bet-button ml-3" onclick="selectBet('nie', 'bet6', 'oddBet6', 'beige', this, '{{ $oddNo[5] }}')" style="width: 100px">
                                <strong>nie</strong> x{{ $oddNo[5] }}
                            </button>
                            <!-- Ukryte pole input do przechowywania wybranej wartości -->
                            <input type="hidden" name="bet6" id="bet6" value="">
                            <input type="hidden" name="oddBet6" id="oddBet6" value="">
                        </div>
                    </div>
                    <div class="flex items-center justify-center gap-6 mt-3">
                        <div class="flex items-center">
                            <x-input-label :value="$betText[6]" class="text-center bet bet-beige" style="width: 400px; word-wrap: break-word; white-space: normal;"/>
                        </div>
                        <div class="flex items-center">
                            <button type="button" id="yes_bet7" class="bet-button" onclick="selectBet('tak', 'bet7', 'oddBet7', 'beige', this, '{{ $oddYes[6] }}')" style="width: 100px">
                                <strong>tak</strong> x{{ $oddYes[6] }} 
                            </button>
                            <button type="button" id="no_bet7" class="bet-button ml-3" onclick="selectBet('nie', 'bet7', 'oddBet7', 'beige', this, '{{ $oddNo[6] }}')" style="width: 100px">
                                <strong>nie</strong> x{{ $oddNo[6] }}
                            </button>
                            <!-- Ukryte pole input do przechowywania wybranej wartości -->
                            <input type="hidden" name="bet7" id="bet7" value="">
                            <input type="hidden" name="oddBet7" id="oddBet7" value="">
                        </div>
                    </div>
                    <div class="flex items-center justify-center gap-6 mt-3">
                        <div class="flex items-center">
                            <x-input-label :value="$betText[7]" class="text-center bet bet-beige" style="width: 400px; word-wrap: break-word; white-space: normal;"/>
                        </div>
                        <div class="flex items-center">
                            <button type="button" id="yes_bet8" class="bet-button" onclick="selectBet('tak', 'bet8', 'oddBet8', 'beige', this, '{{ $oddYes[7] }}')" style="width: 100px">
                                <strong>tak</strong> x{{ $oddYes[7] }} 
                            </button>
                            <button type="button" id="no_bet8" class="bet-button ml-3" onclick="selectBet('nie', 'bet8', 'oddBet8', 'beige', this, '{{ $oddNo[7] }}')" style="width: 100px">
                                <strong>nie</strong> x{{ $oddNo[7] }}
                            </button>
                            <!-- Ukryte pole input do przechowywania wybranej wartości -->
                            <input type="hidden" name="bet8" id="bet8" value="">
                            <input type="hidden" name="oddBet8" id="oddBet8" value="">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-center mt-3">
                    <x-input-label for="bet_amount" :value="__('Obstaw')" class="text-center"/>
                    <x-text-input type="number" step="1" name="bet_amount" id="bet_amount" value="{{ old('bet_amount', $bet_amount) }}" class="mt-2 text-center ml-3" style="width: 5rem;" oninput="calculateWinnings()"/>
                    <p class="ml-3">Kurs: <span id="current_odd"></span></p>
                    <p class="ml-3">Do wygrania: <span id="winnings"></span></p>
                    <input type="hidden" name="win" id="win" value="">
                </div>

                <!-- Przycisk wyslania -->
                <div class="flex items-center justify-center mt-6">
                    <x-primary-button class="ms-3 mb-6" type="submit">
                        {{ __('Zapisz') }}
                    </x-primary-button>
                </div>
            </div>                            
        </form>
    </body>
    
    <script>
        let currentOdd = 1;
        let purpleCount = 0;
        let beigeCount = 0;
        let maxPurpleBets = 3;
        let maxBeigeBets = 1;

        const closesAt = '{{ $closes_at }}';
        const bets = JSON.parse(@json($bets));
        const odds = JSON.parse(@json($odds));
        //console.log(bets);

        document.getElementById('current_odd').textContent = currentOdd;

        // na poczatku zaznaczenie poprawnych buttonow z bazy
        function loadButtons(){
            bets.forEach((element, index) => {
                if(element === "tak"){
                    document.getElementById("yes_bet" + (index + 1)).classList.add('selected-bet-button');
                    
                }else if(element === "nie"){
                    document.getElementById("no_bet" + (index + 1)).classList.add('selected-bet-button');
                    
                }
                if(element !== null){
                    document.getElementById("bet" + (index + 1)).value = element;

                    if(index < 5){
                        purpleCount += 1;
                    }else{
                        beigeCount += 1;
                    }
                }
                
            });

            odds.forEach((element, index) => {
                if(element !== null) {
                    document.getElementById("oddBet" + (index + 1)).value = element;
                }
            });

            //console.log(beigeCount, purpleCount);
            calculateOdd();
        }

        function selectBet(value, inputId, oddInput, color, button, odd) {

            // Znajdź ukryte pole input
            let input = document.getElementById(inputId);
            let oddInp = document.getElementById(oddInput);
        
            // Jeśli przycisk jest już wybrany, odznacz go
            if (button.classList.contains('selected-bet-button')) {
                button.classList.remove('selected-bet-button');
                input.value = ''; // Wyczyść wartość w ukrytym polu input
                oddInp.value = '';
                if (color == 'beige'){
                    beigeCount -= 1;
                }else{
                    purpleCount -= 1;
                }
            } else {
                // Zresetuj wszystkie przyciski w tej grupie
                let buttons = button.parentElement.getElementsByClassName('bet-button');
                for (let i = 0; i < buttons.length; i++) {
                    if (buttons[i].classList.contains('selected-bet-button')){
                        buttons[i].classList.remove('selected-bet-button'); // Usuń wybraną klasę

                        // przy zmianie z tak na nie i na odwrot
                        if (color == 'beige'){
                            beigeCount -= 1;
                        }else{
                            purpleCount -= 1;
                        }
                    }
                    
                }

                if (color == 'purple' && purpleCount >= maxPurpleBets){
                    return;
                }
                if (color == 'beige' && beigeCount >= maxBeigeBets){
                    return;
                }
        
                // Ustaw wybrany styl na klikniętym przycisku
                button.classList.add('selected-bet-button'); // Dodaj wybraną klasę
        
                // Ustaw wartość w ukrytym polu input
                input.value = value;
                oddInp.value = odd;
                console.log(oddInp.value);
                // currentOdd = currentOdd * odd;

                if (color == 'beige'){
                    beigeCount += 1;
                }else{
                    purpleCount += 1;
                }
            }

            calculateOdd();

        }

        function calculateOdd(){
            currentOdd = 1;
            let oddYes = <?php echo json_encode($oddYes); ?>;
            let oddNo = <?php echo json_encode($oddNo); ?>;
            for (let i = 1; i <= 8; i++){
                let input = document.getElementById('bet' + i);
                if (input.value === "tak"){
                    currentOdd *= oddYes[i-1];
                }else if (input.value === "nie"){
                    currentOdd *= oddNo[i-1];
                }else{
                    currentOdd *= 1;
                }
            }

            const betAmountField = document.getElementById('bet_amount');
            if (currentOdd > 1){
                betAmountField.setAttribute('required', true);
            } else {
                betAmountField.removeAttribute('required');
            }


            document.getElementById('current_odd').textContent = currentOdd.toFixed(2);
            calculateWinnings(); // Przelicz wygraną
        }

        function calculateWinnings(){
            // znajdz pole win
            let win = document.getElementById('win');

            let betAmount = parseFloat(document.getElementById('bet_amount').value) || 0;
            let winnings = betAmount * currentOdd.toFixed(2);
            document.getElementById('winnings').textContent = winnings.toFixed(2);
            win.value = winnings;
        }

        function updateCountdown() {
            // Konwertuj datę zamknięcia na obiekt Date
            const targetDate = new Date(closesAt.toLocaleString('en-US', { timeZone: 'Europe/Warsaw' }));

            // Pobierz aktualny czas
            const now = new Date().getTime();

            // Oblicz różnicę w milisekundach
            const timeLeft = targetDate - now;

            // Sprawdź, czy odliczanie się zakończyło
            if (timeLeft <= 0) {
                document.getElementById('countdown').innerHTML = 'Czas minął!';
                clearInterval(intervalId); // Zatrzymaj odliczanie
                document.getElementById("overlay").style.display = "block"
                return;
            }

            document.getElementById("overlay").style.display = "none";
            // Oblicz dni, godziny, minuty i sekundy
            const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

            // Wyświetl odliczanie
            document.getElementById('countdown').innerHTML = 
                `${days} dni ${hours} godz ${minutes} min ${seconds} sek`;
        }

        const intervalId = setInterval(updateCountdown, 1000);

        // zaladowanie zaznaczen buttonow
        loadButtons();

        // Wywołaj raz, aby natychmiast pokazać odliczanie
        updateCountdown();
    </script>
</x-app-layout>