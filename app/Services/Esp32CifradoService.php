<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class Esp32CifradoService
{
    private string $key;
    private string $algo;

    public function __construct()
    {
        //Función para inicializar la clave de cifrado y el algoritmo, obteniendo la clave de cifrado desde una variable de entorno y decodificándola de hexadecimal a binario, y estableciendo el algoritmo de cifrado a usar, por defecto AES-256-CBC.
        $this->key = hex2bin(env('ESP32_CIPHER_KEY'));
        $this->algo = env('ESP32_CIPHER_ALGO', 'AES-256-CBC');
    }

    public function encrypt(array $payload): array
    {
        //Encriptar un array de datos, añadiendo un timestamp al payload, convirtiéndolo a JSON, generando un IV aleatorio, cifrando el JSON con OpenSSL usando el algoritmo y la clave configurados, calculando un HMAC para verificar la integridad de los datos y devolviendo el IV, el ciphertext y el HMAC codificados en base64.
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
        //Desencriptar un paquete de datos, decodificando el IV, el ciphertext y el HMAC de base64, verificando la integridad de los datos comparando el HMAC esperado con el HMAC recibido, y si la integridad es válida, descifrando el ciphertext con OpenSSL usando el algoritmo y la clave configurados, y devolviendo el resultado como un array decodificado de JSON. Si la integridad no es válida, se devuelve null.
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