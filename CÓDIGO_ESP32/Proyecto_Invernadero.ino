#include <WiFi.h>
#include <HTTPClient.h>
#include <ArduinoJson.h>
#include "DHT.h"
#include <mbedtls/aes.h>
#include <mbedtls/md.h>
#include <mbedtls/base64.h>

//LAPTOP PRO
//macarenita
//HUAWEI-610I0L
//93903665
// CONFIGURACIÓN DE RED
const char* ssid = "iCUCEI";
const char* password = "";
const char* serverIP = "10.214.153.39"; // REEMPLAZA LA X
//10.214.52.32
// PINES
#define PIN_VENTILADOR 21
#define PIN_BOMBA      18
#define PIN_FOCO       19
#define PIN_DHT        4
#define PIN_LUZ        34 
#define PIN_SUSTRATO   35
// Defineción del sensor DHT
#define DHTTYPE DHT11
DHT dht(PIN_DHT, DHTTYPE);

const int ENCENDER = LOW;
const int APAGAR   = HIGH;
// Clave de cifrado (32 bytes para AES-256)
const uint8_t CIPHER_KEY[32] = {
  0xd9, 0xe0, 0x18, 0x96, 0xf1, 0x75, 0x38, 0x8e, 0x8d, 0x55, 0x6a, 0x80, 0xb9, 0x54, 0x98, 0x2e, 0x2f, 0x8f, 0xfd, 0x06, 0x70, 0xba, 0x37, 0x21, 0xe2, 0xea, 0x7d, 0xf3, 0x6b, 0xa9, 0x6c, 0x0d
};

// Variables de estado
bool estadoRiego = false;
bool estadoLuz = false;
bool estadoVentilacion = false;

void setup() {
  //Se inicializa la comunicación serial para depuración
  Serial.begin(115200);
  // Configuración de pines
  pinMode(PIN_BOMBA, OUTPUT);
  pinMode(PIN_VENTILADOR, OUTPUT);
  pinMode(PIN_FOCO, OUTPUT);
  // Asegurarse de que todo esté apagado al inicio
  digitalWrite(PIN_BOMBA, APAGAR);
  digitalWrite(PIN_VENTILADOR, APAGAR);
  digitalWrite(PIN_FOCO, APAGAR);
  // Inicializar el sensor DHT
  dht.begin();
  // Conectar a WiFi
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("\nConectado a WiFi");
}

void loop() {
  if (WiFi.status() == WL_CONNECTED) {
    
    // LECTURA DE SENSORES
    float h = dht.readHumidity();
    float t = dht.readTemperature();
    int luzRaw = analogRead(PIN_LUZ);
    int sustratoRaw = analogRead(PIN_SUSTRATO);

    Serial.print("luzRaw: "); Serial.println(luzRaw);
    Serial.print("sustratoRaw: "); Serial.println(sustratoRaw);

      if (isnan(h) || isnan(t)) {
        Serial.println("Fallo en el DHT, enviando valores de prueba.");
        h = 55.0;
        t = 24.0;
    }
    // ENVIAR DATOS (POST)
    enviarDatos(t, h, luzRaw);

    // RECIBIR Y EJECUTAR COMANDOS (GET)
    revisarComandos();
  }
  delay(10000); // Esperar 10 segundos para la siguiente iteración
}

void enviarDatos(float t, float h, int l) {
  //Se construye el JSON con los datos del sensor y se envía al servidor usando HTTP POST
  HTTPClient http;
  String url = "http://" + String(serverIP) + ":8000/api/sensor-readings";
  http.begin(url);
  http.addHeader("Content-Type", "application/json");
  http.setFollowRedirects(HTTPC_STRICT_FOLLOW_REDIRECTS);
  // Construcción del JSON
  StaticJsonDocument<200> doc;
  doc["sensor_id"] = "esp32-01";
  doc["temperatura"] = t;
  doc["humedad"] = h;
  doc["luz"] = (float)l;
  doc["estado_riego"] = estadoRiego;
  doc["estado_luz"] = estadoLuz;
  doc["estado_ventilacion"] = estadoVentilacion;
  // Serialización del JSON a String
  String requestBody;
  serializeJson(doc, requestBody);
  
  int httpResponseCode = http.POST(requestBody);
  Serial.print("POST Envío: "); Serial.println(httpResponseCode);
  http.end();
}

// Escritura
void safeWrite(uint8_t pin, uint8_t value, const char* deviceName) {
  Serial.print(deviceName);
  Serial.print(" → ");
  Serial.println(value == ENCENDER ? "ENCENDER" : "APAGAR");
  digitalWrite(pin, value);
}

int b64decodificar(const String& input, uint8_t* output, size_t outputLen)
{
  //mbedTLS espera un buffer de salida con suficiente espacio, y devuelve el número de bytes escritos en 'written'. Regresa -1 si hay error.
  size_t written = 0;
  int ret = mbedtls_base64_decode(output, outputLen, &written, (const unsigned char*)input.c_str(), input.length());
  return (ret == 0) ? (int)written : -1;
}

//Verificar hmac-sha256 del texto cifrado usando CIPHER_KEY, regresa true si es válido
bool verificarHmac(const uint8_t* ciphertext, size_t cipherLen, const uint8_t* expectedHmac, size_t macLen)
{
  uint8_t computed[32];
  mbedtls_md_context_t ctx;
  const mbedtls_md_info_t* info = mbedtls_md_info_from_type(MBEDTLS_MD_SHA256);

  mbedtls_md_init(&ctx);
  mbedtls_md_setup(&ctx, info, 1);
  mbedtls_md_hmac_starts(&ctx, CIPHER_KEY, 32);
  mbedtls_md_hmac_update(&ctx, ciphertext, cipherLen);
  mbedtls_md_hmac_finish(&ctx, computed);
  mbedtls_md_free(&ctx);

  //Comparasión de tiempo constante para evitar ataques de tiempo
  if (macLen != 32) return false;
  uint8_t diff = 0;
  for (int i = 0; i<32; i++) diff |= computed[i] ^ expectedHmac[i];
  return diff == 0;
}

int aesDecrypt(const uint8_t* iv, const uint8_t* ciphertext, size_t cipherLen, uint8_t* plaintext)
{
  //Desencripta el ciphertext usando AES-256-CBC con la clave CIPHER_KEY y el IV dado. El resultado se guarda en plaintext. Regresa la longitud del texto plano o -1 si hay error.
  mbedtls_aes_context aes;
  mbedtls_aes_init(&aes);
  mbedtls_aes_setkey_dec(&aes, CIPHER_KEY, 256);

  uint8_t ivCopy[16];
  memcpy(ivCopy, iv, 16);

  int ret = mbedtls_aes_crypt_cbc(&aes, MBEDTLS_AES_DECRYPT, cipherLen, ivCopy, ciphertext, plaintext);
  mbedtls_aes_free(&aes);

  if (ret != 0) return -1;

  uint8_t pad = plaintext[cipherLen - 1];
  if (pad == 0 || pad > 16) return -1;
  return (int)cipherLen - pad;
}

void revisarComandos() {
  //Recibe comandos pendientes del servidor usando HTTP GET, verifica su integridad y autenticidad, los ejecuta y luego envía un acknowledge al servidor.
  HTTPClient http;
  String url = "http://" + String(serverIP) + ":8000/api/commands/pending?sensor_id=esp32-01";
  http.begin(url);
  http.setFollowRedirects(HTTPC_STRICT_FOLLOW_REDIRECTS);

  int httpResponseCode = http.GET();
  Serial.print("GET Commands: "); Serial.println(httpResponseCode);

  if (httpResponseCode == 200) {
    String payload = http.getString();
    Serial.print("Payload: "); Serial.println(payload);

    //Paso 1: parsing del envelope (iv, data, mac)
    StaticJsonDocument<600> envelope;
    if (deserializeJson(envelope, payload) || envelope.isNull()) {
      Serial.println("Error: JSON envelope inválido");
      http.end(); return;
    }

    String ivB64   = envelope["iv"].as<String>();
    String dataB64 = envelope["data"].as<String>();
    String macB64  = envelope["mac"].as<String>();

    //Paso 2: base64 decodificar todos los tres fields ──
    uint8_t iv[16], ciphertext[256], mac[32];

    if (b64decodificar(ivB64,   iv,         sizeof(iv))         < 0 ||
        b64decodificar(macB64,  mac,        sizeof(mac))        < 0) {
      Serial.println("Error: base64 decode falló");
      http.end(); return;
    }
    int cipherLen = b64decodificar(dataB64, ciphertext, sizeof(ciphertext));
    if (cipherLen < 0) {
      Serial.println("Error: base64 decode del ciphertext falló");
      http.end(); return;
    }

    // Paso 3: verificar el hmac
    if (!verificarHmac(ciphertext, cipherLen, mac, 32)) {
      Serial.println("Error: HMAC inválido — descartando comando");
      http.end(); return;
    }

    //Paso 4: desencriptar
    uint8_t plaintext[256] = {0};
    int plainLen = aesDecrypt(iv, ciphertext, cipherLen, plaintext);
    if (plainLen < 0) {
      Serial.println("Error: decryption falló");
      http.end(); return;
    }
    plaintext[plainLen] = '\0';

    Serial.print("Decrypted: "); Serial.println((char*)plaintext);

    //Paso 5: parsea el comando
    StaticJsonDocument<256> doc;
    if (deserializeJson(doc, plaintext) || doc.isNull()) {
      Serial.println("Error: JSON de comando inválido");
      http.end(); return;
    }

    int    idComando = doc["id"];
    String tipo      = doc["tipo_comando"].as<String>();
    int    valor     = doc["valor_comando"].as<bool>();

    Serial.print("Comando: "); Serial.println(tipo);
    Serial.print("ID: ");      Serial.println(idComando);
    // Ejecutar el comando
    if (tipo == "riego")       safeWrite(PIN_BOMBA,      valor ? ENCENDER : APAGAR, "BOMBA");
    if (tipo == "iluminacion") safeWrite(PIN_FOCO,       valor ? ENCENDER : APAGAR, "FOCO");
    if (tipo == "ventilacion") safeWrite(PIN_VENTILADOR, valor ? ENCENDER : APAGAR, "VENTILADOR");

    enviarAcknowledge(idComando);

  } else if (httpResponseCode == 204) {
    Serial.println("Sin comandos pendientes");
  } else {
    Serial.print("Error GET: "); Serial.println(httpResponseCode);
  }

  Serial.println();
  http.end();
}

void enviarAcknowledge(int id) {
  //Envía un acknowledge al servidor indicando que el comando con el ID dado fue recibido y ejecutado.
  HTTPClient http;
  String url = "http://" + String(serverIP) + ":8000/api/commands/" + String(id) + "/acknowledge";
  http.begin(url);
  int httpResponseCode = http.sendRequest("PATCH");
  Serial.print("PATCH Ack: "); Serial.println(httpResponseCode);
  http.end();
}