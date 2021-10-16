<!DOCTYPE html>

<html lang="en">
<head>
    <title>전우장터 - Admin</title>
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

</head>

<?php
    include_once($_SERVER['DOCUMENT_ROOT']."/modules/common.php");

    @session_start();
    if(!isset($_SESSION['login_session'])){
        alertback("로그인이 필요한 서비스입니다.");
    }

    // error_reporting(E_ALL);
    // ini_set("display_errors", 1);

    $secure_id = $_SESSION['id'];
    $admin = $_SESSION['admin'];

    if(!isset($secure_id)){
        alertback("id 값을 가져올 수 없습니다..");
    }

    //id 보안처리
    $secure_id = prevent_sqli($secure_id);
    
    # id 가져오기
    $sql = "SELECT * FROM member where id='{$secure_id}'";
    $result = sql_select($sql);

    // 쿼리 조회 결과가 있는지 확인
    if($result) {
        // echo "조회 성공";
    } else {
        echo mysqli_error($db);
        alert("실패..");
    }

    // admin 확인
    if($_SESSION['admin'] != 1 and $row['admin'] != 1){
        alertback("권한이 부족합니다.");
    }
?>

<body>
    <!-- Header -->
	<?php include "header.php"; ?>

    <!-- Start Contact -->
    <div class="container py-3">
        <section class="bg-success py-3">
            <div class="container">
                <div class="row align-items-center py-3">
                    <div class="col-md-8 text-white">
                        <h1>For Admin</h1>
                        <p>
                            <?php echo $name; ?>님, 전우장터에 오신걸 환영합니다. <br><br>
                            <br><br>
                            해당 기능은 Admin을 위해 제공되는 기능입니다. 
                            <br> 현재로써는 유저 삭제 (제제시 사용 가능), 게시글 삭제 기능을 사용하실 수 있습니다.
                        </p>
                    </div>
                    <div class="col-md-4">
                        <img src="assets/img/about-hero.svg" alt="About Hero">
                    </div>
                </div>
            </div>
        </section>
    </div>

 <!-- Start Content Page -->
    <div class="container-fluid bg-light py-5">
        <div class="col-md-6 m-auto text-center">
            <h1 class="h1">Welcome Admin :D</h1>
            <p>
                기능 사용 도중, 문제가 있으시다면 개발자에게 문의해주세요! :)
            </p>
        </div>
    </div>

    <div class="row py-5">
            <form class="col-md-9 m-auto" enctype="multipart/form-data" method="post" role="form" action="mypage/add_admin.do.php">
                <div class="mb-3">
                    <h1 class="h2">ADMIN 추가 기능</h1>
                    <p>ADMIN 권한이 필요한 계정의 ID를 입력해주세요.</p>
                    <label for="inputsubject">ADD_ID</label>
                    <input type="text" class="form-control mt-1" id="add_id" name="add_id" placeholder="add_id" required="required">
                </div>
                <div class="row">
                    <div class="col text-end mt-2">
                        <button type="submit" class="btn btn-success btn-lg px-3"> 권한 추가 </button>
                    </div>
                </div>
            </form>

            <form class="col-md-9 m-auto" enctype="multipart/form-data" method="post" role="form" action="mypage/del_admin.do.php">
                <div class="mb-3">
                    <h1 class="h2">ID 삭제 기능</h1>
                    <p>삭제가 필요한 계정의 ID를 입력해주세요.</p>
                    <label for="inputsubject">Del_ID</label>
                    <input type="text" class="form-control mt-1" id="del_id" name="del_id" placeholder="del_id" required="required">
                </div>
                <div class="row">
                    <div class="col text-end mt-2">
                        <button type="submit" class="btn btn-success btn-lg px-3"> 삭제 </button>
                    </div>
                </div>
            </form>

            <form class="col-md-9 m-auto" enctype="multipart/form-data" method="post" role="form" action="product/rm_admin.do.php">
                <div class="mb-3">
                    <h1 class="h2">상품 삭제 기능</h1>
                    <p>삭제가 필요한 상품의 aid를 입력해주세요.</p>
                    <label for="inputsubject">Del_aid</label>
                    <input type="text" class="form-control mt-1" id="del_aid" name="del_aid" placeholder="del_aid" required="required">
                </div>
                <div class="row">
                    <div class="col text-end mt-2">
                        <button type="submit" class="btn btn-success btn-lg px-3"> 삭제 </button>
                    </div>
                </div>
            </form>
    </div>

    <!-- Footer -->
	<?php include "footer.php"; ?>

<script src="assets/js/jquery-1.11.0.min.js"></script>
<script src="assets/js/jquery-migrate-1.2.1.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/templatemo.js"></script>
<script src="assets/js/custom.js"></script>
<script type="text/javascript">

</script>
</body>

</html>