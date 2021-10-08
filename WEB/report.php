<!DOCTYPE html>
<html lang="en">

<head>
    <title>전우장터 - 신고 게시판</title>
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
            <h1 class="h1">Contact Us</h1>
            <p>
                중고거래 도중 불편하셨던 점이나, 개선이 필요한 점 혹은 플랫폼을 사용하시면서, 
                사기 혹은 악의적인 사용자로 인해 피해를 입으셨다면, 사기 게시판을 통해 
                이를 저희에게 알려주세요! :) 
            </p>
        </div>
    </div>

    <!-- Start Contact -->

    <!-- Begin Page Content -->
    <div class="container-fluid bg-light py-5">
        <?php
            if (isset($_GET["no"])) {
                $no = $_GET["no"];
            }
            
            $pageSize = 15;
            $pageListSize = 10;
            
            if (!$no || $no < 0) $no = 1;

            $sqlCount = "SELECT count(*) FROM report";

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

            $sql = "SELECT idx, title, date, id, status, hit FROM report ORDER BY date desc limit ".$beginIdx.",".$pageSize."";
            $result = sql_insert($sql);

        ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>번호</th>
                    <th>제목</th>
                    <th>작성일</th>
                    <th>작성자</th>
                    <th>처리 상태</th>
                    <th>글 상태</th>
                    <th>조회수</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $idx = 0;
                    while ($row = mysqli_fetch_array($result)) {
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
                            echo "<a href='report-contents.php?idx=".$row["idx"]."'>";
                            echo $row["title"];
                            echo "</a>";
                        ?>
                    </td>
                    <td>
                        <?php
                            $timestamp = $row["date"];
                            echo date("Y-m-d H:i:s", $timestamp);
                        ?>
                    </td>
                    <td>
                        <?php
                            echo $row["id"];
                        ?>
                    </td>
                    <td>
                        <?php
                            if ($row["reply"] == 0) {
                                echo "답변 대기";                                         
                            }else{
                                echo "답변 완료";
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            if ($row["status"] == 0) {
                                echo "비밀 글";                                         
                            }else{
                                echo "공개 글";
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            echo $row["hit"];
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
            <a href="report-new.php" class="btn btn-default btn-primary float-right">
                <i class="fas fa-pen mr-1"></i>
                <span>글쓰기</span>
            </a>
        </div>
        
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