<?php
    require_once("/app/modules/common.php");

    if(!isset($_SESSION['login_session'])){
            alertback("로그인 상태가 아닙니다. 로그인 후 이용해주세요.");
    }
    
    $id = $_SESSION['id'];
    $name = $_SESSION['name'];

    $aid = $_POST['aid'];
    $recv_name = $_POST['recv_name'];

    // aid 필드 공백 여부 확인 
    if(!isset($aid)){
        alert("aid를 입력해주세요.");
    }else{
        if(iconv_strlen($aid,'utf-8') <= 0) {
            alertback("aid 값을 확인해주세요.");
        }
    }

    //id 필드 공백여부 확인 및 계정 존재 여부 확인
    if(!isset($recv_name)){
        alert("받으실 분을 입력해주세요.");
    }
    else{
        if(iconv_strlen($recv_name,'utf-8')>100 or iconv_strlen($recv_name,'utf-8') <= 0) {
            alertback("받으실 분의 id가 너무 깁니다..");
        }

        //중복 체크
        $secure_id = prevent_sqli($id);

        $query = "select * from member where id='{$secure_id}'";
        $row = sql_select($query);

        if($row != False){
            
        }else{
            alertback("해당 ID는 존재하지 않습니다.");
        }
    }


    // $title = $_POST['title'];
    //$content = $_POST['content'];

    $title = $id . " 님이 구매의사를 밝혔습니다.";
    $content = "ID : " . $id . "   사용자가 구매하길 원합니다. 해당 편지에 회신함으로써, 구매자와 연락을 진행해보세요!";

    // SQL injection 방지
    $recv_check = 0;
    $safe_var=array(prevent_sqli($recv_name), prevent_sqli($id), prevent_sqli($title), prevent_sqli($content), prevent_sqli($recv_check), prevent_sqli($aid));

    // $sql1 = "insert into note(recv_id,send_id,title,content,recv_chk) values('".$_POST['recv_name']."','".$_SESSION['id']."','".$_POST['title']."','".$_POST['content']."','0')";
    #$sql2 = "insert into note(recv_id,send_id,title,content) values('".$_POST['recv_name']."','".$_SESSION['id']."','".$_POST['title']."','".$_POST['content']."')";
    // sql_insert($sql1);

    #sql_insert($sql2);
    // echo $sql1;

    $query = "INSERT INTO note(`recv_id`, `send_id`, `title`, `content`, `recv_chk`, `goods`) VALUES ('{$safe_var[0]}', '{$safe_var[1]}', '{$safe_var[2]}', '{$safe_var[3]}', '{$safe_var[4]}', '{$safe_var[5]}')";
    // var_dump($query);
    // mysqli_query($db, $query);
    # sql_insert($query);

    $result = sql_insert($query);
    if($result === false){
        alertback("치명적인 오류가 발생하였습니다.");
        echo mysqli_error($db);
    }

    alertback("판매자에게 쪽지를 보냈습니다.");
    
    // echo "<script>alert('쪽지를 보냈습니다.'); location.href='note_send.php'; </script>";
?>
