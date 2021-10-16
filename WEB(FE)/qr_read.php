<!DOCTYPE html>
<html lang="en">

<head>
    <title>전우장터 - QR 조회 </title>
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
    // 상품 DB에서 aid 기준이나, 시리얼 번호 기준으로 정보 가져와서 출력
     // report DB에서 aid 기준이나, 시리얼 번호 기준으로 정보 가져와서 출력
     include_once("/app/modules/common.php");
    
     // error_reporting(E_ALL);
     // ini_set("display_errors", 1);
 
     // 필요한 값 가져오기
     $aid = $_GET['aid'];
 
     // 세션 내 유저 값 필요시 참고 
     $secure_id = $_SESSION['id'];
 
     if(!isset($aid)){
         alertback("조회에 실패하였습니다.");
     }
     
     $aid = prevent_sqli($aid);

     # 게시글 값 가져오기
     $sql = "SELECT * FROM product where articleid='{$aid}'";
     $result = sql_select($sql);

     # articleid	title	body	price	category	place_sell	saleway	imagepath	uploadtime	id	belong	city	office	phone	status	

 
     // 쿼리 조회 결과가 있는지 확인
     if($result) {
         // echo "조회 성공";
     } else {
         echo mysqli_error($db);
         alertback("QR 조회에 실패하였습니다.");
     }

    // 권한 확인 (구매자 혹은 판매자)
    $buyer = $result['buyer'];
    $id = $result['id'];

    if($buyer != $secure_id and $id != $secure_id){
        alertback("QR을 조회하기 위한 권한이 존재하지 않습니다.");
    }
     
    ###########################################################################################
 
    # 결과값 가져오기 
    $titile = $result['title'];
    $body = $result['body'];
    $price = $result['price'];
    $place_sell = $result['place_sell'];
    $saleway = $result['saleway'];

    $uploadtime = $result['uploadtime'];

    $status = $result['status'];
    $belong = $result['belong'];
    $city = $result['city'];
    $office = $result['office'];
    $phone = $result['phone'];

    $qrpath = $result['qrpath'];

    ###########################################################################################
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

    // 거래 방식
    // $saleway = $result['saleway'];
    if($saleway == 1){
        $saleway_str = "부대 내 직거래";
    } elseif($saleway == 2){
        $saleway_str = "부대 내 보관함";
    } elseif($saleway == 3){
        $saleway_str = "부대 내 직거래, 보관함";
    } elseif($saleway == 4){
        $saleway_str = "부대 외";
    } elseif($saleway == 5){
        $saleway_str = "부대 내 직거래, 부대 외";
    } else {
        $saleway_str = "부대 내 직거래, 보관함, 부대 외";
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
            <h1 class="h1">Congratulation!</h1>
            <p>
                <?php echo $buyer; ?> 님, 구매를 축하드립니다~ <br> 해당 QR을 통해, 구매하신 물건을 수령할 수 있으십니다 :)
            </p>
        </div>
    </div>

    <!-- Open Content -->
    <section class="bg-light">
        <div class="container pb-5">
            <div class="row">
                <div class="col-lg-5 mt-5">
                    <div class="card mb-3">
                        <img class="card-img img-fluid" src="qr/<?php echo $qrpath; ?>" alt="Card image cap" id="product-detail">
                    </div>
                </div>
                <!-- col end -->
                <div class="col-lg-7 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="h2"><?php echo $titile; ?></h1>
                            <h1 class="h3"><?php echo $body; ?></h1>
                            <p class="h4 py-2">업로드 시간 : <?php echo date("Y-m-d H:i:s", $uploadtime);?> </p>
                            <p class="h4 py-2">판매자 : <?php echo $id; ?> </p>
                            <p class="h4 py-2">연락처 : <?php echo $phone; ?> </p>
                            <p class="h4 py-2">가격 : <?php echo $price; ?> </p>
                            <p class="h4 py-2">판매자 부대 : <?php echo $belong_str; ?> </p>
                            <p class="h4 py-2">판매자 도시 : <?php echo $city_str; ?> </p>
                            <p class="h4 py-2">거래 지역 : <?php echo $place_sell;?> </p>
                            <p class="h4 py-2">거래 방식 :<?php echo $saleway_str; ?> </p>

                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <h6>카테고리</h6>
                                </li>
                                <li class="list-inline-item">
                                    <p class="text-muted"><strong> <?php echo $category_str; ?> </strong></p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Close Content -->

    
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

    <!-- Start Slider Script -->
    <script src="assets/js/slick.min.js"></script>
    <script>
        $('#carousel-related-product').slick({
            infinite: true,
            arrows: false,
            slidesToShow: 4,
            slidesToScroll: 3,
            dots: true,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 3
                    }
                }
            ]
        });
    </script>
    <!-- End Slider Script -->

</body>

</html>