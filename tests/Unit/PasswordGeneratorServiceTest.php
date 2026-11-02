<?php

namespace Tests\Unit;

use App\Services\PasswordGeneratorService;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PasswordGeneratorServiceTest extends TestCase
{
    private PasswordGeneratorService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new PasswordGeneratorService();
    }

    public function test_generates_default_password_successfully(): void
    {
        $result = $this->service->generate();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('password', $result);
        $this->assertArrayHasKey('strength', $result);
        $this->assertArrayHasKey('entropy', $result);
        $this->assertSame(16, strlen($result['password']));
        $this->assertNotEmpty($result['strength']);
        $this->assertGreaterThan(50, $result['entropy']);
    }

    public function test_respects_custom_lengths(): void
    {
        foreach ([6, 12, 32, 64] as $length) {
            $result = $this->service->generate($length);
            $this->assertSame($length, strlen($result['password']));
        }
    }

    public function test_throws_exception_on_invalid_length(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->service->generate(5);
    }

    public function test_throws_exception_when_no_charset_selected(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->service->generate(16, false, false, false, false);
    }

    public function test_guarantees_only_selected_character_types(): void
    {
        // Hanya huruf besar dan angka
        $result = $this->service->generate(20, true, false, true, false);
        $password = $result['password'];

        $this->assertMatchesRegularExpression('/^[A-Z0-9]+$/', $password);
        $this->assertMatchesRegularExpression('/[A-Z]/', $password);
        $this->assertMatchesRegularExpression('/[0-9]/', $password);
    }

    public function test_strength_evaluation_levels(): void
    {
        $weak = $this->service->determineStrengthLabel(20.0, 6, 1);
        $this->assertSame('Lemah', $weak);

        $medium = $this->service->determineStrengthLabel(45.0, 10, 3);
        $this->assertSame('Sedang', $medium);

        $strong = $this->service->determineStrengthLabel(65.0, 14, 3);
        $this->assertSame('Kuat', $strong);

        $veryStrong = $this->service->determineStrengthLabel(95.0, 20, 4);
        $this->assertSame('Sangat Kuat', $veryStrong);
    }
}
