<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Throwable;

class RecaptchaV2 implements ValidationRule
{
    public function validate(
        string $attribute,
        mixed $value,
        Closure $fail
    ): void {

        $secret = config('recaptcha.secret_key');
        $siteKey = config('recaptcha.site_key');

        if (empty($secret) || empty($siteKey)) {
            $fail('reCAPTCHA belum dikonfigurasi.');
            return;
        }

        if (empty($value)) {
            $fail('Silakan centang reCAPTCHA.');
            return;
        }

        try {
            $response = Http::asForm()
                ->acceptJson()
                ->timeout(7)
                ->post(
                    'https://www.google.com/recaptcha/api/siteverify',
                    [
                        'secret' => $secret,
                        'response' => $value,
                    ]
                );

            if (
                !$response->successful() ||
                $response->json('success') !== true
            ) {
                $fail('Verifikasi reCAPTCHA gagal.');
                return;
            }

            $hostname = strtolower(
                (string) $response->json('hostname', '')
            );

            $allowed = config('recaptcha.allowed_hostnames')
                ?: [request()->getHost()];

            $allowed = array_map(
                fn ($host) => strtolower(trim($host)),
                $allowed
            );

            if (
                $hostname === '' ||
                !in_array($hostname, $allowed, true)
            ) {
                $fail('Domain reCAPTCHA tidak sesuai.');
            }

        } catch (Throwable $e) {
            report($e);

            $fail('Layanan reCAPTCHA tidak tersedia.');
        }
    }
}
