/*
  Web server for the vending machine
  Created by: Max van den Boom
  Date: 11-27-2018
*/
//libs
#include <SPI.h>
#include <Ethernet.h>
//#include <Event.h>
#include <SimpleTimer.h>

//libs
byte mac[] = { 0x00, 0xAA, 0xBB, 0xCC, 0xDA, 0x02 };
IPAddress ip(192, 168, 0, 40);
EthernetServer server(80);

SimpleTimer tmSystem;


//globals
bool enableSerialPrintLn = true;
int tickIntervalInMs;
boolean serverUp = false;
boolean clientAvailable = false;
String clientString;
bool testLedOn = true;

bool jsonPrinter = false;

String inputString = "";         // a String to hold incoming data

//io van de bovenste relais
int rowPowerMboo = 30;//Groen
int rowGroundMboo = 23;//Blauw

int doRow1Mboo = 22;//Bruin
int doRow2Mboo = 25;//Rood
int doRow3Mboo = 24;//Oranje
int doRow4Mboo = 27;//Geel
int doRow5Mboo = 26;//Groen
int doRow6Mboo = 29;//Blauw
int doRow7Mboo = 28;//Rood
int doRow8Mboo = 30;//Grijs

//io van de onderste relais
int columPowerMboo = 51;//Wit
int columGroundMboo = 42;//Rood

int doColum1Mboo = 43;//Oranje
int doColum2Mboo = 44;//Geel
int doColum3Mboo = 45;//Oranje
int doColum4Mboo = 46;//Geel
int doColum5Mboo = 47;//Groen
int doColum6Mboo = 48;//Blauw
int doColum7Mboo = 49;//Paars
int doColum8Mboo = 50;//Grijs

void setup()
{
  InitSerial();
  InitIo();
  InitLibs();
}

void loop()
{
  tmSystem.run();
}

void tick()
{
  //handle program logic
  ListenForEthernetClients();
  //FailSafeProtection();

  //log debug information
  //  LogDebugInfo();
}

//checks for incoming serial commands
void serialEvent() {
  while (Serial.available()) {
    // get the new byte:
    char inChar = (char)Serial.read();

    // add it to the inputString:
    inputString += inChar;

    // checks if the string contains a @, this should be the last character in the string
    if (inChar == '@') {
      DecodeString(inputString);
    }
  }
}

//checks for incoming web messages
void ListenForEthernetClients()
{
  serverUp = false;
  clientAvailable = false;
  String m_test;

  EthernetClient client = server.available();

  if (client)
  {
    while (client.connected())
    {
      if (client.available())
      {
        if (clientAvailable == false)
        {
          clientAvailable = true;
        }

        char m_clientChar = client.read();

        if (clientString.length() < 250)
        {
          clientString = clientString + m_clientChar;
        }

        if (m_clientChar == '\n')
        {
          //prints the json array to 192.168.0.40 so that websites can read the information
          client.println("HTTP/1.1 200 OK");
          client.println("Content-Type: application/json");
          client.println("Access-Control-Allow-Origin: *");
          client.println("");

          //          client.print("{\"VendingId\":[");
          //          client.print(" {\"io\":" + String(1) + ", \"sensor\":" + String(1) + "},");
          //          client.print(" {\"io\":" + String(1) + ", \"sensor\":" + String(1) + "},");
          //          client.print(" {\"io\":" + String(1) + ", \"sensor\":" + String(1) + "},");
          //          client.print(" {\"io\":" + String(1) + ", \"sensor\":" + String(1) + "},");
          //          client.print(" {\"io\":" + String(1) + ", \"sensor\":" + String(1) + "},");
          //          client.print(" {\"io\":" + String(1) + ", \"sensor\":" + String(1) + "}");
          //          client.print("]}");


          client.print(" {\"vendingId\":" + String(1) + "}");


          //only calls the decode function if gettingStatus is not set
          if (clientString.indexOf("gettingStatus=1") == -1) {
            DecodeString(clientString);
          }

          clientString = "";

          break;
        }
      }
    }

    delay(5);

    client.stop();

    serverUp = false;
    clientAvailable = false;
  }
}

void DecodeString(String a_string) {
  int a_startString = 0;
  int a_endString = 0;

  //checks if the string is comming from a website
  if (a_string.indexOf("%24") != -1) {
    a_startString = a_string.indexOf("%24") + 3;
    a_endString = a_string.indexOf("%40");
  } else if (a_string.indexOf("$") != -1) {
    a_startString = a_string.indexOf("$") + 1;
    a_endString = a_string.indexOf("@");
  } else {
    SerialPrintLn("No start character given", false);
  }

  //checks if the start and end indexes are set if so removes all unnecessary information
  if (a_startString > 0 && a_endString > 0) {
    a_string = a_string.substring(a_startString, a_endString);
  } else {
    SerialPrintLn("startString or endString is empty", false);
  }

  //checks if the string has a blockId and a blockStatus if so calls the function Block()
  if (a_string.indexOf("vendingId") != -1 && a_string.indexOf("productPosition")) {
    //gets the start index of the blockId and the blockStatus
    int a_startVendingId = a_string.indexOf("vendingId") + 10;
    int a_startProductPos = a_string.indexOf("productPosition") + 16;

    //gets the information required by arduino
    int a_vendingId = a_string.substring(a_startVendingId, a_startVendingId + 1).toInt();
    int a_productPos = a_string.substring(a_startProductPos, a_startProductPos + 2).toInt();

    loadProduct(a_vendingId, a_productPos);
  }


  SerialPrintLn("Received String: " + a_string, false);
  SerialPrintLn(" ", false);
}






void SerialPrintLn(String a_text, bool a_concatenate)
{
  if (enableSerialPrintLn == true)
  {
    if (a_concatenate == false)
    {
      Serial.println(a_text);
    }
    else
    {
      Serial.print(a_text);
    }
  }
}

void InitSerial()
{
  Serial.begin(9600);
  Serial.println("Init serial finished");
}

void InitLibs()
{
  SerialPrintLn("Init Libs.. ", false);

  Ethernet.begin(mac, ip);
  server.begin();

  //  SerialPrintLn("Ethernet MAC: " + (String)mac + " > IP:" + (String)ip , false);

  tmSystem.setInterval(tickIntervalInMs, tick);
  SerialPrintLn("Timer at: " + (String)tickIntervalInMs + "ms" , false);

  SerialPrintLn("Ready\n", false);
}

void InitIo() {
  Serial.print("InitIO..");

  //init relai power io
  pinMode(rowPowerMboo, OUTPUT);
  pinMode(rowGroundMboo, OUTPUT);
  digitalWrite(rowPowerMboo, HIGH);
  digitalWrite(rowGroundMboo, LOW);

  pinMode(columPowerMboo, HIGH);
  pinMode(columGroundMboo, LOW);
  digitalWrite(columPowerMboo, HIGH);
  digitalWrite(columGroundMboo, LOW);
  //init row io
  pinMode(doRow1Mboo, OUTPUT);
  pinMode(doRow2Mboo, OUTPUT);
  pinMode(doRow3Mboo, OUTPUT);
  pinMode(doRow4Mboo, OUTPUT);
  pinMode(doRow5Mboo, OUTPUT);
  pinMode(doRow6Mboo, OUTPUT);
  pinMode(doRow7Mboo, OUTPUT);
  pinMode(doRow8Mboo, OUTPUT);

  digitalWrite(doRow1Mboo, HIGH);
  digitalWrite(doRow2Mboo, HIGH);
  digitalWrite(doRow3Mboo, HIGH);
  digitalWrite(doRow4Mboo, HIGH);
  digitalWrite(doRow5Mboo, HIGH);
  digitalWrite(doRow6Mboo, HIGH);
  digitalWrite(doRow7Mboo, HIGH);
  digitalWrite(doRow8Mboo, HIGH);

  //init height io
  pinMode(doColum1Mboo, OUTPUT);
  pinMode(doColum2Mboo, OUTPUT);
  pinMode(doColum3Mboo, OUTPUT);
  pinMode(doColum4Mboo, OUTPUT);
  pinMode(doColum5Mboo, OUTPUT);
  pinMode(doColum6Mboo, OUTPUT);
  pinMode(doColum7Mboo, OUTPUT);
  pinMode(doColum8Mboo, OUTPUT);

  digitalWrite(doColum1Mboo, HIGH);
  digitalWrite(doColum2Mboo, HIGH);
  digitalWrite(doColum3Mboo, HIGH);
  digitalWrite(doColum4Mboo, HIGH);
  digitalWrite(doColum5Mboo, HIGH);
  digitalWrite(doColum6Mboo, HIGH);
  digitalWrite(doColum7Mboo, HIGH);
  digitalWrite(doColum8Mboo, HIGH);
}
void loadProduct(int a_vendingId , int a_productPos) {
  int a_delay(2850);
  
   if (a_vendingId == 1) {
    switch (a_productPos) {
      case 11:
        digitalWrite(doRow1Mboo, LOW);
        digitalWrite(doColum1Mboo, LOW);
        delay(a_delay);
        digitalWrite(doRow1Mboo,HIGH );
        digitalWrite(doColum1Mboo, HIGH);
        Serial.print("productPos: ");
        Serial.println(a_productPos);
        break;
      case 13:
        digitalWrite(doRow3Mboo, LOW);
        digitalWrite(doColum1Mboo, LOW);
        delay(a_delay);
        digitalWrite(doRow3Mboo,HIGH );
        digitalWrite(doColum1Mboo, HIGH);
        Serial.print("productPos: ");
        Serial.println(a_productPos);
        break;
      case 15:
        digitalWrite(doRow5Mboo, LOW);
        digitalWrite(doColum1Mboo, LOW);
        delay(a_delay);
        digitalWrite(doRow5Mboo,HIGH );
        digitalWrite(doColum1Mboo, HIGH);
        Serial.print("productPos: ");
        Serial.println(a_productPos);
        break;
      case 17:
        digitalWrite(doRow7Mboo, LOW);
        digitalWrite(doColum1Mboo, LOW);
        delay(a_delay);
        digitalWrite(doRow7Mboo,HIGH );
        digitalWrite(doColum1Mboo, HIGH);
        Serial.print("productPos: ");
        Serial.println(a_productPos);
        break;
      case 21:
        digitalWrite(doRow1Mboo, LOW);
        digitalWrite(doColum2Mboo, LOW);
        delay(a_delay);
        digitalWrite(doRow1Mboo,HIGH );
        digitalWrite(doColum2Mboo, HIGH);
        Serial.print("productPos: ");
        Serial.println(a_productPos);
        break;
      case 23:
        digitalWrite(doRow3Mboo, LOW);
        digitalWrite(doColum2Mboo, LOW);
        delay(a_delay);
        digitalWrite(doRow3Mboo,HIGH );
        digitalWrite(doColum2Mboo, HIGH);
        Serial.print("productPos: ");
        Serial.println(a_productPos);
        break;
      case 25:
        digitalWrite(doRow5Mboo, LOW);
        digitalWrite(doColum2Mboo, LOW);
        delay(a_delay);
        digitalWrite(doRow5Mboo,HIGH );
        digitalWrite(doColum2Mboo, HIGH);
        Serial.print("productPos: ");
        Serial.println(a_productPos);
        break;
      case 26:
        digitalWrite(doRow6Mboo, LOW);
        digitalWrite(doColum2Mboo, LOW);
        delay(a_delay);
        digitalWrite(doRow6Mboo,HIGH );
        digitalWrite(doColum2Mboo, HIGH);
        Serial.print("productPos: ");
        Serial.println(a_productPos);
        break;
      case 27:
        digitalWrite(doRow7Mboo, LOW);
        digitalWrite(doColum2Mboo, LOW);
        delay(a_delay);
        digitalWrite(doRow7Mboo,HIGH );
        digitalWrite(doColum2Mboo, HIGH);
        Serial.print("productPos: ");
        Serial.println(a_productPos);
        break;
      case 28:
        digitalWrite(doRow8Mboo, LOW);
        digitalWrite(doColum2Mboo, LOW);
        delay(a_delay);
        digitalWrite(doRow8Mboo,HIGH );
        digitalWrite(doColum2Mboo, HIGH);
        Serial.print("productPos: ");
        Serial.println(a_productPos);
        break;
      case 31:
        digitalWrite(doRow1Mboo, LOW);
        digitalWrite(doColum3Mboo, LOW);
        delay(a_delay);
        digitalWrite(doRow1Mboo,HIGH );
        digitalWrite(doColum3Mboo, HIGH);
        Serial.print("productPos: ");
        Serial.println(a_productPos);
        break;
      case 33:
        digitalWrite(doRow3Mboo, LOW);
        digitalWrite(doColum3Mboo, LOW);
        delay(a_delay);
        digitalWrite(doRow3Mboo,HIGH );
        digitalWrite(doColum3Mboo, HIGH);
        Serial.print("productPos: ");
        Serial.println(a_productPos);
        break;
      case 35:
        digitalWrite(doRow5Mboo, LOW);
        digitalWrite(doColum3Mboo, LOW);
        delay(a_delay);
        digitalWrite(doRow5Mboo,HIGH );
        digitalWrite(doColum3Mboo, HIGH);
        Serial.print("productPos: ");
        Serial.println(a_productPos);
        break;
      case 37:
        digitalWrite(doRow7Mboo, LOW);
        digitalWrite(doColum3Mboo, LOW);
        delay(a_delay);
        digitalWrite(doRow7Mboo,HIGH );
        digitalWrite(doColum3Mboo, HIGH);
        Serial.print("productPos: ");
        Serial.println(a_productPos);
        break;
      case 41:
        digitalWrite(doRow1Mboo, LOW);
        digitalWrite(doColum4Mboo, LOW);
        delay(a_delay);
        digitalWrite(doRow1Mboo,HIGH );
        digitalWrite(doColum4Mboo, HIGH);
        Serial.print("productPos: ");
        Serial.println(a_productPos);
        break;
      case 42:
        digitalWrite(doRow2Mboo, LOW);
        digitalWrite(doColum4Mboo, LOW);
        delay(a_delay);
        digitalWrite(doRow2Mboo,HIGH );
        digitalWrite(doColum4Mboo, HIGH);
        Serial.print("productPos: ");
        Serial.println(a_productPos);
        break;
      case 43:
        digitalWrite(doRow3Mboo, LOW);
        digitalWrite(doColum4Mboo, LOW);
        delay(a_delay);
        digitalWrite(doRow3Mboo,HIGH );
        digitalWrite(doColum4Mboo, HIGH);
        Serial.print("productPos: ");
        Serial.println(a_productPos);
        break;
      case 44:
        digitalWrite(doRow4Mboo, LOW);
        digitalWrite(doColum4Mboo, LOW);
        delay(a_delay);
        digitalWrite(doRow4Mboo,HIGH );
        digitalWrite(doColum4Mboo, HIGH);
        Serial.print("productPos: ");
        Serial.println(a_productPos);
        break;
      case 45:
        digitalWrite(doRow5Mboo, LOW);
        digitalWrite(doColum4Mboo, LOW);
        delay(a_delay);
        digitalWrite(doRow5Mboo,HIGH );
        digitalWrite(doColum4Mboo, HIGH);
        Serial.print("productPos: ");
        Serial.println(a_productPos);
        break;
      case 46:
        digitalWrite(doRow6Mboo, LOW);
        digitalWrite(doColum4Mboo, LOW);
        delay(a_delay);
        digitalWrite(doRow6Mboo,HIGH );
        digitalWrite(doColum4Mboo, HIGH);
        Serial.print("productPos: ");
        Serial.println(a_productPos);
        break;
      case 47:
        digitalWrite(doRow7Mboo, LOW);
        digitalWrite(doColum4Mboo, LOW);
        delay(a_delay);
        digitalWrite(doRow7Mboo,HIGH );
        digitalWrite(doColum4Mboo, HIGH);
        Serial.print("productPos: ");
        Serial.println(a_productPos);
        break;
      case 48:
        digitalWrite(doRow8Mboo, LOW);
        digitalWrite(doColum4Mboo, LOW);
        delay(a_delay);
        digitalWrite(doRow8Mboo,HIGH );
        digitalWrite(doColum4Mboo, HIGH);
        Serial.print("productPos: ");
        Serial.println(a_productPos);
        break;
      case 51:
        digitalWrite(doRow1Mboo, LOW);
        digitalWrite(doColum5Mboo, LOW);
        delay(a_delay);
        digitalWrite(doRow1Mboo,HIGH );
        digitalWrite(doColum5Mboo, HIGH);
        Serial.print("productPos: ");
        Serial.println(a_productPos);
        break;
      case 52:
        digitalWrite(doRow2Mboo, LOW);
        digitalWrite(doColum5Mboo, LOW);
        delay(a_delay);
        digitalWrite(doRow2Mboo,HIGH );
        digitalWrite(doColum5Mboo, HIGH);
        Serial.print("productPos: ");
        Serial.println(a_productPos);
        break;
      case 53:
        digitalWrite(doRow3Mboo, LOW);
        digitalWrite(doColum5Mboo, LOW);
        delay(a_delay);
        digitalWrite(doRow3Mboo,HIGH );
        digitalWrite(doColum5Mboo, HIGH);
        Serial.print("productPos: ");
        Serial.println(a_productPos);
        break;
      case 54:
        digitalWrite(doRow4Mboo, LOW);
        digitalWrite(doColum5Mboo, LOW);
        delay(a_delay);
        digitalWrite(doRow4Mboo,HIGH );
        digitalWrite(doColum5Mboo, HIGH);
        Serial.print("productPos: ");
        Serial.println(a_productPos);
        break;
      case 55:
        digitalWrite(doRow5Mboo, LOW);
        digitalWrite(doColum5Mboo, LOW);
        delay(a_delay);
        digitalWrite(doRow5Mboo,HIGH );
        digitalWrite(doColum5Mboo, HIGH);
        Serial.print("productPos: ");
        Serial.println(a_productPos);
        break;
      case 56:
        digitalWrite(doRow6Mboo, LOW);
        digitalWrite(doColum5Mboo, LOW);
        delay(a_delay);
        digitalWrite(doRow6Mboo,HIGH );
        digitalWrite(doColum5Mboo, HIGH);
        Serial.print("productPos: ");
        Serial.println(a_productPos);
        break;
      default:
        // statements
        break;
    };
  }
}


