<!DOCTYPE html>
<html lang="en">

<head>
    <title>전우장터 - 쪽지함 (회신)</title>
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

    <!-- Load map styles -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
</head>


<?php
    // 관리자 권한 확인 & 글 번호 확인
    include_once("/app/modules/common.php");

    @session_start();
    if(!isset($_SESSION['login_session'])){
        alertback("로그인이 필요한 서비스입니다.");
    }
    
    // error_reporting(E_ALL);
    // ini_set("display_errors", 1);

    // 필요한 값 가져오기
    $idx = $_GET['idx'];

    $secure_id = $_SESSION['id'];
    // $name = $_SESSION['name'];

    if(!isset($idx)){
        alertback("조회에 실패하였습니다.");
    }
    
    $idx = prevent_sqli($idx);
    # 게시글 값 가져오기
    $sql = "SELECT * FROM note where idx='{$idx}'";
    $result = sql_select($sql);

    // 쿼리 조회 결과가 있는지 확인
    if($result) {
        // echo "조회 성공";
    } else {
        echo mysqli_error($db);
        alert("실패..");
    }

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

    if($recv_id !== $secure_id and $send_id !== $secure_id){
        alertback("비정상적인 접근이 감지되었습니다.");
    }

?> 


<body>
    <!-- Header -->
	<?php include "header.php"; ?>

    <!-- Modal -->
    <div class="modal fade bg-white" id="templatemo_search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="w-100 pt-1 mb-5 text-right">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="get" class="modal-content modal-body border-0 p-0">
                <div class="input-group mb-2">
                    <input type="text" class="form-control" id="inputModalSearch" name="q" placeholder="Search ...">
                    <button type="submit" class="input-group-text bg-success text-light">
                        <i class="fa fa-fw fa-search text-white"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- Start Content Page -->
    <div class="container-fluid bg-light py-5">
        <div class="col-md-6 m-auto text-center">
            <h1 class="h1">답글 작성</h1>
            <p>
                아래에서 답글 내용을 작성해주시고, 제출해주시면 답글을 보내드리겠습니다 :) 
            </p>
        </div>
    </div>

    <!-- Start Contact -->
    <div class="container py-5">
        <div class="row py-5">
            <form class="col-md-9 m-auto" enctype="multipart/form-data" method="post" role="form" action="chat/reply_write.php">
                <div class="mb-3">
                    <h1 class="h2"> 글 제목 : <?php echo $titile; ?>  </h1>
                    <h1 class="h2"> 작성자 : <?php echo $send_id; ?>  </h1>
                    <h1 class="h2">글 내용</h1>
                    <p><?php echo $content; ?></p>
                </div>

                <div class="mb-3">
                    <label for="inputmessage">답변 내용</label>
                    <input type="text" class="form-control mt-1" id="title" name="title" placeholder="title" required="required">
                    <textarea class="form-control mt-1" id="body" name="body" placeholder="Message" rows="8" required="required"></textarea>
                    <input type="submit" name="idx" class="btn btn-primary mr-3" value="<?php echo $idx?>">
                    <input type="submit" name="recv_name" class="btn btn-primary mr-3" value="<?php echo $send_id?>">
                    <input type="submit" name="goods" class="btn btn-primary mr-3" value="<?php echo $goods?>">
                    <script>
                        var check_idx = document.getElementsByName("idx")[0];
                        check_idx.setAttribute('type', 'hidden');

                        var check_recv = document.getElementsByName("recv_name")[0];
                        check_recv.setAttribute('type', 'hidden');

                        var check_goods = document.getElementsByName("goods")[0];
                        check_goods.setAttribute('type', 'hidden');
                    </script>
                </div>
                <div class="row">
                    <div class="col text-end mt-2">
                        <button type="submit" class="btn btn-success btn-lg px-3">업로드</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End Contact -->


    <!-- Header -->
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