
<?php
    // for hangul.
    header("Content-Type:text/html;charset=utf-8");
    
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);

    //모듈 로드
    include_once("/app/modules/common.php");

    //METHOD 확인
    if($_SERVER["REQUEST_METHOD"] != "POST"){
        alertback("잘못된 요청 입니다.");
    }

    // 로그인 여부 확인
    @session_start();
    if(!isset($_SESSION['login_session'])){
        alertback("로그인이 필요한 서비스입니다.");
    }

?>