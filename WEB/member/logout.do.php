<?php
    // For hangul
    header("Content-Type:text/html;charset=utf-8");

    // For alertback() method.
    //각종 모듈 로드
    include_once("/app/modules/common.php");

    if(!isset($_SESSION['login_session'])){
        alertback("로그인 상태가 아닙니다. 로그인 후 이용해주세요.");
    }

    // Normal logout response
    $user = $_SESSION['login_session'];
    session_destroy();
    alert("성공적으로 로그아웃되었습니다.");

    // Do not response with history.back(-1);
    redirect("../index.html");
?>