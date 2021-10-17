<?php
    header("Content-Type:text/html;charset=utf-8");

    //모듈 로드
    include_once("/app/modules/common.php");

    // 디버깅 용도
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    // 세션 값 가져오기
    $id = $_SESSION['id'];
    $name = $_SESSION['name'];
    $admin = $_SESSION['admin'];

    // 필요한 값 POST 가져오기
    $idx = $_POST['idx'];
    $body = $_POST['body'];

    // # prevent xss
    $body = prevent_xss($body);

    if (!isset($idx)) {
        alertback("idx 번호가 존재하지 않습니다.");
    }

    if (!isset($body)) {
        alertback("답변 내용을 작성해주세요.");
    }

    // 유저 검증
    if($admin == 1){
        # status 값 변경
        $status = 1;
        $safe_var=array(prevent_sqli($body), prevent_sqli($status), prevent_sqli($idx));

        //모두 확인하여 이상이 없으므로 DB에 데이터 넣기
        $query = "update report set body_reply='{$safe_var[0]}', reply='{$safe_var[1]}' where idx='{$safe_var[2]}'";
        $result = sql_insert($query);

        alert("답변 완료.");

        redirect('../report-contents.php?idx='.$idx);
    }else{
        alertback("작성 권한이 부족합니다..");
    }
?>