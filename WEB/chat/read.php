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
}

if($recv['recv_id']===$_SESSION['id']){
	$rec_chk = 1;
	$query1 = "update note set recv_chk = '".$rec_chk."' where idx='".$num."'";
	$fet = mysqli_query($db, $query1);
}

?>

<aside>
	<ul id="note_menu">
		<li><img src="/imgs/recv.png" alt="recv" title="recv" /><a href="note_recv.php">받은쪽지함</a></li>
		<li><img src="/imgs/send.png" alt="recv" title="recv"  /><a href="note_send.php">보낸쪽지함</a></li>
	</ul>
</aside>

<div id="note_util_bt">
		<a href="note_delete.php?idx=<?php echo $recv['idx']; ?>" class="del_bt">삭제</a>
		<a href="reply_write.php?idx=<?php echo $recv['idx']; ?>" class="dap_bt">답장</a>
	</div>
	<div id="no_ri_line"></div>
	<div id="note_info">
		<div id="user_info">
			<ul>
				<li><b>보낸사람</b>&nbsp;&nbsp;&nbsp;<?php echo $recv['send_id']; ?></li>
				<li><b>받은시간</b>&nbsp;&nbsp;&nbsp;<?php echo $recv['send_date']; ?></li>
			</ul>
			<div id="no_ri_line"></div>
		</div>
		<div id="bo_content">
			<?php echo nl2br("$recv[content]"); ?>
		</div>
	</div>
</div>
