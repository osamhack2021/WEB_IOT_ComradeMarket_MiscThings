<!DOCTYPE html>
<html lang="en">

<head>
    <title>전우장터 - 쪽지 글 조회</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="assets/img/apple-icon.png">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/templatemo.css">
    <link rel="stylesheet" href="assets/css/custom.css">

    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">

    <!-- Slick -->
    <link rel="stylesheet" type="text/css" href="assets/css/slick.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/slick-theme.css">

</head>

<?php
    // report DB에서 aid 기준이나, 시리얼 번호 기준으로 정보 가져와서 출력
    include_once("/app/modules/common.php");
    
    // error_reporting(E_ALL);
    // ini_set("display_errors", 1);

    // 필요한 값 가져오기
    $aid = $_GET['idx'];

    $secure_id = $_SESSION['id'];
    $name = $_SESSION['name'];

    if(!isset($aid)){
        alertback("조회에 실패하였습니다.");
    }
    
    $aid = prevent_sqli($aid);

    # 게시글 값 가져오기
    $sql = "SELECT * FROM note where idx='{$aid}'";
    $result = sql_select($sql);

    // 쿼리 조회 결과가 있는지 확인
    if($result) {
        // echo "조회 성공";
    } else {
        echo mysqli_error($db);
        // alert("실패..");
    }

    ###########################################################################################

    # 결과값 가져오기 
    $titile = $result['title'];
    $content = $result['content'];

    $recv_id = $result['recv_id'];
    $send_id = $result['send_id'];

    $recv_chk = $result['recv_chk'];
    $send_date = $result['send_date'];
    $goods = $result['goods'];

    $r_del = $result['r_del'];
    $s_del = $result['s_del'];
    $sell = $result['sell'];

    # 조회 값 체크 -> 업데이트
    if($recv_id == $secure_id){
        $query = "update note set recv_chk='1' where idx='{$aid}'";
        $result = sql_insert($query);
    }

?> 

<body>
    <!-- Header -->
	<?php include "header.php"; ?>

    <!-- Start Content Page -->
    <div class="container-fluid bg-light py-5">
        <div class="col-md-6 m-auto text-center">
            <h1 class="h1">쪽지 조회</h1>
            <p>
                <?php echo $name;?>님, 즐거운 하루 보내세요!<br>
                전우장터와 함께, 즐거운 거래가 되시길 기원합니다. 
            </p>
        </div>
    </div>

    <!-- Open Content -->
    <div class="container py-5">
        <div class="row py-5">
            <h1 class="h5"> 보낸 사람 : <?php echo $send_id; ?>  </h1>
            <h1 class="h5"> 받는 사람 : <?php echo $recv_id; ?>  </h1>
            <h1 class="h5"> 작성시간 : <?php echo $send_date; ?> </h1>
        </div>

        <div class="row py-5">
            <h1 class="h2"> 제목 : <?php echo $titile; ?></h1>
            <h1 class="h2">본문 내용</h4>
            <p><?php echo $content; ?></p>
        </div>

        <div class="row py-5">
            <form class="col-md-9 m-auto" method="POST" role="form">
                <div class="row pb-3">
                    <div class="col d-grid">
                        <button type="button" class="btn btn-success btn-lg" onclick = "location.href = 'letter-reply.php?idx=<?php echo $aid; ?>'; ">답글 작성</button>
                    </div>
                    <div class="col d-grid">
                        <button type="button" class="btn btn-success btn-lg" onclick = "location.href = 'chat/note_delete.php?idx=<?php echo $aid; ?>'; ">쪽지 삭제</button>
                    </div>
                    <div class="col d-grid">
                        <button type="button" class="btn btn-success btn-lg" onclick = "location.href = 'shop-contents.php?aid=<?php echo $goods; ?>'; ">물품 조회</button>
                    </div>
                    <div class="col d-grid">
                        <button type="button" class="btn btn-success btn-lg" onclick = "location.href = 'qr/trade_set.php?idx=<?php echo $aid; ?>'; ">거래 완료</button>
                    </div>
                    <?php
                        if($sell == 1){
                            echo '
                            <div class="col d-grid">
                            <button type="button" class="btn btn-success btn-lg" onclick = "location.href = ' . "'qr_read.php?aid=" . $goods .  "';" .'">QR 조회</button>
                            </div>
                            ';
                        }
                    ?>
                </div>
            </form>
        </div>
    </div>
    <!-- Close Content -->

    
    <!-- footer -->
	<?php include "footer.php"; ?>

    <!-- Start Script -->
    <script src="assets/js/jquery-1.11.0.min.js"></script>
    <script src="assets/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/templatemo.js"></script>
    <script src="assets/js/custom.js"></script>
    <!-- End Script -->

</body>

</html>