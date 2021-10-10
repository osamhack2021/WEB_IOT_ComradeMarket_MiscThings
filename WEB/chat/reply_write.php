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
?>

<aside>
	<ul id="note_menu">
		<li><img src="/imgs/recv.png" alt="recv" title="recv" /><a href="note_recv.php">받은쪽지함</a></li>
		<li><img src="/imgs/send.png" alt="recv" title="recv"  /><a href="note_send.php">보낸쪽지함</a></li>
	</ul>
</aside>
<div id="write_note_in">
	<form action="write_ok.php" method="post" enctype="multipart/form-data">
        <div id="write_t">답장쓰기</div>
        <div id="write_form">
            <div class="wr_ip"><input type="text" name="recv_name" value="<?php echo $recv['send_id']; ?>" required readonly/></div>
            <div class="wr_ip wr_ip_top"><input type="text" name="title" value="RE:"required/></div>
            <div class="wr_ip wr_ip_top"><textarea name="content" placeholder="내용" required></textarea></div>
            <button type="submit" class="wri_bt wr_ip_top">보내기</button>
        </div>
    </form>
</div>
