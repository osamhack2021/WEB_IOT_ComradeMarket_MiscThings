<?php
require_once("/app/modules/common.php");

if(!isset($_SESSION['login_session'])){
        alertback("로그인 상태가 아닙니다. 로그인 후 이용해주세요.");
    }

$sql1 = "insert into note(recv_id,send_id,title,content,recv_chk) values('".$_POST['recv_name']."','".$_SESSION['id']."','".$_POST['title']."','".$_POST['content']."','0')";
sql_insert($sql1);
echo $sql1;
echo "<script>alert('쪽지를 보냈습니다.'); location.href='note_send.php'; </script>";
?>
