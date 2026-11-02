<?php

namespace Tests\Feature;

use Tests\TestCase;

class PasswordGeneratorTest extends TestCase
{
    public function test_home_page_renders_clean_minimalist_layout(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('passcraft');
        $response->assertSee('Buat Kata Sandi yang Aman.');
        $response->assertSee('Generator kata sandi acak yang sederhana, cepat, dan mudah digunakan.');
        $response->assertSee('Buat Kata Sandi');
        $response->assertSee('PassCraft — Generator Kata Sandi Aman.');
    }

    public function test_generate_endpoint_returns_json_response(): void
    {
        $response = $this->postJson('/generate', [
            'length' => 24,
            'uppercase' => true,
            'lowercase' => true,
            'numbers' => true,
            'symbols' => false,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'password',
            'strength',
            'entropy',
        ]);
        $response->assertJson([
            'success' => true,
        ]);

        $data = $response->json();
        $this->assertSame(24, strlen($data['password']));
    }

    public function test_generate_fails_when_all_character_options_unchecked(): void
    {
        $response = $this->postJson('/generate', [
            'length' => 16,
            'uppercase' => false,
            'lowercase' => false,
            'numbers' => false,
            'symbols' => false,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['charset']);
    }

    public function test_generate_fails_when_length_below_minimum(): void
    {
        $response = $this->postJson('/generate', [
            'length' => 3,
            'uppercase' => true,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['length']);
    }
}
