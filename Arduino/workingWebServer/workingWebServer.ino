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



void setup()
{
  InitSerial();
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


          client.print(" {\"vendingId\":" + String(1)+ "}");

                        
          //only calls the decode function if gettingStatus is not set
          if(clientString.indexOf("gettingStatus=1") == -1){
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

void DecodeString(String a_string){
  int a_startString = 0;
  int a_endString = 0;
 
  //checks if the string is comming from a website
  if(a_string.indexOf("%24") != -1){
    a_startString = a_string.indexOf("%24") + 3;
    a_endString = a_string.indexOf("%40");
  }else if(a_string.indexOf("$") != -1){
    a_startString = a_string.indexOf("$") + 1;
    a_endString = a_string.indexOf("@");
  }else{
    SerialPrintLn("No start character given", false);
  }

  //checks if the start and end indexes are set if so removes all unnecessary information
  if(a_startString > 0 && a_endString > 0){
    a_string = a_string.substring(a_startString,a_endString);
  }else{
    SerialPrintLn("startString or endString is empty", false);
  }

  //checks if the string has a blockId and a blockStatus if so calls the function Block()
  if(a_string.indexOf("blockId") != -1 && a_string.indexOf("blockStatus")){
    //gets the start index of the blockId and the blockStatus
    int a_startBlockId = a_string.indexOf("blockId") + 8;
    int a_startBlockStat = a_string.indexOf("blockStatus")+12;

    //gets the information required by arduino
    int a_blockId = a_string.substring(a_startBlockId,a_startBlockId+1).toInt();
    int a_blockStat = a_string.substring(a_startBlockStat,a_startBlockStat+1).toInt();
    
//    Block(a_blockId, a_blockStat);
  }

  //checks if the string has a wisselId and a blockStatus if so calls the function Wissel()
  if(a_string.indexOf("wisselId") != -1 && a_string.indexOf("wisselStatus")){
    //gets the start index of the wisselId and the wisselStatus
    int a_starWisselId = a_string.indexOf("wisselId") + 9;
    int a_startWisselStat = a_string.indexOf("wisselStatus")+13;

    //gets the information required by arduino
    int a_wisselId = a_string.substring(a_starWisselId,a_starWisselId+1).toInt();
    int a_wisselStat = a_string.substring(a_startWisselStat,a_startWisselStat+1).toInt();
    
//    Wissel(a_wisselId, a_wisselStat);
  }

  //checks if the string has the speed
  if(a_string.indexOf("speedValue") != -1 && a_string.indexOf("speedDir") != -1){
    //checks if there is a end character for the speed
    if(a_string.indexOf("%21") != -1 || a_string.indexOf("!") != -1){
      int a_startSpeed = a_string.indexOf("speedValue") + 11;
      int a_endSpeed = 0;
      int a_startDirection = a_string.indexOf("speedDir")+9;

      //checks if the speeds end icon is URL encrypted
      if(a_string.indexOf("%21") != -1){
        a_endSpeed = a_string.indexOf("%21");
      }else{
        a_endSpeed = a_string.indexOf("!");      
      }
  
      //gets the information required by arduino
      int a_speed = a_string.substring(a_startSpeed,a_endSpeed).toInt();
      int a_direction = a_string.substring(a_startDirection,a_startDirection+1).toInt();
      
//      Speed(a_speed, a_direction);
    }else{
      SerialPrintLn("The is no ! found", false);
    }
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


