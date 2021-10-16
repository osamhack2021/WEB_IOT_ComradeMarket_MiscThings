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

    //METHOD 확인
    if($_SERVER["REQUEST_METHOD"] != "GET"){
        alertback("잘못된 요청 입니다.");
    }

    // session value check 
    $id = $_SESSION['id'];
    $name = $_SESSION['name'];
    $admin = $_SESSION['admin'];

    // GET 값 확인
    $aid = $_GET['aid'];

    //id와 password 보안처리
    $secure_aid = prevent_sqli($aid);

    //쿼리 전송
    $query = "select * from product where articleid='{$secure_aid}'";
    $row = sql_select($query);

    //articleid가 존재하지 않을 경우 articleid 존재하지 않음 알림
    if(!isset($row['articleid'])){
        alertback("아이디가 존재하지 않습니다.");
    }
    else{
        if($row["id"] == $id or $admin == 1){
            // DB 삭제
            $query = "DELETE FROM product WHERE articleid='$secure_aid'";
            sql_insert($query);

            // 메인페이지로 리다이렉트
            alert("상품 삭제에 성공 하였습니다.");
            redirect("../shop.php");
        }else{
            alertback("권한을 확인해주세요.");
        }
    }
?>