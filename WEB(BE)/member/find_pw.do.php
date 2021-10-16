<?php
    // input name, serialnumber, ID

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

    // POST 값 받아오기
    $name = $_POST['name'];
    $serialnumber = $_POST['serialnumber'];
    $id = $_POST['ID'];


    //name 필드 검사
    if(!isset($name)){
        alertback("성함을 입력해주세요.");
    }

    //serialnumber 필드 검사
    if(!isset($serialnumber)){
        alertback("군번을 입력해주세요.");
    }

    //id 필드 검사
    if(!isset($id)){
        alertback("아이디를 입력해주세요.");
    }

    $time_check = time();
    $passwd_value = $serialnumber + $time_check;
    $passwd_value = md5($passwd_value);

    //패스워드를 sha256으로 해싱
    $n_password = passhash($passwd_value);
    $safe_var=array(prevent_sqli($name), prevent_sqli($serialnumber), prevent_sqli($id), prevent_sqli($n_password));

    //쿼리 전송
    $query = "select * from member where name='{$safe_var[0]}' AND serialnumber='{$safe_var[1]}' AND id='{$safe_var[2]}'";
    $row = sql_select($query);

    //id가 존재하지 않을 경우 id 존재하지 않음 알림
    if(!isset($row['id'])){
        alertback("아이디가 존재하지 않습니다. 비회원이시라면 회원가입해주십시오.");
    }else{
        //모두 확인하여 이상이 없으므로 DB에 데이터 넣기
        $query = "update member set password='{$safe_var[3]}' where name='{$safe_var[0]}' AND serialnumber='{$safe_var[1]}' AND id='{$safe_var[2]}'";
        sql_insert($query);

        // 임시 비밀번호 발급
        alert($name."님의 임시 비밀번호는". $passwd_value."입니다.");
        redirect("../login.html");
    }
?>