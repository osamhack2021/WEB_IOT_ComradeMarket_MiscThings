<?php

    header("Content-Type:text/html;charset=utf-8");

    //모듈 로드
    include_once("/app/modules/common.php");
    include_once("qrgen.php");

    // error_reporting(E_ALL);
    // ini_set("display_errors", 1);

    // METHOD 확인
    if ($_SERVER["REQUEST_METHOD"] != "GET") {
        alertback("잘못된 요청 입니다.");
        return;
    }

    @session_start();
    if (!isset($_SESSION['login_session'])) {
        alertback("로그인이 필요한 서비스입니다.");
    }

    // GET 값을 통해 상품 조회 -> 판매자가 맞는지 확인 | 검증
    // - 쪽지 내에서 구매 완료 전달시

    // - 거래방식 체크 → 보관함 거래 체크시
        // - 보관함 거래 진행 (QR 발급)
        // - 게시글 거래완료 처리
        //     - status 값 및 구매자 id 업데이트

    // - 거래방식 체크 → 보관함 X시
        // - 게시글 거래 완료 처리
        //     - status 값 및 구매자 id 업데이트

    $num = $_GET['idx'];

    $query = "select * from note where idx='".$num."'";

    $sql = mysqli_query($db, $query);

    $recv = $sql->fetch_array();
    
    // 쪽지 정보 가져와서, 판단
    if($recv['recv_id']!==$_SESSION['id'] and $recv['send_id']!==$_SESSION['id']){
            alertback("비정상적인 접근이 감지되었습니다.");
    }
    
    if($recv['recv_id'] === $_SESSION['id']){
        alertback("당신은 판매자가 아닙니다.");
    }
    
    #구매자의 유저 정보를 가져옴.
    $query = "select * from member where id = '".$recv['recv_id']."'";
    $result = sql_select($query);
    
    #쪽지에 등록된 goods aid를 통해 상품 정보를 가져옴.
    $query1 = "select * from product where articleid = '".$recv['goods']."'";
    $result1 = sql_select($query1);
    
    #거래확정 여부 판단함.
    # 거래가 이미 확정된 경우, 진행 X
    $query2 = "select sell from note where goods = '".$recv['goods']."' and sell = '1'";
    $result2 = sql_select($query2);
    
    if($result2){
        alertback("이미 거래확정된 상품입니다.");
    }

    # 거래방식 체크 -> 만약, 보관함 거래가 아닐시, QR generater 필요 X
    $check_way = $result1['saleway'];

    if($check_way == 1){
        #거래 확정 후 상품에 구매자 정보 추가
        $query = "update product set buyer = '".$recv['recv_id']."' where articleid = '".$recv['goods']."'";
        // $result = mysqli_query($db, $query);
        sql_insert($query);

        #거래확정 쪽지 insert
        $title = $result1['title']." 상품의 거래가 확정되었습니다.";
        $content = $_SESSION['id'] . "님과의 거래가 확정되었습니다. 보관함 거래가 아니기에, QR 기능은 제공되지 않습니다 ㅠㅠ";

        // 거래 확정 메세지 작성
        $sql1 = "insert into note(recv_id,send_id,title,content,recv_chk,goods,sell) values('".$recv['recv_id']."','".$_SESSION['id']."','".$title."','".$content."','0','".$recv['goods']."','1')";
        $result2 = sql_insert($sql1);

    }else{
        # call qrgen.php
        #aid + recv_id(구매) + session_id(판매) + phone + city + office
        $qrContents = $recv['goods'].",".$recv['recv_id'].",".$_SESSION['id'].$result['phone'].$result['city'].$result['office'];
        // $_POST["qr"] = $qrContents;
        qrGenrater($qrContents);
        
        #거래확정 쪽지 insert
        $title = $result1['title']." 상품의 거래가 확정되었습니다.";
        $content = $_SESSION['id'] . "님과의 거래가 확정되었습니다.   " . 'http://osam.kro.kr/qr_read.php?aid=' . $recv['goods'] . " 해당 링크 혹은, 아래의 버튼을 통해 QR 코드를 확인할 수 있습니다.";

        // 거래 확정 메세지 작성
        $sql1 = "insert into note(recv_id,send_id,title,content,recv_chk,goods,sell) values('".$recv['recv_id']."','".$_SESSION['id']."','".$title."','".$content."','0','".$recv['goods']."','1')";
        $result2 = sql_insert($sql1);
    }

    // 상품 판매 표시 
    $query = "update product set status='1' where articleid = '".$recv['goods']."'";
    sql_insert($query);
    
    alertback($recv['recv_id']."님과의 거래가 확정 되었습니다.");
?>