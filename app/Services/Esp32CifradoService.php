<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class Esp32CifradoService
{
    private string $key;
    private string $algo;

    public function __construct()
    {
        $this->key = hex2bin(env('ESP32_CIPHER_KEY'));
        $this->algo = env('ESP32_CIPHER_ALGO', 'AES-256-CBC');
    }

    public function encrypt(array $payload): array
    {
        $payload['ts'] = now()->timestamp;
        $json = json_encode($payload);
        $iv   = random_bytes(16);

        $ciphertext = openssl_encrypt(
            $json,
            $this->algo,
            $this->key,
            OPENSSL_RAW_DATA,
            $iv
        );

        if ($ciphertext === false) {
            throw new \RuntimeException('openssl_encrypt falló: ' . openssl_error_string());
        }

        $hmac = hash_hmac('sha256', $ciphertext, $this->key, true);

        return [
            'iv'   => base64_encode($iv),
            'data' => base64_encode($ciphertext),
            'mac'  => base64_encode($hmac),
        ];
    }

    public function decrypt(array $packet): ?array
    {
        $iv = base64_decode($packet['iv']);
        $ciphertext = base64_decode($packet['data']);
        $mac = base64_decode($packet['mac']);

        //Verificar integridad
        $expected = hash_hmac('sha256', $ciphertext, $this->key, true);
        if(!hash_equals($expected, $mac)) {
            return null; // Integridad comprometida
        }

        $json = openssl_decrypt($ciphertext, $this->algo, $this->key, OPENSSL_RAW_DATA, $iv);
        return json_decode($json, true);
    }
}