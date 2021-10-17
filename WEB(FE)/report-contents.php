<!DOCTYPE html>
<html lang="en">

<head>
    <title>전우장터 - 문의 글 조회</title>
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
    // $name = $_SESSION['name'];

    if(!isset($aid)){
        alert("조회에 실패하였습니다.");
        redirect('./report.php');
    }
    
    $aid = prevent_sqli($aid);
    # 게시글 값 가져오기
    $sql = "SELECT * FROM report where idx='{$aid}'";
    $result = sql_select($sql);

    // 쿼리 조회 결과가 있는지 확인
    if($result) {
        // echo "조회 성공";
    } else {
        echo mysqli_error($db);
        alert("실패..");
    }

    if($result['status'] === 0){
        if($result['id'] == $secure_id){
            alertback("조회가 가능한 사용자가 아닙니다.");
        }
    }
    
    ###########################################################################################

    # 결과값 가져오기 
    $titile = $result['title'];
    $id = $result['id'];
    $body = $result['body'];
    $body_reply = $result['body_reply'];
    $imagepath = $result['imagepath'];
    $date = $result['date'];
    $status = $result['status'];
    $hit = $result['hit'];
    $reply = $result['reply'];

    $hit_save = $hit + 1;

    # hit 추가 -> 조회수
    $safe_var=array(prevent_sqli($hit_save), prevent_sqli($aid));

    //모두 확인하여 이상이 없으므로 DB에 데이터 넣기
    $query = "update report set hit='{$safe_var[0]}' where idx='{$safe_var[1]}'";
    $result = sql_insert($query);
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



    <!-- Open Content -->
    <section class="bg-light">
        <div class="container pb-5">
            <div class="row">
                <div class="col-lg-5 mt-5">
                    <div class="card mb-3">
                        <img class="card-img img-fluid" src="<?php echo $imagepath; ?>" alt="Card image cap" id="product-detail">
                    </div>
                </div>
                <!-- col end -->
                <div class="col-lg-7 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="h2"> <?php echo $titile; ?>  </h1>
                            <h1 class="h5"> 작성자 : <?php echo $id; ?>  </h1>
                            <h1 class="h5"> 작성시간 : <?php echo date("Y-m-d H:i:s", $date);?> </h1>
                            <h1 class="h5"> 조회수 : <?php echo $hit; ?>  </h1>

                            <h4>본문</h4>
                            <p><?php echo $body; ?></p>
           
                            <h4>답변 내용</h4>
                            
                            <p>
                            <?php
                                if($reply == 0){
                                    echo "답변을 대기하고 있는 게시글입니다.";
                                }else{
                                    echo $body_reply; 
                                }
                            ?>
                            </p>

                            <form action="" method="GET">
                                <div class="row pb-3">
                                    <div class="col d-grid">
                                        <button type="button" class="btn btn-success btn-lg" onclick = "location.href = 'report-reply.php?idx=<?php echo $aid; ?>'; ">답변 작성</button>
                                    </div>
                                    <div class="col d-grid">
                                        <button type="button" class="btn btn-success btn-lg" onclick = "location.href = 'report/rm_report.do.php?idx=<?php echo $aid; ?>'; ">글 삭제</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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