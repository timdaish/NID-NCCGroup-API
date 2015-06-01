// Arduino Sketch - Display Highest Monitoring Severity via AdaFruit LED STRIP
// Tim Daish, NCC Group Web Performance, May 2015
//
// Responds to a single character sent via USB (serial port) from a computer linked to NCC Group Monitoring API via Non-Interactive Dashboard with COM enabled
// Turns on strip of LED(s) to represent the highest level of severity from a number of monitored pages, user journeys and/or web services
//
// LED strip connected to Arduino via PIN 6:

char incomingByte = 0;   // for incoming serial data
int severity = 0;
int dval = 50; // delay for tenth a second

// AdaFruit NEOPIXEL configuration
#include <Adafruit_NeoPixel.h>
#include <avr/power.h>

// Which pin on the Arduino is connected to the NeoPixels?
#define PIN            6

// How many NeoPixels are attached to the Arduino?
#define NUMPIXELS      8

// When we setup the NeoPixel library, we tell it how many pixels, and which pin to use to send signals.
// Note that for older NeoPixel strips you might need to change the third parameter--see the strandtest
// example for more information on possible values.
Adafruit_NeoPixel pixels = Adafruit_NeoPixel(NUMPIXELS, PIN, NEO_GRB + NEO_KHZ800);

void setup() {
  pixels.begin(); // This initializes the NeoPixel library.

  Serial.begin(9600,SERIAL_7N1);     // opens serial port, sets data rate to 9600 bps
  pinMode(13, OUTPUT);
}

void loop() {
   // send data only when you receive data:
   if (Serial.available()) {
	// read the incoming byte:
	incomingByte = Serial.read();

	digitalWrite(13, HIGH);
	delay(150);
	digitalWrite(13, LOW);

	severity = incomingByte;
   }

  switch (severity)
  {
    
     case 'O':
      for(int i=0;i<NUMPIXELS;i++){
    
        // pixels.Color takes RGB values, from 0,0,0 up to 255,255,255
        pixels.setPixelColor(i, pixels.Color(0,128,0)); // Moderately bright green color.
    
        pixels.show(); // This sends the updated pixel color to the hardware.
    
        delay(dval); // Delay for a period of time (in milliseconds).
       
         }
     break;
     
     case 'W':
        for(int i=0;i<NUMPIXELS;i++){
      
          // pixels.Color takes RGB values, from 0,0,0 up to 255,255,255
          pixels.setPixelColor(i, pixels.Color(128,128,0)); // Moderately bright yellow color.
      
          pixels.show(); // This sends the updated pixel color to the hardware.
      
          delay(dval); // Delay for a period of time (in milliseconds). 
         }
        break;   
   
     case 'P':
        for(int i=0;i<NUMPIXELS;i++){
      
          // pixels.Color takes RGB values, from 0,0,0 up to 255,255,255
          pixels.setPixelColor(i, pixels.Color(128,0,0)); // Moderately bright red color.
      
          pixels.show(); // This sends the updated pixel color to the hardware.
      
          delay(dval); // Delay for a period of time (in milliseconds).
      
        }
       break;
     
     case 'D':
		// pixels.Color takes RGB values, from 0,0,0 up to 255,255,255
		pixels.setPixelColor(0, pixels.Color(0,0,128)); // Moderately bright blue color.
		pixels.setPixelColor(1, pixels.Color(0,0,128)); // Moderately bright blue color.
		pixels.setPixelColor(2, pixels.Color(0,0,128)); // Moderately bright blue color.
		pixels.setPixelColor(3, pixels.Color(0,0,128)); // Moderately bright blue color.
		pixels.setPixelColor(4, pixels.Color(0,0,0));
		pixels.setPixelColor(5, pixels.Color(0,0,0));
		pixels.setPixelColor(6, pixels.Color(0,0,0));
		pixels.setPixelColor(7, pixels.Color(0,0,0));
		pixels.show(); // This sends the updated pixel color to the hardware.      
		delay(dval); // Delay for a period of time (in milliseconds).
		pixels.setPixelColor(0, pixels.Color(0,0,0));
		pixels.setPixelColor(1, pixels.Color(0,0,0));
		pixels.setPixelColor(2, pixels.Color(0,0,0));
		pixels.setPixelColor(3, pixels.Color(0,0,0));
		pixels.show(); // This sends the updated pixel color to the hardware.      
		delay(dval); // Delay for a period of time (in milliseconds).
		pixels.setPixelColor(0, pixels.Color(0,0,128)); // Moderately bright blue color.
		pixels.setPixelColor(1, pixels.Color(0,0,128)); // Moderately bright blue color.
		pixels.setPixelColor(2, pixels.Color(0,0,128)); // Moderately bright blue color.
		pixels.setPixelColor(3, pixels.Color(0,0,128)); // Moderately bright blue color.
		pixels.setPixelColor(4, pixels.Color(0,0,0));
		pixels.setPixelColor(5, pixels.Color(0,0,0));
		pixels.setPixelColor(6, pixels.Color(0,0,0));
		pixels.setPixelColor(7, pixels.Color(0,0,0));
		pixels.show(); // This sends the updated pixel color to the hardware.      
		delay(dval); // Delay for a period of time (in milliseconds).
		delay(dval); // Delay for a period of time (in milliseconds).
		pixels.setPixelColor(0, pixels.Color(0,0,0));
		pixels.setPixelColor(1, pixels.Color(0,0,0));
		pixels.setPixelColor(2, pixels.Color(0,0,0));
		pixels.setPixelColor(3, pixels.Color(0,0,0));
		pixels.show(); // This sends the updated pixel color to the hardware.      
		delay(dval); // Delay for a period of time (in milliseconds).
		pixels.setPixelColor(0, pixels.Color(0,0,128)); // Moderately bright blue color.
		pixels.setPixelColor(1, pixels.Color(0,0,128)); // Moderately bright blue color.
		pixels.setPixelColor(2, pixels.Color(0,0,128)); // Moderately bright blue color.
		pixels.setPixelColor(3, pixels.Color(0,0,128)); // Moderately bright blue color.
		pixels.setPixelColor(4, pixels.Color(0,0,0));
		pixels.setPixelColor(5, pixels.Color(0,0,0));
		pixels.setPixelColor(6, pixels.Color(0,0,0));
		pixels.setPixelColor(7, pixels.Color(0,0,0));
		pixels.show(); // This sends the updated pixel color to the hardware.      
		delay(dval); // Delay for a period of time (in milliseconds).


		// pixels.Color takes RGB values, from 0,0,0 up to 255,255,255
		pixels.setPixelColor(4, pixels.Color(0,0,128)); // Moderately bright blue color.
		pixels.setPixelColor(5, pixels.Color(0,0,128)); // Moderately bright blue color.
		pixels.setPixelColor(6, pixels.Color(0,0,128)); // Moderately bright blue color.
		pixels.setPixelColor(7, pixels.Color(0,0,128)); // Moderately bright blue color.
		pixels.setPixelColor(0, pixels.Color(0,0,0));
		pixels.setPixelColor(1, pixels.Color(0,0,0));
		pixels.setPixelColor(2, pixels.Color(0,0,0));
		pixels.setPixelColor(3, pixels.Color(0,0,0));
		pixels.show(); // This sends the updated pixel color to the hardware.      
		delay(dval); // Delay for a period of time (in milliseconds).
		pixels.setPixelColor(4, pixels.Color(0,0,0));
		pixels.setPixelColor(5, pixels.Color(0,0,0));
		pixels.setPixelColor(6, pixels.Color(0,0,0));
		pixels.setPixelColor(7, pixels.Color(0,0,0));
		pixels.show(); // This sends the updated pixel color to the hardware.      
		delay(dval); // Delay for a period of time (in milliseconds).
		pixels.setPixelColor(4, pixels.Color(0,0,128)); // Moderately bright blue color.
		pixels.setPixelColor(5, pixels.Color(0,0,128)); // Moderately bright blue color.
		pixels.setPixelColor(6, pixels.Color(0,0,128)); // Moderately bright blue color.
		pixels.setPixelColor(7, pixels.Color(0,0,128)); // Moderately bright blue color.
		pixels.setPixelColor(0, pixels.Color(0,0,0));
		pixels.setPixelColor(1, pixels.Color(0,0,0));
		pixels.setPixelColor(2, pixels.Color(0,0,0));
		pixels.setPixelColor(3, pixels.Color(0,0,0));
		pixels.show(); // This sends the updated pixel color to the hardware.      
		delay(dval); // Delay for a period of time (in milliseconds).
		delay(dval); // Delay for a period of time (in milliseconds).
		pixels.setPixelColor(4, pixels.Color(0,0,0));
		pixels.setPixelColor(5, pixels.Color(0,0,0));
		pixels.setPixelColor(6, pixels.Color(0,0,0));
		pixels.setPixelColor(7, pixels.Color(0,0,0));
		pixels.show(); // This sends the updated pixel color to the hardware.      
		delay(dval); // Delay for a period of time (in milliseconds).
		pixels.setPixelColor(4, pixels.Color(0,0,128)); // Moderately bright blue color.
		pixels.setPixelColor(5, pixels.Color(0,0,128)); // Moderately bright blue color.
		pixels.setPixelColor(6, pixels.Color(0,0,128)); // Moderately bright blue color.
		pixels.setPixelColor(7, pixels.Color(0,0,128)); // Moderately bright blue color.
		pixels.setPixelColor(0, pixels.Color(0,0,0));
		pixels.setPixelColor(1, pixels.Color(0,0,0));
		pixels.setPixelColor(2, pixels.Color(0,0,0));
		pixels.setPixelColor(3, pixels.Color(0,0,0));
		pixels.show(); // This sends the updated pixel color to the hardware.      
		delay(dval); // Delay for a period of time (in milliseconds).
		break;
    } // end select
  
  }