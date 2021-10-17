<!DOCTYPE html>
<html lang="en">

<head>
    <title>전우장터</title>
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

<!-- 상품 정보를 불러오자.. --> 

<?php
    include_once("/app/modules/common.php");
    // error_reporting(E_ALL);
    // ini_set("display_errors", 1);

    if (isset($_GET["no"])) {
        $no = $_GET["no"];
    }

    $pageSize = 9;
    $pageListSize = 10;
    $check_count = 0;

    if (!$no || $no < 0) $no = 1;

    @session_start();


    if(!isset($_SESSION['login_session'])){
        $sqlCount = "SELECT count(*) FROM product";

        $resultCount = sql_select($sqlCount);
        $totalCount = $resultCount["count(*)"];
    }else{
        // 멤버 -> belong 확인
        $secure_id = $_SESSION['id'];
    
        if(!isset($secure_id)){
            alertback("id 값을 가져올 수 없습니다..");
        }
        
        # 게시글 값 가져오기
        $sql = "SELECT belong FROM member where id='{$secure_id}'";
        $result = sql_select($sql);
        $belong = $result['belong'];
        
        $sqlCount = "SELECT count(*) FROM product where belong='" . $belong . "'";

        $resultCount = sql_select($sqlCount);
        $totalCount = $resultCount["count(*)"];

        if($totalCount == 0){
            $sqlCount = "SELECT count(*) FROM product";

            $resultCount = sql_select($sqlCount);
            $totalCount = $resultCount["count(*)"];
            $check_count = 1;
        }
    }

    // $sqlCount = "SELECT count(*) FROM product";
    // $resultCount = sql_select($sqlCount);
    // $totalCount = $resultCount["count(*)"];

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

    // $sql = "SELECT articleid, title, body, price, category, place_sell, saleway, imagepath, uploadtime, id, belong, city, status FROM product ORDER BY uploadtime desc limit ".$beginIdx.",".$pageSize."";
    // $result = sql_insert($sql);

    if(!isset($_SESSION['login_session'])){
        $sql = "SELECT articleid, title, body, price, category, place_sell, saleway, imagepath, uploadtime, id, belong, city, status FROM product ORDER BY uploadtime desc limit ".$beginIdx.",".$pageSize."";
    }else{
        if($check_count == 1){
            $sql = "SELECT articleid, title, body, price, category, place_sell, saleway, imagepath, uploadtime, id, belong, city, status FROM product ORDER BY uploadtime desc limit ".$beginIdx.",".$pageSize."";
        }else{
            $sql = "SELECT articleid, title, body, price, category, place_sell, saleway, imagepath, uploadtime, id, belong, city, status FROM product where belong='" . $belong ."' ORDER BY uploadtime desc limit ".$beginIdx.",".$pageSize."";
            // $sql = "SELECT * FROM note where send_id='" . $secure_id ."' ORDER BY send_date desc limit ".$beginIdx.",".$pageSize."";
        }
    }
    $result = sql_insert($sql);

    // 쿼리 조회 결과가 있는지 확인
    if($result) {
        // echo($result);
    } else {
        // echo mysqli_error($db);
        alert("실패..");
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

    <div class="d-flex justify-content-center col-xl-12">
        <form class="d-md-inline-block form-inline navbar-search col-xl-7" action="shop-search.php" method="GET">
            <br>
            <div class="input-group my-3">
                <input class="form-control input-lg bg-white border-1" name="search" id="search" placeholder="어떤 물건을 찾고 계신가요?" aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                    <br>
                </div>
            </div>
        </form>
    </div>

    <!-- Start Page -->
    <div class="container-fluid bg-light py-5">
    <div class="col-md-6 m-auto text-center">
            <h1 class="h1">Right now!</h1>
            <p>
                지금 바로 소속 부대의 중고 물건들을 확인해보세요 :) <br>
                "로그인시에만 해당 기능이 적용되며, 소속 부대의 물건이 없을 경우, 전체 물건을 출력합니다."
            </p>
        </div>
    </div>

     <!-- Start Content -->
     <div class="container py-5">
        <div class="row">
            <div class="col-lg-15">
                <div class="row">
                <!-- 상품 9개씩 끊어서 출력-->
                <?php
                    $idx = 0;
                    // 카테고리, 지역, 부대 처리

                    # 부대 처리 
                    $area_1 = array("국방부","육군","해군","공군");
                    $area_2 = array();
                    $area_2["국방부"]		= array("육군본부","해군본부","공군본부","국군화생방방호사령부","국군지휘통신사령부","국군수송사령부","국군심리전단","사이버작전사령부", "군사안보지원사령부","국방정보본부","국방시설본부");
                    $area_2["육군"]		= array("제1군단","제2군단","제3군단","제5군단","제6군단","7기동군단","8군단","수기사","1사단","2공정사단","3사단","5사단","6사단","7사단","8사단");
                    $area_2["해군"]		= array("진해기지사령부/진해특정경비지역사령부","전력분석시험평가단","정보체계관리단","사이버작전센터","해군작전사령부","제1함대","제2함대","제3함대");
                    $area_2["공군"]		= array("제3훈련비행단","제5공중기동비행단","제15특수임무비행단","제39정찰비행단","제6탐색구조비행전대","제1전투비행단","제8전투비행단","제10전투비행단","제11전투비행단","제16전투비행단");

                    # 지역 처리 
                    $area_3 = array("서울특별시","부산광역시","대구광역시","인천광역시","광주광역시","대전광역시","울산광역시","세종특별자치시","경기도","강원도","충청도","전라도","경상도","제주특별자치도");
                    $area_4 = array();

                    $area_4["서울특별시"]		= array("서울특별시");
                    $area_4["부산광역시"]		= array("부산광역시");
                    $area_4["대구광역시"]		= array("대구광역시");
                    $area_4["인천광역시"]		= array("인천광역시");
                    $area_4["광주광역시"]		= array("광주광역시");
                    $area_4["대전광역시"]		= array("대전광역시");
                    $area_4["울산광역시"]		= array("울산광역시");
                    $area_4["세종특별자치시"]	= array("세종");
                    $area_4["경기도"]		= array("수원","안양","안산","용인","부천","광명","평택","과천","오산","시흥","군포","의왕","하남","이천","안성","김포","화성","광주","여주","양평","고양","의정부","동두천","구리","남양주","파주","양주","포천","연천","가평");
                    $area_4["강원도"]		= array("춘천","원주","강릉","동해","태백","속초","삼척","홍천","횡성","영월","평창","정선","철원","화천","양구","인제","고성","양양");
                    $area_4["충청도"]		= array("청주","충주","제천","보은","옥천","영동","증평","진천","괴산","음성","단양","천안","공주","보령","아산","서산","논산","계룡","당진","금산","부여","서천","청양","홍성","예산","태안");
                    $area_4["전라도"]		= array("전주","군산","익산","정읍","남원","김제","완주","진안","무주","장수","임실","순창","고창","부안","목포","여수","순천","나주","광양","담양","곡성","구례","고흥","보성","화순","장흥","강진","해남","영암","무안","함평","영광","장성","완도","진도","신안");
                    $area_4["경상도"]		= array("포항","경주","김천","안동","구미","영주","영천","상주","문경","경산","군위","의성","청송","영양","영덕","청도","고령","성주","칠곡","예천","봉화","울진","울릉","창원","진주","통영","사천","김해","밀양","거제","양산","의령","함안","창녕","고성","남해","하동","산청","함양","거창","합천");
                    $area_4["제주특별자치도"]	= array("제주","서귀포");

                    while ($row = mysqli_fetch_array($result)) {
                        $belong = $row['belong'];
                        $city = $row['city'];
                        $category = $row['category'];

                        # 값에 따른 문자열 변경
                        if($belong >= 100 and $belong < 200){
                            $belong = $belong - 100;
                            $belong_str = $area_2["국방부"][$belong];

                        } elseif($belong >= 200 and $belong < 300){
                            $belong = $belong - 200;
                            $belong_str = $area_2["육군"][$belong];

                        } elseif($belong >= 300 and $belong < 400){
                            $belong = $belong - 300;
                            $belong_str = $area_2["해군"][$belong]; 

                        } elseif($belong >= 400 and $belong < 500){
                            $belong = $belong - 400;
                            $belong_str = $area_2["공군"][$belong]; 
                        } else{
                            $belong_str = "ERROR!";
                        }

                        if($city < 10){
                            if($city == 0){
                                $city_str = "서울특별시";
                            } elseif($city == 1){
                                $city_str = "부산광역시";
                            } elseif($city == 2){
                                $city_str = "대구광역시";
                            } elseif($city == 3){
                                $city_str = "인천광역시";
                            } elseif($city == 4){
                                $city_str = "광주광역시";
                            } elseif($city == 5){
                                $city_str = "대전광역시";
                            } elseif($city == 6){
                                $city_str = "울산광역시";
                            } else{
                                $city_str = "세종특별자치시";
                            }
                        } elseif($city >= 100 and $city < 200){
                            $city = $city - 100;
                            $city_str = "경기도 ". $area_4["경기도"][$city];
                        } elseif($city >= 200 and $city < 300){
                            $city = $city - 200;
                            $city_str = "강원도 ". $area_4["강원도"][$city];
                        } elseif($city >= 300 and $city < 400){
                            $city = $city - 300;
                            $city_str = "충청도 ". $area_4["충청도"][$city];
                        } elseif($city >= 400 and $city < 500){
                            $city = $city - 400;
                            $city_str = "전라도 ". $area_4["전라도"][$city];
                        } elseif($city >= 500 and $city < 600){
                            $city = $city - 500;
                            $city_str = "경상도 ". $area_4["경상도"][$city];
                        } else{
                            $city_str = "제주특별자치도";
                        }

                        if($category == 0){
                            $category_str = "의류";
                        } elseif($category == 1){
                            $category_str = "신발";
                        } elseif($category == 2){
                            $category_str = "가방";
                        } elseif($category == 3){
                            $category_str = "시계 & 쥬얼리";
                        } elseif($category == 4){
                            $category_str = "패션 액세서리";
                        } elseif($category == 5){
                            $category_str = "디지털/가전";
                        } elseif($category == 6){
                            $category_str = "스포츠/레저";
                        } elseif($category == 7){
                            $category_str = "스타굿즈";
                        } elseif($category == 8){
                            $category_str = "키덜트";
                        } elseif($category == 9){
                            $category_str = "음반/악기";
                        } elseif($category == 10){
                            $category_str = "도서/문구";
                        } elseif($category == 11){
                            $category_str = "뷰티/미용";
                        } elseif($category == 12){
                            $category_str = "가구/인테리어";
                        } elseif($category == 13){
                            $category_str = "생활/가공식품";
                        } elseif($category == 14){
                            $category_str = "울산광역시";
                        } else{
                            $category_str = "기타 (ETC)";
                        }
                        
                        // 이미지 경로 
                        $imagepath = $row["imagepath"];
                        $image_file = array();

                        if(is_dir($imagepath)) {
                            if($dh = opendir($imagepath)) {
                                while(($file = readdir($dh)) !== false) {
                                    if ($file == "." || $file == "..") {
                                        continue;
                                    }
                                    $_file = $imagepath.$file;
                                    if(is_file($_file)) {
                                        // echo "filename: ".$_file."<br>";
                                        $file_input  = $_file;
                                        $test = substr($file_input, 0, 4);
                                        if($test == "/app"){
                                            $file_input = substr($file_input, 5);
                                        }
                                        array_push($image_file, $file_input);
                                    }
                                }
                                closedir($dh);
                            }
                        }

                        // var_dump($imagepath);
                        // var_dump($image_file);

                        $status = $row['status'];

                        if($status == 1){
                            $status_str = "거래 완료";
                            $button_str = '';

                        }else{
                            $status_str = "거래 중 ";
                            $button_str = '<ul class="list-unstyled">
                            <li><a class="btn btn-success text-white mt-2" href="shop-contents.php?aid=' . $row["articleid"] .'"><i class="far fa-eye"></i></a></li>
                            </ul>';
                        }
                        

                    
                        echo '<div class="col-md-4">
                            <div class="card mb-4 product-wap rounded-0">
                                <div class="card rounded-0">
                                    <img class="card-img rounded-0 img-fluid" src="'.$image_file[0] .'">
                                    <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">'
                                    .
                                    $button_str
                                    . 
                                    '</div>
                                </div>
                                <div class="card-body">
                                    <a href="shop-contents.php?aid=' . $row["articleid"] .'" class="h3 text-decoration-none">' . $row["title"].'</a>
                                    <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                                        <li> 닉네임 : ' . $row["id"] . '</li>
                                        <li class="pt-2">
                                            <span class="product-color-dot color-dot-red float-left rounded-circle ml-1"></span>
                                            <span class="product-color-dot color-dot-blue float-left rounded-circle ml-1"></span>
                                            <span class="product-color-dot color-dot-black float-left rounded-circle ml-1"></span>
                                            <span class="product-color-dot color-dot-light float-left rounded-circle ml-1"></span>
                                            <span class="product-color-dot color-dot-green float-left rounded-circle ml-1"></span>
                                        </li> 
                                    </ul>
                                    <p class="w-100 list-unstyled d-flex justify-content-between mb-0">카테고리 :  ' . $category_str . '</p>
                                    <p class="w-100 list-unstyled d-flex justify-content-between mb-0">지역 : ' . $city_str . ' </p>
                                    <p class="w-100 list-unstyled d-flex justify-content-between mb-0">부대 : ' . $belong_str . ' </p>
                                    <p class="w-100 list-unstyled d-flex justify-content-between mb-0">판매 여부 : ' . $status_str . ' </p>
                                    <p class="text-center mb-0"> ' . $row["price"] . '원</p>
                                </div>
                            </div>
                        </div>';
                    }
                ?>
                </div>
                
                <div div="row">
                    <ul class="pagination pagination-lg justify-content-end">
                <!--
                        <li class="page-item disabled">
                            <a class="page-link active rounded-0 mr-3 shadow-sm border-top-0 border-left-0" href="#" tabindex="-1">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link rounded-0 mr-3 shadow-sm border-top-0 border-left-0 text-dark" href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link rounded-0 shadow-sm border-top-0 border-left-0 text-dark" href="#">3</a>
                        </li>
                -->
                        
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
    </div>
    <!-- End Content -->

    <!-- Footer -->
	<?php include "footer.php"; ?>


    <!-- Start Script -->
    <script src="assets/js/jquery-1.11.0.min.js"></script>
    <script src="assets/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/templatemo.js"></script>
    <script src="assets/js/custom.js"></script>

    <script type="text/javascript">
    </script>

    <!-- End Script -->
</body>

</html>