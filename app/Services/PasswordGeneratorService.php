<?php

namespace App\Services;

use InvalidArgumentException;

class PasswordGeneratorService
{
    public const UPPERCASE = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    public const LOWERCASE = 'abcdefghijklmnopqrstuvwxyz';
    public const NUMBERS = '0123456789';
    public const SYMBOLS = '!@#$%^&*()_+-=[]{}|;:,.<>?';

    /**
     * Menghasilkan kata sandi acak yang aman secara kriptografi.
     *
     * @param int $length Panjang kata sandi (6 - 64)
     * @param bool $useUpper Sertakan huruf besar
     * @param bool $useLower Sertakan huruf kecil
     * @param bool $useNumbers Sertakan angka
     * @param bool $useSymbols Sertakan simbol
     * @return array{password: string, strength: string, entropy: float}
     */
    public function generate(
        int $length = 16,
        bool $useUpper = true,
        bool $useLower = true,
        bool $useNumbers = true,
        bool $useSymbols = true
    ): array {
        if ($length < 6 || $length > 64) {
            throw new InvalidArgumentException('Panjang kata sandi harus antara 6 dan 64 karakter.');
        }

        $pools = [];
        $requiredChars = [];

        if ($useUpper) {
            $pools[] = self::UPPERCASE;
            $requiredChars[] = self::UPPERCASE[random_int(0, strlen(self::UPPERCASE) - 1)];
        }
        if ($useLower) {
            $pools[] = self::LOWERCASE;
            $requiredChars[] = self::LOWERCASE[random_int(0, strlen(self::LOWERCASE) - 1)];
        }
        if ($useNumbers) {
            $pools[] = self::NUMBERS;
            $requiredChars[] = self::NUMBERS[random_int(0, strlen(self::NUMBERS) - 1)];
        }
        if ($useSymbols) {
            $pools[] = self::SYMBOLS;
            $requiredChars[] = self::SYMBOLS[random_int(0, strlen(self::SYMBOLS) - 1)];
        }

        if (empty($pools)) {
            throw new InvalidArgumentException('Minimal satu jenis karakter harus dipilih.');
        }

        $allChars = implode('', $pools);
        $totalPoolSize = strlen($allChars);
        $passwordChars = $requiredChars;

        // Lengkapi sisa karakter dengan pemilihan acak aman
        $remaining = $length - count($requiredChars);
        for ($i = 0; $i < $remaining; $i++) {
            $randIndex = random_int(0, $totalPoolSize - 1);
            $passwordChars[] = $allChars[$randIndex];
        }

        // Acak urutan karakter menggunakan Fisher-Yates dengan random_int
        $count = count($passwordChars);
        for ($i = $count - 1; $i > 0; $i--) {
            $j = random_int(0, $i);
            $temp = $passwordChars[$i];
            $passwordChars[$i] = $passwordChars[$j];
            $passwordChars[$j] = $temp;
        }

        $password = implode('', $passwordChars);
        $entropy = $this->calculateEntropy($length, $totalPoolSize);
        $strength = $this->determineStrengthLabel($entropy, $length, count($pools));

        return [
            'password' => $password,
            'strength' => $strength,
            'entropy' => round($entropy, 1),
        ];
    }

    /**
     * Menghitung nilai entropi kata sandi dalam bit (E = L * log2(R)).
     */
    public function calculateEntropy(int $length, int $poolSize): float
    {
        if ($poolSize <= 0 || $length <= 0) {
            return 0.0;
        }

        return $length * (log($poolSize) / log(2));
    }

    /**
     * Menentukan label kekuatan dalam Bahasa Indonesia.
     */
    public function determineStrengthLabel(float $entropy, int $length, int $typeCount): string
    {
        if ($length < 8 || $typeCount === 1 || $entropy < 35) {
            return 'Lemah';
        }

        if ($length < 12 || $typeCount < 3 || $entropy < 55) {
            return 'Sedang';
        }

        if ($length < 16 || $typeCount < 4 || $entropy < 75) {
            return 'Kuat';
        }

        return 'Sangat Kuat';
    }
}

