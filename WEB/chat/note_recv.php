<link rel="stylesheet" href="note_style.css">

<?php
require_once("/app/modules/common.php");

if(!isset($_SESSION['login_session'])){
        alertback("로그인 상태가 아닙니다. 로그인 후 이용해주세요.");
    }
?>

<aside>
	<ul id="note_menu">
		<li><img src="/imgs/recv.png" alt="recv" title="recv" /><a href="note_recv.php"><b>받은쪽지함</b></a></li>
		<li><img src="/imgs/send.png" alt="recv" title="recv"  /><a href="note_send.php">보낸쪽지함</a></li>
	</ul>
</aside>


<div id="main_in">
	<table class="list-table">
    <thead>
      <tr>
        <th width="50" class="tc"><input type="checkbox" /></th>
        <th width="150" class="tl">보낸사람</th>
        <th width="600" class="tl">제목</th>
        <th width="200" class="tc">날짜</th>
      </tr>
    </thead>

    <?php
      $query = "select * from note where recv_id = '".$_SESSION['id']."' and r_del not in('1') order by idx desc";
      $sql = mysqli_query($db,$query);
      while($recv = $sql->fetch_array()){
      $note_title=$recv["title"]; 
        if(strlen($note_title)>30)
          { 
            $note_title=str_replace($recv["title"],mb_substr($recv["title"],0,30,"utf-8")."...",$recv["title"]);
          }
        ?>

        <tbody>
          <tr>
            <td class="tc"><input type="checkbox" /></td>
            <td><?php echo $recv['send_id'];?></td>
            <td><a href='read.php?idx=<?php echo $recv['idx']; ?>'><?php echo $note_title; ?></a></td>
            <td class="tc"><?php echo $recv['send_date']; ?></td>
          </tr>
        </tbody>

      <?php } ?>
    </table>


    <div id="note_bt">
      <ul>
        <li id="wri_m_bt"><a href="write.php">쪽지쓰기</a></li>
      </ul>
    </div>
  </div>


