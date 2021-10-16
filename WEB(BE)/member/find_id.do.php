<?php
    // input name, 군번

    // for hangul.
    header("Content-Type:text/html;charset=utf-8");
    
    //각종 모듈 로드
    include_once("/app/modules/common.php");

    # error_reporting(E_ALL);
    # ini_set("display_errors", 1);

    //METHOD 확인
    if($_SERVER["REQUEST_METHOD"] != "POST"){
        alertback("잘못된 요청 입니다.");
    }

    //POST 
    $name = $_POST['name'];
    $serialnumber = $_POST['serialnumber'];


    //name 필드 확인 
    if(!isset($name)){
        alertback("성함을 입력해주세요.");
    }

    //serialnumber 필드 확인
    if(!isset($serialnumber)){
        alertback("군번을 입력해주세요.");
    }

    //SQL injection 방지
    $safe_var=array(prevent_sqli($name), prevent_sqli($serialnumber));

    //쿼리 전송
    $query = "select * from member where name='{$name}' AND serialnumber='{$serialnumber}'";
    $row = sql_select($query);

    //id가 존재하지 않을 경우 id 존재하지 않음 알림
    if(!isset($row['id'])){
        alertback("아이디가 존재하지 않습니다. 비회원이시라면 회원가입해주십시오.");
    }

    $find_id = $row['id'];

    // 아이디 alert
    alert($name."님의 아이디는 ".$find_id."입니다.");
    redirect("../login.html");
?>