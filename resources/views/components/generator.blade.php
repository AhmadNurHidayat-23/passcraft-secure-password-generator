@props([
    'password' => '',
    'strength' => 'Sangat Kuat',
    'entropy' => 0,
    'length' => 16,
    'uppercase' => true,
    'lowercase' => true,
    'numbers' => true,
    'symbols' => true,
])

<div class="generator-container" id="passcraft-generator">
    {{-- 1 & 2: Kolom hasil kata sandi dan tombol salin --}}
    <div class="output-box">
        <input 
            type="text" 
            id="password-output" 
            class="password-input" 
            value="{{ $password }}" 
            readonly 
            autocomplete="off"
            spellcheck="false"
            aria-label="Hasil Kata Sandi"
        >
        <button 
            type="button" 
            id="btn-copy" 
            class="btn-copy" 
            aria-label="Salin kata sandi ke clipboard"
            title="Salin kata sandi"
        >
            <svg class="copy-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
            </svg>
            <span id="copy-text">Salin</span>
        </button>
    </div>

    {{-- Form pengontrol generator --}}
    <form id="password-form" method="POST" action="{{ route('generate') }}" class="generator-form">
        @csrf

        {{-- 3: Pengaturan panjang kata sandi menggunakan slider --}}
        <div class="form-group length-group">
            <div class="length-header">
                <label for="length-slider" class="form-label">Panjang Kata Sandi</label>
                <span id="length-display" class="length-value">{{ $length }}</span>
            </div>
            <input 
                type="range" 
                id="length-slider" 
                name="length" 
                min="6" 
                max="64" 
                value="{{ $length }}" 
                class="length-slider"
                aria-label="Pengaturan panjang karakter"
            >
            <div class="length-bounds">
                <span>6</span>
                <span>64</span>
            </div>
        </div>

        {{-- 4, 5, 6, 7: Checkbox opsi karakter --}}
        <div class="form-group options-group">
            <label class="options-title">Karakter yang Disertakan</label>
            <div class="checkbox-grid">
                <label class="checkbox-label" for="opt-uppercase">
                    <input 
                        type="checkbox" 
                        id="opt-uppercase" 
                        name="uppercase" 
                        value="1" 
                        class="checkbox-input" 
                        {{ $uppercase ? 'checked' : '' }}
                    >
                    <span class="checkbox-text">Huruf Besar (A-Z)</span>
                </label>

                <label class="checkbox-label" for="opt-lowercase">
                    <input 
                        type="checkbox" 
                        id="opt-lowercase" 
                        name="lowercase" 
                        value="1" 
                        class="checkbox-input" 
                        {{ $lowercase ? 'checked' : '' }}
                    >
                    <span class="checkbox-text">Huruf Kecil (a-z)</span>
                </label>

                <label class="checkbox-label" for="opt-numbers">
                    <input 
                        type="checkbox" 
                        id="opt-numbers" 
                        name="numbers" 
                        value="1" 
                        class="checkbox-input" 
                        {{ $numbers ? 'checked' : '' }}
                    >
                    <span class="checkbox-text">Angka (0-9)</span>
                </label>

                <label class="checkbox-label" for="opt-symbols">
                    <input 
                        type="checkbox" 
                        id="opt-symbols" 
                        name="symbols" 
                        value="1" 
                        class="checkbox-input" 
                        {{ $symbols ? 'checked' : '' }}
                    >
                    <span class="checkbox-text">Simbol (!@#$)</span>
                </label>
            </div>
            <p id="options-warning" class="options-warning" style="display: none;">
                Pilih minimal satu jenis karakter.
            </p>
        </div>

        {{-- 8: Indikator kekuatan sederhana berupa teks kecil --}}
        <div class="strength-row">
            <span class="strength-caption">Kekuatan:</span>
            <span id="strength-text" class="strength-value">{{ $strength }}</span>
        </div>

        {{-- 9: Satu tombol utama hitam bertuliskan "Buat Kata Sandi" --}}
        <button type="submit" id="btn-generate" class="btn-primary">
            Buat Kata Sandi
        </button>
    </form>
</div>

