<!-- การส่งข้อมูลเข้า sheet เพื่อทดลองการเก็บข้อมูล

----------------------------------------------------------------------------------

#include <WiFi.h>
#include <HTTPClient.h>
#include <ArduinoJson.h>
#include <DHT.h>
#include "HX711.h"

#define DHTPIN1 23
#define DHTPIN2 22
#define DHTTYPE DHT21  

#define DOUT_PIN 4  
#define SCK_PIN  2  

DHT dht1(DHTPIN1, DHTTYPE);
DHT dht2(DHTPIN2, DHTTYPE);
HX711 scale(DOUT_PIN, SCK_PIN); 

const char* ssid = "buthiya suksuwan 2G";         
const char* password = "29092495";    

const char* serverName = "https://script.google.com/macros/s/AKfycbwbBXsT710dLOMCS3laa6Hcq0IN_zwqcEGE2hXC2w0iWr-MXbU1WOVs0I246Ci9Tu1S/exec";

#define SAMPLE_COUNT 10  

float tempData[SAMPLE_COUNT];  
float humData[SAMPLE_COUNT];   
int sampleIndex = 0;  

unsigned long previousMillis = 0;  
const long interval = 6000;  // 6 วินาที (10 ครั้ง = 60 วินาที)

void setup() {
    Serial.begin(115200);

    dht1.begin();
    dht2.begin();

    scale.set_scale();
    scale.tare();

    Serial.println("กำลังสอบเทียบค่า...");
    delay(2000);
    scale.set_scale(2280.f);  
    scale.tare();  

    WiFi.begin(ssid, password);
    while (WiFi.status() != WL_CONNECTED) {
        delay(1000);
        Serial.println("กำลังเชื่อมต่อ WiFi...");
    }
    Serial.println("เชื่อมต่อ WiFi สำเร็จ!");
}

void loop() {
    unsigned long currentMillis = millis();

    if (currentMillis - previousMillis >= interval) { 
        previousMillis = currentMillis;  

        float humidity1 = dht1.readHumidity();
        float temperature1 = dht1.readTemperature();
        float humidity2 = dht2.readHumidity();
        float temperature2 = dht2.readTemperature();

        if (isnan(humidity1) || isnan(temperature1) || isnan(humidity2) || isnan(temperature2)) {
            Serial.println("เกิดข้อผิดพลาดในการอ่านค่าจาก DHT21");
            return;
        }

        float avgTemperature = (temperature1 + temperature2) / 2.0;
        float avgHumidity = (humidity1 + humidity2) / 2.0;
        float weight = abs(scale.get_units(10));  // อ่านน้ำหนักแบบเรียลไทม์

        tempData[sampleIndex] = avgTemperature;
        humData[sampleIndex] = avgHumidity;

        sampleIndex++;  

        Serial.print("เก็บค่าครั้งที่: ");
        Serial.println(sampleIndex);

        if (sampleIndex >= SAMPLE_COUNT) {
            float finalTemp = calculateAverage(tempData, SAMPLE_COUNT);
            float finalHum = calculateAverage(humData, SAMPLE_COUNT);

            sendDataToServer(finalTemp, finalHum, weight);  // ส่งน้ำหนักแบบเรียลไทม์

            sampleIndex = 0;
        }
    }
}

float calculateAverage(float data[], int size) {
    float sum = 0;
    for (int i = 0; i < size; i++) {
        sum += data[i];
    }
    return sum / size;
}

void sendDataToServer(float temperature, float humidity, float weight) {
    if (WiFi.status() == WL_CONNECTED) {
        HTTPClient http;

        http.begin(serverName);
        http.addHeader("Content-Type", "application/json");
        http.setTimeout(5000);

        StaticJsonDocument<200> doc;
        doc["temperature"] = temperature;
        doc["humidity"] = humidity;
        doc["LightIntensity"] = 300;
        doc["weight"] = weight;  // ส่งน้ำหนักแบบเรียลไทม์

        String jsonPayload;
        serializeJson(doc, jsonPayload);

        int httpResponseCode = http.POST(jsonPayload);

        if (httpResponseCode > 0) {
            String response = http.getString();
            Serial.println("Response: " + response);
        } else {
            Serial.print("Error in POST request: ");
            Serial.println(http.errorToString(httpResponseCode));
        }

        http.end();
    } else {
        Serial.println("ไม่ได้เชื่อมต่อ WiFi, พยายามเชื่อมต่อใหม่...");

        WiFi.begin(ssid, password);
        while (WiFi.status() != WL_CONNECTED) {
            delay(1000);
            Serial.println("Reconnecting to WiFi...");
        }
        Serial.println("Reconnected to WiFi.");
    }
}

---------------------------------------------------------------------------------

การส่งข้อมูลเข้าฐานข้อมูล Laravel

#include <WiFi.h>
#include <HTTPClient.h>
#include <ArduinoJson.h>
#include <DHT.h>
#include "HX711.h"

// 🔹 กำหนดพินของเซ็นเซอร์
#define DHTPIN1 23
#define DHTPIN2 22
#define DHTTYPE DHT21  

#define DOUT_PIN 4  
#define SCK_PIN  2  

DHT dht1(DHTPIN1, DHTTYPE);
DHT dht2(DHTPIN2, DHTTYPE);
HX711 scale(DOUT_PIN, SCK_PIN); 

const char* ssid = "OPPOA15";         
const char* password = "11568900";    

// const char* serverName = "http://192.168.43.92:3000/api/data";
// const char* serverName = "https://script.google.com/macros/s/YOUR_SCRIPT_ID/exec";

#define SAMPLE_COUNT 10  

float tempData[SAMPLE_COUNT];  
float humData[SAMPLE_COUNT];   
float weightData[SAMPLE_COUNT]; 
int sampleIndex = 0;  

void setup() {
    Serial.begin(115200);

    dht1.begin();
    dht2.begin();

    scale.set_scale();   // ✅ รีเซ็ตค่า Scale Factor ก่อนเริ่มต้น
    scale.tare();        // ✅ รีเซ็ตค่าเริ่มต้นของ Load Cell

    Serial.println("กำลังสอบเทียบค่า... วางของที่มีน้ำหนักทราบค่าแล้วกดปุ่มรีเซ็ต");

    delay(2000);
    long reading = scale.get_units(10);
    Serial.print("ค่าเริ่มต้นของ Load Cell: ");
    Serial.println(reading);
    
    scale.set_scale(2280.f);  // ✅ ตั้งค่าหลังจากได้ค่าแรก
    scale.tare();  

    WiFi.begin(ssid, password);
    while (WiFi.status() != WL_CONNECTED) {
        delay(1000);
        Serial.println("กำลังเชื่อมต่อ WiFi...");
    }
    Serial.println("เชื่อมต่อ WiFi สำเร็จ!");
}

void loop() {
    float humidity1 = dht1.readHumidity();
    float temperature1 = dht1.readTemperature();
    float humidity2 = dht2.readHumidity();
    float temperature2 = dht2.readTemperature();

    if (isnan(humidity1) || isnan(temperature1) || isnan(humidity2) || isnan(temperature2)) {
        Serial.println("เกิดข้อผิดพลาดในการอ่านค่าจาก DHT21");
        return;
    }

    float avgTemperature = (temperature1 + temperature2) / 2.0;
    float avgHumidity = (humidity1 + humidity2) / 2.0;

    float weight = scale.get_units(10);

    // ✅ ป้องกันค่าติดลบ (ใช้ Absolute Value)
    weight = abs(weight);

    tempData[sampleIndex] = avgTemperature;
    humData[sampleIndex] = avgHumidity;
    weightData[sampleIndex] = weight;
    
    sampleIndex++;

    Serial.print("เก็บค่าครั้งที่: ");
    Serial.println(sampleIndex);

    if (sampleIndex >= SAMPLE_COUNT) {
        float finalTemp = calculateAverage(tempData, SAMPLE_COUNT);
        float finalHum = calculateAverage(humData, SAMPLE_COUNT);
        float finalWeight = calculateAverage(weightData, SAMPLE_COUNT);

        sendDataToServer(finalTemp, finalHum, finalWeight);
        
        sampleIndex = 0;  
    }

    Serial.println("--------------------------");
    delay(5000);  
}

float calculateAverage(float data[], int size) {
    float sum = 0;
    for (int i = 0; i < size; i++) {
        sum += data[i];
    }
    return sum / size;
}

void sendDataToServer(float temperature, float humidity, float weight) {
    if (WiFi.status() == WL_CONNECTED) {
        HTTPClient http;

        http.begin(serverName);
        http.addHeader("Content-Type", "application/json");
        http.setTimeout(5000); 

        StaticJsonDocument<200> doc;
        doc["temperature"] = temperature;
        doc["humidity"] = humidity;
        doc["LightIntensity"] = 300;
        doc["weight"] = weight;

        String jsonPayload;
        serializeJson(doc, jsonPayload);

        int httpResponseCode = http.POST(jsonPayload);

        if (httpResponseCode > 0) {
            String response = http.getString();
            Serial.println("Response: " + response);
        } else {
            Serial.print("Error in POST request: ");
            Serial.println(http.errorToString(httpResponseCode));
        }

        http.end();
    } else {
        Serial.println("ไม่ได้เชื่อมต่อ WiFi, พยายามเชื่อมต่อใหม่...");

        WiFi.begin(ssid, password);
        while (WiFi.status() != WL_CONNECTED) {
            delay(1000);
            Serial.println("Reconnecting to WiFi...");
        }
        Serial.println("Reconnected to WiFi.");
    }
} -->
