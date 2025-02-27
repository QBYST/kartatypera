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

            .bet{
                flex-shrink: 0; /* Zabezpiecza przed zmniejszaniem */
                width: auto;
                padding: 10px 20px; /* Zwiększa wewnętrzne odstępy */
                display: inline-block;
                white-space: nowrap; /* Zabezpiecza przed zawijaniem tekstu */
                text-align: right;
            }

            .bet-beige{
                background-color: rgb(223, 203, 167);
            }

            .bet-purple{
                background-color: rgb(68, 14, 153);
                color: white;
            }
        </style>
    </head>

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

    <!-- formularz -->
    <form action="{{ route('weekly-pick-panel.store') }}" method="POST" style="padding-top: 20px">
        @csrf
        <div class="flex-wrap">

            <!-- tydzien i zamkniecie -->
            <div class="flex items-center justify-center mt-3">
                <x-input-label for="week" :value="__('Tydzień ') . $week" class="text-center"/>
                {{-- <x-text-input type="number" step="1" name="week" id="week" value="{{ old('week') }}" required class="mt-2 text-center ml-3" style="width: 5rem;" /> --}}
                <input type="hidden" name="week" id="week" value={{ $week }}>
            </div>
            <div class="flex items-center justify-center mt-3">
                <x-input-label for="time" :value="__('Zamyka się')" class="text-center"/>
                <x-text-input type="time" step="1" name="time" id="time" value="{{ old('time', $closesAtTime) }}" required class="mt-2 text-center ml-3" style="width: 8rem;" />
                <x-text-input type="date" step="1" name="date" id="date" value="{{ old('date', $closesAtDate) }}" required class="mt-2 text-center ml-3" style="width: 10rem;" />
            </div>

            <!-- sekcja 1 -->
            <div class="flex items-center justify-center mt-6">
                <strong>Sekcja 1</strong>
            </div>
            <div class="flex items-center justify-center">
                <p>Zespoły</p>
            </div>

            <div class="flex items-center justify-center mb-6 gap-4 mt-3">
                <div class="w-1/3 flex flex-col items-center">
                    <x-input-label for="home" :value="__('Zespół 1')" class="text-center"/>
                    <x-text-input type="text" name="home" id="home" value="{{ old('home', $teams[0]  ?? '') }}" required class="mt-2 text-center" style="width: 12rem;" />
                </div>
                <div class="w-1/3 flex flex-col items-center">
                    <x-input-label for="away" :value="__('Zespół 2')" class="text-center"/>
                    <x-text-input type="text" name="away" id="away" value="{{ old('away', $teams[1]  ?? '') }}" required class="mt-2 text-center" style="width: 12rem;" />
                </div>
            </div>

            <!-- sekcja 2 -->
            <div class="flex items-center justify-center mt-6">
                <strong>Sekcja 2</strong>
            </div>
            <div class="flex items-center justify-center">
                <p>Zawodnicy</p>
            </div>
            <div class="flex items-center justify-center gap-4 mt-3">
                <div class="w-1/3 flex flex-col items-center">
                    <x-input-label for="rider1a" :value="__('Zespół 1')" class="text-center"/>
                    <x-text-input type="text" name="rider1a" id="rider1a" value="{{ old('rider1a', $riders[0]  ?? '') }}" required class="mt-2 text-center" style="width: 12rem;" placeholder="1."/>
                </div>
                <div class="w-1/3 flex flex-col items-center">
                    <x-input-label for="away" :value="__('Zespół 2')" class="text-center"/>
                    <x-text-input type="text" name="rider1b" id="rider1b" value="{{ old('rider1b', $riders[8]  ?? '') }}" required class="mt-2 text-center" style="width: 12rem;" placeholder="1."/>
                </div>
            </div>
            <div class="flex items-center justify-center mt-2 gap-4">
                <div class="w-1/3 flex flex-col items-center">
                    <x-text-input type="text" name="rider2a" id="rider2a" value="{{ old('rider2a', $riders[1]  ?? '') }}" required class="text-center" style="width: 12rem;" placeholder="2."/>
                </div>
                <div class="w-1/3 flex flex-col items-center">
                    <x-text-input type="text" name="rider2b" id="rider2b" value="{{ old('rider2b', $riders[9]  ?? '') }}" required class="text-center" style="width: 12rem;" placeholder="2."/>
                </div>
            </div>
            <div class="flex items-center justify-center mt-2 gap-4">
                <div class="w-1/3 flex flex-col items-center">
                    <x-text-input type="text" name="rider3a" id="rider3a" value="{{ old('rider3a', $riders[2]  ?? '') }}" required class="text-center" style="width: 12rem;" placeholder="3."/>
                </div>
                <div class="w-1/3 flex flex-col items-center">
                    <x-text-input type="text" name="rider3b" id="rider3b" value="{{ old('rider3b', $riders[10]  ?? '') }}" required class="text-center" style="width: 12rem;" placeholder="3."/>
                </div>
            </div>
            <div class="flex items-center justify-center mt-2 gap-4">
                <div class="w-1/3 flex flex-col items-center">
                    <x-text-input type="text" name="rider4a" id="rider4a" value="{{ old('rider4a', $riders[3]  ?? '') }}" required class="text-center" style="width: 12rem;" placeholder="4."/>
                </div>
                <div class="w-1/3 flex flex-col items-center">
                    <x-text-input type="text" name="rider4b" id="rider4b" value="{{ old('rider4b', $riders[11]  ?? '') }}" required class="text-center" style="width: 12rem;" placeholder="4."/>
                </div>
            </div>
            <div class="flex items-center justify-center mt-2 gap-4">
                <div class="w-1/3 flex flex-col items-center">
                    <x-text-input type="text" name="rider5a" id="rider5a" value="{{ old('rider5a', $riders[4]  ?? '') }}" required class="text-center" style="width: 12rem;" placeholder="5."/>
                </div>
                <div class="w-1/3 flex flex-col items-center">
                    <x-text-input type="text" name="rider5b" id="rider5b" value="{{ old('rider5b', $riders[12]  ?? '') }}" required class="text-center" style="width: 12rem;" placeholder="5."/>
                </div>
            </div>
            <div class="flex items-center justify-center mt-2 gap-4">
                <div class="w-1/3 flex flex-col items-center">
                    <x-text-input type="text" name="rider6a" id="rider6a" value="{{ old('rider6a', $riders[5]  ?? '') }}" required class="text-center" style="width: 12rem;" placeholder="6."/>
                </div>
                <div class="w-1/3 flex flex-col items-center">
                    <x-text-input type="text" name="rider6b" id="rider6b" value="{{ old('rider6b', $riders[13]  ?? '') }}" required class="text-center" style="width: 12rem;" placeholder="6."/>
                </div>
            </div>
            <div class="flex items-center justify-center mt-2 gap-4">
                <div class="w-1/3 flex flex-col items-center">
                    <x-text-input type="text" name="rider7a" id="rider7a" value="{{ old('rider7a', $riders[6]  ?? '') }}" required class="text-center" style="width: 12rem;" placeholder="7."/>
                </div>
                <div class="w-1/3 flex flex-col items-center">
                    <x-text-input type="text" name="rider7b" id="rider7b" value="{{ old('rider7b', $riders[14]  ?? '') }}" required class="text-center" style="width: 12rem;" placeholder="7."/>
                </div>
            </div>
            <div class="flex items-center justify-center mt-2 gap-4">
                <div class="w-1/3 flex flex-col items-center">
                    <x-text-input type="text" name="rider8a" id="rider8a" value="{{ old('rider8a', $riders[7]  ?? '') }}" required class="text-center" style="width: 12rem;" placeholder="8."/>
                </div>
                <div class="w-1/3 flex flex-col items-center">
                    <x-text-input type="text" name="rider8b" id="rider8b" value="{{ old('rider8b', $riders[15]  ?? '') }}" required class="text-center" style="width: 12rem;" placeholder="8."/>
                </div>
            </div>

            <!-- sekcja 3 -->
            <div class="flex items-center justify-center mt-6">
                <strong>Sekcja 3</strong>
            </div>
            <div class="flex items-center justify-center ">
                <p>Head4head 😏</p>
            </div>

            <div class="flex items-center justify-center mt-3">
                <p>Starcie 1</p>
            </div>
            <div class="flex items-center justify-center gap-4">
                <div class="w-1/3 flex flex-col items-center">
                    <x-input-label for="head2head1a" :value="__('Zespół 1')" class="text-center"/>
                    <select id="head2head1a" name="head2head1a" required>
                        <?php 
                            // Zmienna domyślna
                            $selected = old('head2head1a', isset($h2h_names[0]) ? ($h2h_names[0] + 1) : '');
                            
                            // Wypisanie opcji
                            for ($i = 1; $i <= 8; $i++): 
                                // Ustawienie wybranej opcji
                                $isSelected = ($i == $selected) ? 'selected' : '';
                        ?>
                            <option value="<?= $i ?>" <?= $isSelected ?>><?= $i ?></option>
                        <?php endfor; ?> 
                    </select>
                </div>
                <div class="w-1/3 flex flex-col items-center">
                    <x-input-label for="head2head1b" :value="__('Zespół 2')" class="text-center"/>
                    <select id="head2head1b" required name="head2head1b">
                        <?php 
                            // Zmienna domyślna
                            $selected = old('head2head1b', isset($h2h_names[5]) ? ($h2h_names[5] - 7) : '');
                            
                            // Wypisanie opcji
                            for ($i = 1; $i <= 8; $i++): 
                                // Ustawienie wybranej opcji
                                $isSelected = ($i == $selected) ? 'selected' : '';
                        ?>
                            <option value="<?= $i ?>" <?= $isSelected ?>><?= $i ?></option>
                        <?php endfor; ?> 
                    </select>
                </div>
            </div>
            <div class="flex items-center justify-center">
                <p>Starcie 2</p>
            </div>
            <div class="flex items-center justify-center gap-4">
                <div class="w-1/3 flex flex-col items-center">
                    <x-input-label for="head2head2a" :value="__('Zespół 1')" class="text-center"/>
                    <select id="head2head2a" required name="head2head2a">
                        <?php 
                            // Zmienna domyślna
                            $selected = old('head2head2a', isset($h2h_names[1]) ? ($h2h_names[1] + 1) : '');
                            
                            // Wypisanie opcji
                            for ($i = 1; $i <= 8; $i++): 
                                // Ustawienie wybranej opcji
                                $isSelected = ($i == $selected) ? 'selected' : '';
                        ?>
                            <option value="<?= $i ?>" <?= $isSelected ?>><?= $i ?></option>
                        <?php endfor; ?> 
                    </select>
                </div>
                <div class="w-1/3 flex flex-col items-center">
                    <x-input-label for="head2head2b" :value="__('Zespół 2')" class="text-center"/>
                    <select id="head2head2b" required name="head2head2b">
                        <?php 
                            // Zmienna domyślna
                            $selected = old('head2head2b', isset($h2h_names[6]) ? ($h2h_names[6] - 7) : '');
                            
                            // Wypisanie opcji
                            for ($i = 1; $i <= 8; $i++): 
                                // Ustawienie wybranej opcji
                                $isSelected = ($i == $selected) ? 'selected' : '';
                        ?>
                            <option value="<?= $i ?>" <?= $isSelected ?>><?= $i ?></option>
                        <?php endfor; ?> 
                    </select>
                </div>
            </div>
            <div class="flex items-center justify-center">
                <p>Starcie 3</p>
            </div>
            <div class="flex items-center justify-center gap-4">
                <div class="w-1/3 flex flex-col items-center">
                    <x-input-label for="head2head3a" :value="__('Zespół 1')" class="text-center"/>
                    <select id="head2head3a" required name="head2head3a">
                        <?php 
                            // Zmienna domyślna
                            $selected = old('head2head3a', isset($h2h_names[2]) ? ($h2h_names[2] + 1) : '');
                            
                            // Wypisanie opcji
                            for ($i = 1; $i <= 8; $i++): 
                                // Ustawienie wybranej opcji
                                $isSelected = ($i == $selected) ? 'selected' : '';
                        ?>
                            <option value="<?= $i ?>" <?= $isSelected ?>><?= $i ?></option>
                        <?php endfor; ?> 
                    </select>
                </div>
                <div class="w-1/3 flex flex-col items-center">
                    <x-input-label for="head2head3b" :value="__('Zespół 2')" class="text-center"/>
                    <select id="head2head3b" required name="head2head3b">
                        <?php 
                            // Zmienna domyślna
                            $selected = old('head2head3b', isset($h2h_names[7]) ? ($h2h_names[7] - 7) : '');
                            
                            // Wypisanie opcji
                            for ($i = 1; $i <= 8; $i++): 
                                // Ustawienie wybranej opcji
                                $isSelected = ($i == $selected) ? 'selected' : '';
                        ?>
                            <option value="<?= $i ?>" <?= $isSelected ?>><?= $i ?></option>
                        <?php endfor; ?> 
                    </select>
                </div>
            </div>
            <div class="flex items-center justify-center">
                <p>Starcie 4</p>
            </div>
            <div class="flex items-center justify-center gap-4">
                <div class="w-1/3 flex flex-col items-center">
                    <x-input-label for="head2head4a" :value="__('Zespół 1')" class="text-center"/>
                    <select id="head2head4a" required name="head2head4a">
                        <?php 
                            // Zmienna domyślna
                            $selected = old('head2head4a', isset($h2h_names[3]) ? ($h2h_names[3] + 1) : '');
                            
                            // Wypisanie opcji
                            for ($i = 1; $i <= 8; $i++): 
                                // Ustawienie wybranej opcji
                                $isSelected = ($i == $selected) ? 'selected' : '';
                        ?>
                            <option value="<?= $i ?>" <?= $isSelected ?>><?= $i ?></option>
                        <?php endfor; ?> 
                    </select>
                </div>
                <div class="w-1/3 flex flex-col items-center">
                    <x-input-label for="head2head4b" :value="__('Zespół 2')" class="text-center"/>
                    <select id="head2head4b" required name="head2head4b">
                        <?php 
                            // Zmienna domyślna
                            $selected = old('head2head4b', isset($h2h_names[8]) ? ($h2h_names[8] - 7) : '');
                            
                            // Wypisanie opcji
                            for ($i = 1; $i <= 8; $i++): 
                                // Ustawienie wybranej opcji
                                $isSelected = ($i == $selected) ? 'selected' : '';
                        ?>
                            <option value="<?= $i ?>" <?= $isSelected ?>><?= $i ?></option>
                        <?php endfor; ?> 
                    </select>
                </div>
            </div>
            <div class="flex items-center justify-center">
                <p>Starcie 5</p>
            </div>
            <div class="flex items-center justify-center gap-4">
                <div class="w-1/3 flex flex-col items-center">
                    <x-input-label for="head2head5a" :value="__('Zespół 1')" class="text-center"/>
                    <select id="head2head5a" required name="head2head5a">
                        <?php 
                            // Zmienna domyślna
                            $selected = old('head2head5a', isset($h2h_names[4]) ? ($h2h_names[4] + 1) : '');
                            
                            // Wypisanie opcji
                            for ($i = 1; $i <= 8; $i++): 
                                // Ustawienie wybranej opcji
                                $isSelected = ($i == $selected) ? 'selected' : '';
                        ?>
                            <option value="<?= $i ?>" <?= $isSelected ?>><?= $i ?></option>
                        <?php endfor; ?> 
                    </select>
                </div>
                <div class="w-1/3 flex flex-col items-center">
                    <x-input-label for="head2head5b" :value="__('Zespół 2')" class="text-center"/>
                    <select id="head2head5b" required name="head2head5b">
                        <?php 
                            // Zmienna domyślna
                            $selected = old('head2head5b', isset($h2h_names[9]) ? ($h2h_names[9] - 7) : '');
                            
                            // Wypisanie opcji
                            for ($i = 1; $i <= 8; $i++): 
                                // Ustawienie wybranej opcji
                                $isSelected = ($i == $selected) ? 'selected' : '';
                        ?>
                            <option value="<?= $i ?>" <?= $isSelected ?>><?= $i ?></option>
                        <?php endfor; ?> 
                    </select>
                </div>
            </div>

            <!-- sekcja 4 -->
            <div class="flex items-center justify-center mt-6">
                <strong>Sekcja 4</strong>
            </div>
            <div class="flex items-center justify-center">
                <p>Bukozarobas</p>
            </div>

            <!-- fioletowe -->
            <div class="flex items-center justify-center gap-4 mt-3">
                <strong class="bet bet-purple">1.</strong>
                <textarea type="text" name="bet1" id="bet1" required class="mt-2 block" style="width: 25rem; height: 6rem;" placeholder="treść zakładu">{{ old('bet1', $bets[0]  ?? '') }}</textarea>
                <input type="hidden" name="bet_id1" value="{{ $bet_ids[0]  ?? '' }}">
                <div class="w-1/3 flex flex-col items-center">
                    <x-input-label for="odd1a" :value="__('Kurs tak')" class="text-center"/>
                    <x-text-input type="number" step="0.01" name="odd1a" id="odd1a" value="{{ old('odd1a', $odds_yes[0]  ?? '') }}" required class="mt-2 text-center" style="width: 5rem;" placeholder="1.85"/>
                </div>
                <div class="w-1/3 flex flex-col items-center">
                    <x-input-label for="odd1b" :value="__('Kurs nie')" class="text-center"/>
                    <x-text-input type="number" step="0.01" name="odd1b" id="odd1b" value="{{ old('odd1b', $odds_no[0]  ?? '') }}" required class="mt-2 text-center" style="width: 5rem;" placeholder="1.85"/>
                </div>
            </div>
            <div class="flex items-center justify-center gap-4 mt-3">
                <strong class="bet bet-purple">2.</strong>
                <textarea type="text" name="bet2" id="bet2" required class="mt-2 block" style="width: 25rem; height: 6rem;" placeholder="treść zakładu">{{ old('bet2', $bets[1]  ?? '') }}</textarea>
                <input type="hidden" name="bet_id2" value="{{ $bet_ids[1]  ?? '' }}">
                <div class="w-1/3 flex flex-col items-center">
                    <x-input-label for="odd2a" :value="__('Kurs tak')" class="text-center"/>
                    <x-text-input type="number" step="0.01" name="odd2a" id="odd2a" value="{{ old('odd2a', $odds_yes[1]  ?? '') }}" required class="mt-2 text-center" style="width: 5rem;" placeholder="1.85"/>
                </div>
                <div class="w-1/3 flex flex-col items-center">
                    <x-input-label for="odd2b" :value="__('Kurs nie')" class="text-center"/>
                    <x-text-input type="number" step="0.01" name="odd2b" id="odd2b" value="{{ old('odd2b', $odds_no[1]  ?? '') }}" required class="mt-2 text-center" style="width: 5rem;" placeholder="1.85"/>
                </div>
            </div>
            <div class="flex items-center justify-center gap-4 mt-3">
                <strong class="bet bet-purple">3.</strong>
                <textarea type="text" name="bet3" id="bet3" required class="mt-2 block" style="width: 25rem; height: 6rem;" placeholder="treść zakładu">{{ old('bet3', $bets[2]  ?? '') }}</textarea>
                <input type="hidden" name="bet_id3" value="{{ $bet_ids[2]  ?? '' }}">
                <div class="w-1/3 flex flex-col items-center">
                    <x-input-label for="odd3a" :value="__('Kurs tak')" class="text-center"/>
                    <x-text-input type="number" step="0.01" name="odd3a" id="odd3a" value="{{ old('odd3a', $odds_yes[2]  ?? '') }}" required class="mt-2 text-center" style="width: 5rem;" placeholder="1.85"/>
                </div>
                <div class="w-1/3 flex flex-col items-center">
                    <x-input-label for="odd3b" :value="__('Kurs nie')" class="text-center"/>
                    <x-text-input type="number" step="0.01" name="odd3b" id="odd3b" value="{{ old('odd3b', $odds_no[2]  ?? '') }}" required class="mt-2 text-center" style="width: 5rem;" placeholder="1.85"/>
                </div>
            </div>
            <div class="flex items-center justify-center gap-4 mt-3">
                <strong class="bet bet-purple">4.</strong>
                <textarea type="text" name="bet4" id="bet4" required class="mt-2 block" style="width: 25rem; height: 6rem;" placeholder="treść zakładu">{{ old('bet4', $bets[3]  ?? '') }}</textarea>
                <input type="hidden" name="bet_id4" value="{{ $bet_ids[3]  ?? '' }}">
                <div class="w-1/3 flex flex-col items-center">
                    <x-input-label for="odd4a" :value="__('Kurs tak')" class="text-center"/>
                    <x-text-input type="number" step="0.01" name="odd4a" id="odd4a" value="{{ old('odd4a', $odds_yes[3]  ?? '') }}" required class="mt-2 text-center" style="width: 5rem;" placeholder="1.85"/>
                </div>
                <div class="w-1/3 flex flex-col items-center">
                    <x-input-label for="odd4b" :value="__('Kurs nie')" class="text-center"/>
                    <x-text-input type="number" step="0.01" name="odd4b" id="odd4b" value="{{ old('odd4b', $odds_no[3]  ?? '') }}" required class="mt-2 text-center" style="width: 5rem;" placeholder="1.85"/>
                </div>
            </div>
            <div class="flex items-center justify-center gap-4 mt-3">
                <strong class="bet bet-purple">5.</strong>
                <textarea type="text" name="bet5" id="bet5" required class="mt-2 block" style="width: 25rem; height: 6rem;" placeholder="treść zakładu">{{ old('bet5', $bets[4]  ?? '') }}</textarea>
                <input type="hidden" name="bet_id5" value="{{ $bet_ids[4]  ?? '' }}">
                <div class="w-1/3 flex flex-col items-center">
                    <x-input-label for="odd5a" :value="__('Kurs tak')" class="text-center"/>
                    <x-text-input type="number" step="0.01" name="odd5a" id="odd5a" value="{{ old('odd5a', $odds_yes[4]  ?? '') }}" required class="mt-2 text-center" style="width: 5rem;" placeholder="1.85"/>
                </div>
                <div class="w-1/3 flex flex-col items-center">
                    <x-input-label for="odd5b" :value="__('Kurs nie')" class="text-center"/>
                    <x-text-input type="number" step="0.01" name="odd5b" id="odd5b" value="{{ old('odd5b', $odds_no[4]  ?? '') }}" required class="mt-2 text-center" style="width: 5rem;" placeholder="1.85"/>
                </div>
            </div>
            <!-- bezowe -->
            <div class="flex items-center justify-center gap-4 mt-3">
                <strong class="bet bet-beige">6.</strong>
                <textarea type="text" name="bet6" id="bet6" required class="mt-2 block" style="width: 25rem; height: 6rem;" placeholder="treść zakładu">{{ old('bet6', $bets[5]  ?? '') }}</textarea>
                <input type="hidden" name="bet_id6" value="{{ $bet_ids[5]  ?? '' }}">
                <div class="w-1/3 flex flex-col items-center">
                    <x-input-label for="odd6a" :value="__('Kurs tak')" class="text-center"/>
                    <x-text-input type="number" step="0.01" name="odd6a" id="odd6a" value="{{ old('odd6a', $odds_yes[5]  ?? '') }}" required class="mt-2 text-center" style="width: 5rem;" placeholder="1.85"/>
                </div>
                <div class="w-1/3 flex flex-col items-center">
                    <x-input-label for="odd6b" :value="__('Kurs nie')" class="text-center"/>
                    <x-text-input type="number" step="0.01" name="odd6b" id="odd6b" value="{{ old('odd6b', $odds_no[5]  ?? '') }}" required class="mt-2 text-center" style="width: 5rem;" placeholder="1.85"/>
                </div>
            </div>
            <div class="flex items-center justify-center gap-4 mt-3">
                <strong class="bet bet-beige">7.</strong>
                <textarea type="text" name="bet7" id="bet7" required class="mt-2 block" style="width: 25rem; height: 6rem;" placeholder="treść zakładu">{{ old('bet7', $bets[6]  ?? '') }}</textarea>
                <input type="hidden" name="bet_id7" value="{{ $bet_ids[6]  ?? '' }}">
                <div class="w-1/3 flex flex-col items-center">
                    <x-input-label for="odd7a" :value="__('Kurs tak')" class="text-center"/>
                    <x-text-input type="number" step="0.01" name="odd7a" id="odd7a" value="{{ old('odd7a', $odds_yes[6]  ?? '') }}" required class="mt-2 text-center" style="width: 5rem;" placeholder="1.85"/>
                </div>
                <div class="w-1/3 flex flex-col items-center">
                    <x-input-label for="odd7b" :value="__('Kurs nie')" class="text-center"/>
                    <x-text-input type="number" step="0.01" name="odd7b" id="odd7b" value="{{ old('odd7b', $odds_no[6]  ?? '') }}" required class="mt-2 text-center" style="width: 5rem;" placeholder="1.85"/>
                </div>
            </div>
            <div class="flex items-center justify-center gap-4 mt-3">
                <strong class="bet bet-beige">8.</strong>
                <textarea type="text" name="bet8" id="bet8" required class="mt-2 block" style="width: 25rem; height: 6rem;" placeholder="treść zakładu">{{ old('bet8', $bets[7]  ?? '') }}</textarea>
                <input type="hidden" name="bet_id8" value="{{ $bet_ids[7]  ?? '' }}">
                <div class="w-1/3 flex flex-col items-center">
                    <x-input-label for="odd8a" :value="__('Kurs tak')" class="text-center"/>
                    <x-text-input type="number" step="0.01" name="odd8a" id="odd8a" value="{{ old('odd8a', $odds_yes[7]  ?? '') }}" required class="mt-2 text-center" style="width: 5rem;" placeholder="1.85"/>
                </div>
                <div class="w-1/3 flex flex-col items-center">
                    <x-input-label for="odd8b" :value="__('Kurs nie')" class="text-center"/>
                    <x-text-input type="number" step="0.01" name="odd8b" id="odd8b" value="{{ old('odd8b', $odds_no[7]  ?? '') }}" required class="mt-2 text-center" style="width: 5rem;" placeholder="1.85"/>
                </div>
            </div>

            <!-- Przycisk wyslania -->
            <div class="flex items-center justify-center mt-6">
                <x-primary-button class="ms-3 mb-6" type="submit">
                    {{ __('Zapisz') }}
                </x-primary-button>
            </div>
        </div>
    </form>
    <script>
        var h2hNames = <?php echo json_encode($bets); ?>;
        console.log(h2hNames);
    </script>
</x-app-layout>
