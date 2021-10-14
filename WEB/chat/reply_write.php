<?php
    require_once("/app/modules/common.php");

    if(!isset($_SESSION['login_session'])){
            alertback("로그인 상태가 아닙니다. 로그인 후 이용해주세요.");
    }

    // $num = $_GET['idx'];

    // 필요한 값 POST 가져오기
    $idx = $_POST['idx'];
    $title = $_POST['title'];
    $body = $_POST['body'];

    // # prevent xss
    $body = prevent_xss($body);

    if (!isset($idx)) {
        alertback("idx 번호가 존재하지 않습니다.");
    }

    if (!isset($body)) {
        alertback("답글 내용을 작성해주세요.");
    }

    $safe_idx = prevent_sqli($idx);

    $query = "select * from note where idx='".$safe_idx."'";
    $sql = mysqli_query($db, $query);
    $recv = $sql->fetch_array();

    if($recv['recv_id']!==$_SESSION['id'] or $recv['send_id']!==$_SESSION['id']){
        alert("비정상적인 접근이 감지되었습니다.");
    }

    // write_ok part 

    $recv_name = $_POST['recv_name'];
    $goods = $_POST['goods'];
    $id = $_SESSION['id'];

    // $title = $_POST['title'];
    // $content = $_POST['content'];

    //id 필드 공백여부 확인 및 계정 존재 여부 확인
    if(!isset($recv_name)){
        alert("받으실 분을 입력해주세요.");
    }
    else{
        if(iconv_strlen($id,'utf-8')>100 or iconv_strlen($id,'utf-8') <= 0) {
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

    //id 필드 공백여부 확인 및 계정 존재 여부 확인
    if(!isset($title)){
        alert("제목을 입력해주세요.");
    }
    else{
        if(iconv_strlen($title,'utf-8')>100 or iconv_strlen($title,'utf-8') <= 0) {
            alertback("제목은 30자 이내로 입력해주시길 바랍니다.");
        }
    }

    //id 필드 공백여부 확인 및 계정 존재 여부 확인
    if(!isset($body)){
        alert("본문을 입력해주세요.");
    }
    else{
        if(iconv_strlen($body,'utf-8')>1000 or iconv_strlen($body,'utf-8') <= 0) {
            alertback("본문은 1000자 이내로 입력해주시길 바랍니다.");
        }
    }

    // SQL injection 방지

    $recv_check = 0;

    $safe_var=array(prevent_sqli($recv_name), prevent_sqli($id), prevent_sqli($title), prevent_sqli($body), prevent_sqli($recv_check), prevent_sqli($goods));

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

    alert("쪽지를 보냈습니다.");
    redirect("../letter-send.php");
?>

<!-- 

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

--> 