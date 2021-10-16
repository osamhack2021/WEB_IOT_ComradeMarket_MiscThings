#include <Servo.h>

int box_state = 0;
int QR_state = 0;
String qr_sell = "None";
String qr_buy = "None";

Servo servo_2;

void setup()
{
  servo_2.attach(2);
  pinMode(3, INPUT);
  Serial.begin(9600);
}

void loop()
{
  //QR_state = digitalRead(3); //리더기 대용
  QR_state = 1;
  
  if(QR_state == 1){ //리더기 대용 트리거
    QR_Chk(); // 큐알 리드
  }
  
  if(qr_sell == "None"){ // 상품 무
  	servo_2.write(180);
  }
  else{ // 상품 유
    servo_2.write(90);
  }
  
  if(qr_sell == qr_buy){ // 큐알 일치
  	servo_2.write(180);
    qr_sell = "None";
    qr_buy = "None";
  }
  else{ // 큐알 불일치
    qr_buy = "None";
  }
  
  Serial.println(qr_sell);
  Serial.println(qr_buy);
  
  delay(1000);
}

void QR_Chk() {
  if(Serial.available()) { //입력 확인
    String QR_Read = Serial.readStringUntil('\n');
    
    if(qr_sell != "None" && qr_buy == "None"){ // 구매자 QR 인식
      qr_buy = QR_Read;
    }
    
    if(qr_sell == "None"){ //판매자 QR 인식
      qr_sell = QR_Read;
    }
  }
}
