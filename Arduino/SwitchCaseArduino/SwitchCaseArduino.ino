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

bool ItemDeliverdMboo = false;

void setup() {
  Serial.begin(9600);
  initIO();
  Serial.println("setup completed");
}

void loop() {
}

void getProductMboo (int product) {
  switch (product) {
    case 11:
      digitalWrite(doRow1Mboo, LOW);
      digitalWrite(doColum1Mboo, LOW);
      delay(2850);
      digitalWrite(doRow1Mboo, HIGH);
      digitalWrite(doColum1Mboo, HIGH);
      break;
    case 13:
      digitalWrite(doRow3Mboo, LOW);
      digitalWrite(doColum1Mboo, LOW);
      delay(2850);
      digitalWrite(doRow3Mboo, HIGH);
      digitalWrite(doColum1Mboo, HIGH);
      break;
    case 15:
      digitalWrite(doRow5Mboo, LOW);
      digitalWrite(doColum1Mboo, LOW);
      delay(2850);
      digitalWrite(doRow5Mboo, HIGH);
      digitalWrite(doColum1Mboo, HIGH);
      break;
    case 17:
      digitalWrite(doRow7Mboo, LOW);
      digitalWrite(doColum1Mboo, LOW);
      delay(2850);
      digitalWrite(doRow7Mboo, HIGH);
      digitalWrite(doColum1Mboo, HIGH);
      break;
    case 21:
      digitalWrite(doRow1Mboo, LOW);
      digitalWrite(doColum2Mboo, LOW);
      delay(2850);
      digitalWrite(doRow1Mboo, HIGH);
      digitalWrite(doColum2Mboo, HIGH);
      break;
    case 23:
      digitalWrite(doRow3Mboo, LOW);
      digitalWrite(doColum2Mboo, LOW);
      delay(2850);
      digitalWrite(doRow3Mboo, HIGH);
      digitalWrite(doColum2Mboo, HIGH);
      break;
    case 25:
      digitalWrite(doRow5Mboo, LOW);
      digitalWrite(doColum2Mboo, LOW);
      delay(2850);
      digitalWrite(doRow5Mboo, HIGH);
      digitalWrite(doColum2Mboo, HIGH);
      break;
    case 26:
      digitalWrite(doRow6Mboo, LOW);
      digitalWrite(doColum2Mboo, LOW);
      delay(2850);
      digitalWrite(doRow6Mboo, HIGH);
      digitalWrite(doColum2Mboo, HIGH);
      break;
    case 27:
      digitalWrite(doRow7Mboo, LOW);
      digitalWrite(doColum2Mboo, LOW);
      delay(2850);
      digitalWrite(doRow7Mboo, HIGH);
      digitalWrite(doColum2Mboo, HIGH);
      break;
    case 28:
      digitalWrite(doRow8Mboo, LOW);
      digitalWrite(doColum2Mboo, LOW);
      delay(2850);
      digitalWrite(doRow8Mboo, HIGH);
      digitalWrite(doColum2Mboo, HIGH);
      break;
    case 31:
      digitalWrite(doRow1Mboo, LOW);
      digitalWrite(doColum3Mboo, LOW);
      delay(2850);
      digitalWrite(doRow1Mboo, HIGH);
      digitalWrite(doColum3Mboo, HIGH);
      break;
    case 33:
      digitalWrite(doRow3Mboo, LOW);
      digitalWrite(doColum3Mboo, LOW);
      delay(2850);
      digitalWrite(doRow3Mboo, HIGH);
      digitalWrite(doColum3Mboo, HIGH);
      break;
    case 35:
      digitalWrite(doRow5Mboo, LOW);
      digitalWrite(doColum3Mboo, LOW);
      delay(2850);
      digitalWrite(doRow5Mboo, HIGH);
      digitalWrite(doColum3Mboo, HIGH);
      break;
    case 37:
      digitalWrite(doRow7Mboo, LOW);
      digitalWrite(doColum3Mboo, LOW);
      delay(2850);
      digitalWrite(doRow7Mboo, HIGH);
      digitalWrite(doColum3Mboo, HIGH);
      break;
    case 41:
      digitalWrite(doRow1Mboo, LOW);
      digitalWrite(doColum4Mboo, LOW);
      delay(2850);
      digitalWrite(doRow1Mboo, HIGH);
      digitalWrite(doColum4Mboo, HIGH);
      break;
    case 42:
      digitalWrite(doRow2Mboo, LOW);
      digitalWrite(doColum4Mboo, LOW);
      delay(2850);
      digitalWrite(doRow2Mboo, HIGH);
      digitalWrite(doColum4Mboo, HIGH);
      break;
    case 43:
      digitalWrite(doRow3Mboo, LOW);
      digitalWrite(doColum4Mboo, LOW);
      delay(2850);
      digitalWrite(doRow3Mboo, HIGH);
      digitalWrite(doColum4Mboo, HIGH);
      break;
    case 44:
      digitalWrite(doRow4Mboo, LOW);
      digitalWrite(doColum4Mboo, LOW);
      delay(2850);
      digitalWrite(doRow4Mboo, HIGH);
      digitalWrite(doColum4Mboo, HIGH);
      break;
    case 45:
      digitalWrite(doRow5Mboo, LOW);
      digitalWrite(doColum4Mboo, LOW);
      delay(2850);
      digitalWrite(doRow5Mboo, HIGH);
      digitalWrite(doColum4Mboo, HIGH);
      break;
    case 46:
      digitalWrite(doRow6Mboo, LOW);
      digitalWrite(doColum4Mboo, LOW);
      delay(2850);
      digitalWrite(doRow6Mboo, HIGH);
      digitalWrite(doColum4Mboo, HIGH);
      break;
    case 47:
      digitalWrite(doRow7Mboo, LOW);
      digitalWrite(doColum4Mboo, LOW);
      delay(2850);
      digitalWrite(doRow7Mboo, HIGH);
      digitalWrite(doColum4Mboo, HIGH);
      break;
    case 48:
      digitalWrite(doRow8Mboo, LOW);
      digitalWrite(doColum4Mboo, LOW);
      delay(2850);
      digitalWrite(doRow8Mboo, HIGH);
      digitalWrite(doColum4Mboo, HIGH);
      break;
    case 51:
      digitalWrite(doRow1Mboo, LOW);
      digitalWrite(doColum5Mboo, LOW);
      delay(2850);
      digitalWrite(doRow1Mboo, HIGH);
      digitalWrite(doColum5Mboo, HIGH);
      break;
    case 52:
      digitalWrite(doRow2Mboo, LOW);
      digitalWrite(doColum5Mboo, LOW);
      delay(2850);
      digitalWrite(doRow2Mboo, HIGH);
      digitalWrite(doColum5Mboo, HIGH);
      break;
    case 53:
      digitalWrite(doRow3Mboo, LOW);
      digitalWrite(doColum5Mboo, LOW);
      delay(2850);
      digitalWrite(doRow3Mboo, HIGH);
      digitalWrite(doColum5Mboo, HIGH);
      break;
    case 54:
      digitalWrite(doRow4Mboo, LOW);
      digitalWrite(doColum5Mboo, LOW);
      delay(2850);
      digitalWrite(doRow4Mboo, HIGH);
      digitalWrite(doColum5Mboo, HIGH);
      break;
    case 55:
      digitalWrite(doRow5Mboo, LOW);
      digitalWrite(doColum5Mboo, LOW);
      delay(2850);
      digitalWrite(doRow5Mboo, HIGH);
      digitalWrite(doColum5Mboo, HIGH);
      break;
    case 56:
      digitalWrite(doRow6Mboo, LOW);
      digitalWrite(doColum5Mboo, LOW);
      delay(2850);
      digitalWrite(doRow6Mboo, HIGH);
      digitalWrite(doColum5Mboo, HIGH);
      break;
    default:
      // statements
      break;
  };
}

void initIO() {
  Serial.println("TEST");
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
}
