<?php
    // for hangul.
    header("Content-Type:text/html;charset=utf-8");
    
    // error_reporting(E_ALL);
    // ini_set("display_errors", 1);

    //각종 모듈 로드
    include_once("/app/modules/common.php");

    @session_start();
    if(!isset($_SESSION['login_session'])){
        alertback("로그인이 필요한 서비스입니다.");
    }

    // session value check
    $id = $_SESSION['id'];

    // POST 값 확인
    $del_id = $_POST['del_id'];

    //id 보안처리
    $secure_id = prevent_sqli($id);

    $del_id = prevent_sqli($del_id);

    //쿼리 전송
    $query = "select * from member where id='{$secure_id}'";
    $row = sql_select($query);

    // admin 확인
    if($_SESSION['admin'] != 1 and $row['admin'] != 1){
        alertback("권한이 부족합니다.");
    }

    // 삭제 대상 확인
    $query = "select * from member where id='{$del_id}'";
    $row = sql_select($query);

    //id가 존재하지 않을 경우 id 존재하지 않음 알림
    if(!isset($row['id'])){
        alertback("아이디가 존재하지 않습니다.");
    }
    else{
        // 삭제 진행
        $query = "DELETE FROM member WHERE id='$del_id'";
        sql_insert($query);

        alertback("계정 삭제에 성공 하였습니다.");
    }
?>