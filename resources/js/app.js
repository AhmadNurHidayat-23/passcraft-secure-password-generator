/**
 * PassCraft — Minimalist Client-side Password Generator & Interactions
 */

document.addEventListener('DOMContentLoaded', () => {
    const passwordOutput = document.getElementById('password-output');
    const copyBtn = document.getElementById('btn-copy');
    const copyText = document.getElementById('copy-text');
    const lengthSlider = document.getElementById('length-slider');
    const lengthDisplay = document.getElementById('length-display');
    const optUppercase = document.getElementById('opt-uppercase');
    const optLowercase = document.getElementById('opt-lowercase');
    const optNumbers = document.getElementById('opt-numbers');
    const optSymbols = document.getElementById('opt-symbols');
    const strengthText = document.getElementById('strength-text');
    const generateBtn = document.getElementById('btn-generate');
    const optionsWarning = document.getElementById('options-warning');
    const passwordForm = document.getElementById('password-form');

    if (!passwordOutput || !lengthSlider) return;

    const CHARSETS = {
        upper: 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
        lower: 'abcdefghijklmnopqrstuvwxyz',
        numbers: '0123456789',
        symbols: '!@#$%^&*()_+-=[]{}|;:,.<>?'
    };

    /**
     * Ambil bilangan acak kriptografis yang aman antara 0 dan max - 1
     */
    function secureRandomInt(max) {
        if (max <= 0) return 0;
        const array = new Uint32Array(1);
        window.crypto.getRandomValues(array);
        return array[0] % max;
    }

    /**
     * Hitung kekuatan kata sandi
     */
    function calculateStrength(length, typeCount, poolSize) {
        if (poolSize <= 0 || length <= 0) return 'Lemah';
        const entropy = length * (Math.log(poolSize) / Math.log(2));

        if (length < 8 || typeCount === 1 || entropy < 35) {
            return 'Lemah';
        }
        if (length < 12 || typeCount < 3 || entropy < 55) {
            return 'Sedang';
        }
        if (length < 16 || typeCount < 4 || entropy < 75) {
            return 'Kuat';
        }
        return 'Sangat Kuat';
    }

    /**
     * Hasilkan kata sandi acak aman secara instan
     */
    function generatePassword() {
        const length = parseInt(lengthSlider.value, 10);
        const useUpper = optUppercase.checked;
        const useLower = optLowercase.checked;
        const useNumbers = optNumbers.checked;
        const useSymbols = optSymbols.checked;

        const pools = [];
        const guaranteed = [];

        if (useUpper) {
            pools.push(CHARSETS.upper);
            guaranteed.push(CHARSETS.upper[secureRandomInt(CHARSETS.upper.length)]);
        }
        if (useLower) {
            pools.push(CHARSETS.lower);
            guaranteed.push(CHARSETS.lower[secureRandomInt(CHARSETS.lower.length)]);
        }
        if (useNumbers) {
            pools.push(CHARSETS.numbers);
            guaranteed.push(CHARSETS.numbers[secureRandomInt(CHARSETS.numbers.length)]);
        }
        if (useSymbols) {
            pools.push(CHARSETS.symbols);
            guaranteed.push(CHARSETS.symbols[secureRandomInt(CHARSETS.symbols.length)]);
        }

        if (pools.length === 0) {
            if (optionsWarning) optionsWarning.style.display = 'block';
            return;
        }

        if (optionsWarning) optionsWarning.style.display = 'none';

        const allChars = pools.join('');
        const resultChars = [...guaranteed];
        const remaining = length - guaranteed.length;

        for (let i = 0; i < remaining; i++) {
            const randIdx = secureRandomInt(allChars.length);
            resultChars.push(allChars[randIdx]);
        }

        // Fisher-Yates shuffle
        for (let i = resultChars.length - 1; i > 0; i--) {
            const j = secureRandomInt(i + 1);
            const temp = resultChars[i];
            resultChars[i] = resultChars[j];
            resultChars[j] = temp;
        }

        const password = resultChars.join('');
        passwordOutput.value = password;

        if (strengthText) {
            strengthText.textContent = calculateStrength(length, pools.length, allChars.length);
        }
    }

    /**
     * Periksa checkbox agar minimal ada satu yang aktif
     */
    function validateCheckboxes(e) {
        const checkedCount = [optUppercase, optLowercase, optNumbers, optSymbols].filter(cb => cb.checked).length;
        if (checkedCount === 0) {
            e.target.checked = true;
            if (optionsWarning) {
                optionsWarning.style.display = 'block';
                setTimeout(() => {
                    optionsWarning.style.display = 'none';
                }, 2000);
            }
            return;
        }
        generatePassword();
    }

    // Event listener: Slider
    lengthSlider.addEventListener('input', (e) => {
        lengthDisplay.textContent = e.target.value;
        generatePassword();
    });

    // Event listeners: Checkbox
    [optUppercase, optLowercase, optNumbers, optSymbols].forEach(cb => {
        cb.addEventListener('change', validateCheckboxes);
    });

    // Event listener: Submit / Generate Button
    if (passwordForm) {
        passwordForm.addEventListener('submit', (e) => {
            e.preventDefault();
            generatePassword();
        });
    }

    // Event listener: Copy Button
    if (copyBtn) {
        let copyTimeout = null;
        copyBtn.addEventListener('click', async () => {
            const textToCopy = passwordOutput.value;
            if (!textToCopy) return;

            try {
                await navigator.clipboard.writeText(textToCopy);
                copyBtn.classList.add('copied');
                copyText.textContent = 'Tersalin!';

                clearTimeout(copyTimeout);
                copyTimeout = setTimeout(() => {
                    copyBtn.classList.remove('copied');
                    copyText.textContent = 'Salin';
                }, 2000);
            } catch (err) {
                passwordOutput.select();
                document.execCommand('copy');
                copyText.textContent = 'Tersalin!';
                setTimeout(() => {
                    copyText.textContent = 'Salin';
                }, 2000);
            }
        });
    }

    // Generate initial password if empty
    if (!passwordOutput.value) {
        generatePassword();
    }
});
