// Arduino Sketch - Display Highest Monitoring Severity via 4 LED(s)
// Tim Daish, NCC Group Web Performance, May 2015
//
// Responds to a single character sent via USB (serial port) from a computer linked to NCC Group Monitoring API via Non-Interactive Dashboard with COM enabled
// Turns on one or more LED(s) to represent the highest level of severity from a number of monitored pages, user journeys and/or web services
//
// 4 LEDs connected to Arduino via resistors:
// green on Pin 8
// yellow on Pin 9
// red on Pin 10
// blue on Pin 11
//
char incomingByte = 0; // for incoming serial data
int severity = 0; // for ASCII value of received character
int dval = 50; // change speed of flashing lights for a DOWN severity by changing this value (in milliseconds)

void setup() {
  Serial.begin(9600,SERIAL_7N1); // opens serial port, sets data rate to 9600 baud, 7 data bits (*IMPORTANT), no parity, 1 stop bit
  pinMode(13, OUTPUT);
  pinMode(11, OUTPUT);
  pinMode(10, OUTPUT);
  pinMode(9, OUTPUT);
  pinMode(8, OUTPUT);
}

void loop() {
  // check for data being available on serial port - just read one character
  if (Serial.available()) {
    // read the incoming byte:
    incomingByte = Serial.read();
    severity = incomingByte;
      
    // flash the LED on pin 13 to signify that data was received
    digitalWrite(13, HIGH);
    delay(150);
    digitalWrite(13, LOW);
  }
  
  // set appropriate LEDs on and off by severity
  switch (severity)
  {  
    case 'O': // OK - turn on green LED on Pin 8
      digitalWrite(11, LOW);
      digitalWrite(10, LOW);
      digitalWrite(9, LOW);
      digitalWrite(8, HIGH); 
      break;
     
    case 'W': // WARNING - turn on yellow LED on Pin 9
      digitalWrite(11, LOW);
      digitalWrite(10, LOW);
      digitalWrite(9, HIGH);  
      digitalWrite(8, LOW);  
      break;   
   
    case 'P': // PROBLEM - turn on red LED on pin 10
      digitalWrite(11, LOW);
      digitalWrite(10, HIGH);
      digitalWrite(9, LOW);  
      digitalWrite(8, LOW); 
      break;
     
    case 'D': // DOWN - alternate flashing of red LED on Pin 10 and blue LED on Pin 11 - each of red and blue flashes 3 times, emergency style
      digitalWrite(9, LOW);  
      digitalWrite(8, LOW); 
      digitalWrite(10, HIGH);
      delay(dval);
      digitalWrite(10, LOW);
      delay(dval);
      digitalWrite(10, HIGH);
      delay(dval);
      digitalWrite(10, LOW);
      delay(dval); 
      digitalWrite(10, HIGH);
      delay(dval);
      digitalWrite(10, LOW);
      delay(dval);
      digitalWrite(11, HIGH);
      delay(dval);
      digitalWrite(11, LOW);
      delay(dval);
      digitalWrite(11, HIGH);
      delay(dval);
      digitalWrite(11, LOW);
      delay(dval);
      digitalWrite(11, HIGH);
      delay(dval);
      digitalWrite(11, LOW);
      delay(dval);
      break;
    } // end switch
}
