#include <SPI.h>
#include <Ethernet.h>
#include <SimpleTimer.h>

//simpel timer configuration
SimpleTimer timer;

//ip configuration arduino
byte mac[] = { 0x00, 0xAA, 0xBB, 0xCC, 0xDA, 0x02 };
IPAddress ip(192, 168, 0, 40);
EthernetServer server(80);

//IO
int  productId = 23;

//globals
boolean serverUp = false;
boolean clientAvailable = false;
String clientString;

//interval for the timer
int timerInterval(50);

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

void setup() {
  Serial.begin(9600);
  initIO();
  initGlobals();
  // initLibs();
  Serial.println("Setup completed");
}

void loop() {
  timer.run();
  
  ListenForEthernetClients();

}

void repeatMe() {
}

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
//          client.print("{\"sensors\":{" 
//                        " \"sensor1\":" + String(sensor1) + 
//                        ", \"sensor2\":" + String(sensor2) + 
//                        ", \"sensor3\":" + String(sensor3) + 
//                        ", \"sensor4\":" + String(sensor4) + 
//                        ", \"sensor5\":" + String(sensor5) + 
//                        ", \"sensor6\":" + String(sensor6) + 
//                        "}, \"blocks\": {"
//                        " \"block1\":" + String(block1) + 
//                        ", \"block2\":" + String(block2) + 
//                        ", \"block3\":" + String(block3) + 
//                        ", \"block4\":" + String(block4) + 
//                        "}}");

          client.print("{\"sensors\":[");
          client.print(" {\"io\":" + String(1) + ", \"sensor\":" + String(1) + "},");
          client.print(" {\"io\":" + String(1) + ", \"sensor\":" + String(1) + "},");
          client.print(" {\"io\":" + String(1) + ", \"sensor\":" + String(1) + "},");
          client.print(" {\"io\":" + String(1) + ", \"sensor\":" + String(1) + "},");
          client.print(" {\"io\":" + String(1) + ", \"sensor\":" + String(1) + "},");
          client.print(" {\"io\":" + String(1) + ", \"sensor\":" + String(1) + "}");
          client.print("]}");

//          client.print("}, \"wissels\":{");
//          client.print(" \"wissel1\":" + String(wissel1));
//          client.print(", \"wissel2\":" + String(wissel2));
//          client.print(", \"wissel3\":" + String(wissel3));
//          client.print(", \"wissel4\":" + String(wissel4));
//          client.print("}, \"blocks\": {");
//          client.print(" \"block1\":" + String(block1));
//          client.print(", \"block2\":" + String(block2));
//          client.print(", \"block3\":" + String(block3));
//          client.print(", \"block4\":" + String(block4));
//          client.println("}}");

          
//          client.print("{\"sensors\":{");
//          client.print(" \"sensor1\":");
//          client.print(", \"sensor2\":");
//          client.print(", \"sensor3\":" + String(sensor3));
//          client.print(", \"sensor4\":" + String(sensor4));
//          client.print(", \"sensor5\":" + String(sensor5));
//          client.print(", \"sensor6\":" + String(sensor6));
//          client.print("}, \"blocks\": {");
//          client.print(" \"block1\":" + String(block1));
//          client.print(", \"block2\":" + String(block2));
//          client.print(", \"block3\":" + String(block3));
//          client.print(", \"block4\":" + String(block4));
//          client.println("}}");
                        
          //only calls the decode function if gettingStatus is not set
          if(clientString.indexOf("gettingStatus=1") == -1){
//            DecodeString(clientString);
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

void initIO() {
  Serial.print("InitIO..");

  //init relai power io
  pinMode(rowPowerMboo, OUTPUT);
  pinMode(rowGroundMboo, OUTPUT);
  digitalWrite(rowPowerMboo, HIGH);
  digitalWrite(rowGroundMboo, LOW);

  pinMode(columPowerMboo, OUTPUT);
  pinMode(columGroundMboo, OUTPUT);
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

  //set timer interval
  timer.setInterval(timerInterval, repeatMe);

  Serial.println("Ok");

  Serial.print("timer interval: " );
  Serial.print(timerInterval);
  Serial.println(" ms");
}

void initGlobals() {
  Serial.print("Init Globals..");

  serverUp = false;
  clientAvailable = false;
  clientString = "";
  Serial.println("Ok");
}

void getProjectMboo (int product) {
  switch (product) {
    case 11:
      // statements
      break;
    case 13:
      // statements
      break;
    case 15:
      // statements
      break;
    case 17:
      // statements
      break;
    case 21:
      // statements
      break;
    case 23:
      Serial.println("TEST");
      break;
    case 25:
      // statements
      break;
    case 26:
      // statements
      break;
    case 27:
      // statements
      break;
    case 28:
      // statements
      break;
    case 31:
      // statements
      break;
    case 33:
      // statements
      break;
    case 35:
      // statements
      break;
    case 37:
      // statements
      break;
    case 41:
      // statements
      break;
    case 42:
      // statements
      break;
    case 43:
      // statements
      break;
    case 44:
      // statements
      break;
    case 45:
      // statements
      break;
    case 46:
      // statements
      break;
    case 47:
      // statements
      break;
    case 48:
      // statements
      break;
    case 51:
      // statements
      break;
    case 52:
      // statements
      break;
    case 53:
      // statements
      break;
    case 54:
      // statements
      break;
    case 55:
      // statements
      break;
    case 56:
      // statements
      break;
    default:
      // statements
      break;
  };
}
