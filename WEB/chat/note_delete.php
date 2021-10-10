<?php
require_once("/app/modules/common.php");

if(!isset($_SESSION['login_session'])){
        alertback("로그인 상태가 아닙니다. 로그인 후 이용해주세요.");
    }

$num = $_GET['idx'];
$query = "select * from note where idx='".$num."'";
$sql = mysqli_query($db, $query);
$recv = $sql->fetch_array();

if($recv['recv_id']!==$_SESSION['id'] and $recv['send_id']!==$_SESSION['id']){
	alert("비정상적인 접근이 감지되었습니다.");
    return 0;
}

if($recv['recv_id']===$_SESSION['id']){
    mysqli_query($db, "update note set r_del=1 where idx='$num';");
}

if($recv['send_id']===$_SESSION['id']){
    mysqli_query($db, "update note set s_del=1 where idx='$num';");
}


?>
<script type="text/javascript">alert("삭제되었습니다.");</script>
<meta http-equiv="refresh" content="0 url=note_recv.php" />
