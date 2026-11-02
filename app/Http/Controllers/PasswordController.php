<?php

namespace App\Http\Controllers;

use App\Http\Requests\GeneratePasswordRequest;
use App\Services\PasswordGeneratorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PasswordController extends Controller
{
    public function __construct(
        protected PasswordGeneratorService $generatorService
    ) {}

    /**
     * Tampilkan halaman utama generator kata sandi.
     */
    public function index(Request $request): View
    {
        $defaultLength = 16;
        $defaultUpper = true;
        $defaultLower = true;
        $defaultNumbers = true;
        $defaultSymbols = true;

        $result = $this->generatorService->generate(
            $defaultLength,
            $defaultUpper,
            $defaultLower,
            $defaultNumbers,
            $defaultSymbols
        );

        return view('home', [
            'password' => $result['password'],
            'strength' => $result['strength'],
            'entropy' => $result['entropy'],
            'length' => $defaultLength,
            'uppercase' => $defaultUpper,
            'lowercase' => $defaultLower,
            'numbers' => $defaultNumbers,
            'symbols' => $defaultSymbols,
        ]);
    }

    /**
     * Proses pembuatan kata sandi baru via API / Form submission.
     */
    public function generate(GeneratePasswordRequest $request): JsonResponse|View
    {
        $length = (int) $request->input('length', 16);
        $uppercase = $request->boolean('uppercase', true);
        $lowercase = $request->boolean('lowercase', true);
        $numbers = $request->boolean('numbers', true);
        $symbols = $request->boolean('symbols', true);

        $result = $this->generatorService->generate(
            $length,
            $uppercase,
            $lowercase,
            $numbers,
            $symbols
        );

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'password' => $result['password'],
                'strength' => $result['strength'],
                'entropy' => $result['entropy'],
            ]);
        }

        return view('home', [
            'password' => $result['password'],
            'strength' => $result['strength'],
            'entropy' => $result['entropy'],
            'length' => $length,
            'uppercase' => $uppercase,
            'lowercase' => $lowercase,
            'numbers' => $numbers,
            'symbols' => $symbols,
        ]);
    }
}
