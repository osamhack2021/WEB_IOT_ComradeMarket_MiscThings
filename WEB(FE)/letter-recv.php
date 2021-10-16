<!DOCTYPE html>
<html lang="en">

<head>
    <title>전우장터 - 쪽지함 (받은 쪽지) </title>
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
            <h1 class="h1">받은 쪽지함</h1>
            <p>
                다양한 분들과, 쪽지를 주고 받으면서 즐거운 거래가 되시길 기원합니다 :) 
            </p>
        </div>
    </div>

    <!-- Start Contact -->
    <div class="container-fluid bg-light py-5">
            <a href="letter-recv.php" class="btn btn-default btn-primary float-right">
                <i class="fas fa-pen mr-1"></i>
                <span>받은 쪽지</span>
            </a>
            <a href="letter-send.php" class="btn btn-default btn-primary float-right">
                <i class="fas fa-pen mr-1"></i>
                <span>보낸 쪽지</span>
            </a>
            <!-- 
            <a href="#" class="btn btn-default btn-primary float-right">
                <i class="fas fa-pen mr-1"></i>
                <span>검색 (준비 중)</span>
            </a>
            -->
    </div>

    <!-- Begin Page Content -->
    <div class="container-fluid bg-light py-5">
        <?php
            @session_start();
            if(!isset($_SESSION['login_session'])){
                alertback("로그인이 필요한 서비스입니다.");
            }

            if (isset($_GET["no"])) {
                $no = $_GET["no"];
            }
            
            $pageSize = 15;
            $pageListSize = 10;
            
            if (!$no || $no < 0) $no = 1;

            $secure_id = $_SESSION['id'];
            $secure_id = prevent_sqli($secure_id);

            // $sqlCount = "SELECT count(*) FROM note";
            $sqlCount = "SELECT count(*) FROM note where recv_id='" . $secure_id . "'";

            $resultCount = sql_select($sqlCount);
            $totalCount = $resultCount["count(*)"];

            $totalPage = floor(($totalCount - 1) / $pageSize) + 1;
            $currentPage = $no;
            if ($currentPage % 10 == 0) $currentPage = $currentPage - 1;
                            
            
            if ($no > 10) {
                $startPage = (int)($currentPage / $pageListSize) * $pageListSize + 1;
            }
            else {
                $startPage = 1;
            }

            $endPage = $startPage + $pageListSize - 1;
            $beginIdx = $pageSize * ($no - 1);
            
            $beginIdx = prevent_sqli($beginIdx);
            $pageSize = prevent_sqli($pageSize);

            // $sql = "SELECT * FROM note ORDER BY send_date desc limit ".$beginIdx.",".$pageSize."";
            $sql = "SELECT * FROM note where recv_id='" . $secure_id ."' ORDER BY send_date desc limit ".$beginIdx.",".$pageSize."";
            $result = sql_insert($sql);
        ?>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>번호</th>
                    <th>보낸 사람</th>
                    <th>제목</th>
                    <th>수신 확인</th>
                    <th>작성일</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $idx = 0;
                    while ($row = mysqli_fetch_array($result)) {
                        if($row["r_del"] == 1 or $row["s_del"] == 1){
                            continue;
                        }
                ?>
                <tr>
                    <td>
                        <?php
                            $colNum = $idx + (($no-1) * $pageSize) + 1;
                            echo $colNum;
                            $idx = $idx + 1;
                        ?>
                    </td>
                    <td>
                        <?php
                            echo $row["send_id"];
                        ?>               
                    </td>
                    <td>
                        <?php
                            echo "<a href='letter-contents.php?idx=".$row["idx"]."'>";
                            echo $row["title"];
                            echo "</a>";
                        ?>
                    </td>
                    <td>
                        <?php
                            if ($row["recv_chk"] == 0) {
                                echo "X";                                         
                            }else{
                                echo "O";
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            // $timestamp = $row["send_date"];
                            // echo date("Y-m-d H:i:s", $timestamp);
                            echo $row["send_date"];
                        ?>
                    </td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
        <hr>
        
        <div class="container-fluid bg-light py-5">
            <div class="row">
                    <ul class="pagination pagination-lg justify-content-end">
                        <?php
                            if($totalPage < $endPage) $endPage = $totalPage;
                            if($startPage >= $pageListSize) {
                                $prevList = $startPage - 1;
                                # class="page-link active rounded-0 mr-3 shadow-sm border-top-0 border-left-0"
                                echo "<li class=\"page-item\"><a class=\"page-link active rounded-0 mr-3 shadow-sm border-top-0 border-left-0\" href=\"$PHP_SELF?no=$prevList\" aria-label=\"Previous\"><span aria-hidden=\"true\">&laquo;</span></a></li>";
                            }
                            for ($i = $startPage; $i <= $endPage; $i++) {
                                $page = $pageSize * $i;
                                $pageNum = $i;
                                
                                if ($no == $pageNum) {
                                    echo "<li class=\"page-item active\"><a class=\"page-link active rounded-0 mr-3 shadow-sm border-top-0 border-left-0\" href=\"$PHP_SELF?no=$pageNum\">";
                                }
                                else if ($no != $pageNum) {
                                    echo "<li class=\"page-item\"><a class=\"page-link active rounded-0 mr-3 shadow-sm border-top-0 border-left-0\" href=\"$PHP_SELF?no=$pageNum\">";
                                }
                                echo $pageNum;
                                echo "</a></li>";
                            }
                            if ($totalPage > $endPage) {
                                $nextList = $endPage + 1;
                                echo "<li class=\"page-item\"><a class=\"page-link active rounded-0 mr-3 shadow-sm border-top-0 border-left-0\" href=\"$PHP_SELF?no=$nextList\" aria-label=\"Next\"><span aria-hidden=\"true\">&raquo;</span></a></li>";
                            }
                        ?>
                    </ul>
            </div>
        </div>           
    </div>
    <!-- End Contact -->

    <!-- Start Footer -->
    <?php include "footer.php"; ?>
    <!-- End Footer -->

    <!-- Start Script -->
    <script src="assets/js/jquery-1.11.0.min.js"></script>
    <script src="assets/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/templatemo.js"></script>
    <script src="assets/js/custom.js"></script>
    <!-- End Script -->
</body>

</html>