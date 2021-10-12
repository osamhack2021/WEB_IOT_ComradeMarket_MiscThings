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
    $id = $_SESSION['id'];

    $password = $_POST['passwd'];

    //id와 password 보안처리
    $secure_id = prevent_sqli($id);
    $password = passhash($password);

    //쿼리 전송
    $query = "select * from member where id='{$secure_id}'";
    $row = sql_select($query);

    //id가 존재하지 않을 경우 id 존재하지 않음 알림
    if(!isset($row['id'])){
        alertback("아이디가 존재하지 않습니다.");
    }
    else{
        if($row["password"] == $password){
            //모두 확인하여 이상이 없으므로 DB에 데이터 넣기
            $query = "DELETE FROM member WHERE id='$secure_id'";
            sql_insert($query);

            //비밀번호 변경 성공 안내 및 메인페이지로 리다이렉트
            alert("계정 삭제에 성공 하였습니다. 전우장터를 이용해주셔서 감사합니다.");
            session_destroy();
            redirect("../index.php");
        }else{
            // 패스워드 오류시 
            alertback("기존 패스워드를 확인해주세요.");
        }
    }
?>