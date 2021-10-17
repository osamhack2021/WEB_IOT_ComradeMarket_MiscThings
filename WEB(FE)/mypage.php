<!DOCTYPE html>

<html lang="en">
<head>
    <title>전우장터 - 마이페이지</title>
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

    $secure_id = prevent_sqli($secure_id);
    
    # 게시글 값 가져오기
    $sql = "SELECT * FROM member where id='{$secure_id}'";
    $result = sql_select($sql);

    // 쿼리 조회 결과가 있는지 확인
    if($result) {
        // echo "조회 성공";
    } else {
        echo mysqli_error($db);
        alert("실패..");
    }
    
    ###########################################################################################

    # 결과값 가져오기 
    $name = $result['name'];
    $id = $result['id'];
    $serialnumber = $result['serialnumber'];
    $email = $result['email'];
    $phone = $result['phone'];
    $belong = $result['belong'];
    $city = $result['city'];
    $office = $result['office'];
    $officePhone = $result['officePhone'];

    # belong -> 문자열 변경
    $area_1 = array("국방부","육군","해군","공군");
    $area_2 = array();
    $area_2["국방부"]		= array("육군본부","해군본부","공군본부","국군화생방방호사령부","국군지휘통신사령부","국군수송사령부","국군심리전단","사이버작전사령부", "군사안보지원사령부","국방정보본부","국방시설본부");
    $area_2["육군"]		= array("제1군단","제2군단","제3군단","제5군단","제6군단","7기동군단","8군단","수기사","1사단","2공정사단","3사단","5사단","6사단","7사단","8사단");
    $area_2["해군"]		= array("진해기지사령부/진해특정경비지역사령부","전력분석시험평가단","정보체계관리단","사이버작전센터","해군작전사령부","제1함대","제2함대","제3함대");
    $area_2["공군"]		= array("제3훈련비행단","제5공중기동비행단","제15특수임무비행단","제39정찰비행단","제6탐색구조비행전대","제1전투비행단","제8전투비행단","제10전투비행단","제11전투비행단","제16전투비행단");

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

    # city -> 문자열 변경
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
                        <h1>전우장터</h1>
                        <p>
                            <?php echo $name; ?>님, 전우장터에 오신걸 환영합니다. <br><br>
                            <br><br>
                            전우장터는 생활을 하는 장병 및 군무원, 간부를 대상으로 중고거래 플랫폼을 제공하고 판매 물건을 보관할 수 있는 보관함을 제공하는 웹 & IOT 프로젝트이며, 거래하시는 분들이 마음 놓고 거래할 수 있는 안전한 플랫폼을 제작하기 위해 더욱 노력하겠습니다. 
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
            <h1 class="h1">나에 대한 정보를 확인해볼까요?</h1>
            <p>
                잘못된 정보가 있다면, 신고 게시판을 통해 관리자에게 알리거나,
                변경 기능을 활용해주세요! :)
            </p>
        </div>
    </div>

    <div class="row py-5">
        <?php
            if($admin == 1){

                echo '
                <form class="col-md-9 m-auto" method="POST" role="form">
                    <div class="row pb-3">
                        <div class="col d-grid">
                            <button type="button" class="btn btn-success btn-lg" onclick = "location.href = ' . "'mypage-admin.php'" .'; "> Admin </button>
                        </div>
                    </div>
                </form>
                ';
            }
        ?>
            <form class="col-md-9 m-auto" method="POST" role="form">
                <div class="row pb-3">
                    <div class="col d-grid">
                        <button type="button" class="btn btn-success btn-lg" onclick = "location.href = 'mypage-buy.php'; "> 내가 구매한 물건 </button>
                    </div>
                    <div class="col d-grid">
                        <button type="button" class="btn btn-success btn-lg" onclick = "location.href = 'mypage-sell.php'; "> 내가 판매한 물건 </button>
                    </div>
                    <div class="col d-grid">
                        <button type="button" class="btn btn-success btn-lg" onclick = "location.href = 'letter-recv.php'; "> 쪽지함 </button>
                    </div>
                </div>
            </form>
            <form class="col-md-9 m-auto" method="POST" role="form">
                <div class="row pb-3">
                    <div class="col d-grid">
                        <button type="button" class="btn btn-success btn-lg" onclick = "location.href = 'chang_pw.html'; "> 비밀번호 변경 </button>
                    </div>
                    <div class="col d-grid">
                        <button type="button" class="btn btn-success btn-lg" onclick = "location.href = 'chang_email.html'; "> 이메일 변경 </button>
                    </div>
                    <div class="col d-grid">
                        <button type="button" class="btn btn-success btn-lg" onclick = "location.href = 'mypage/del_user.do.php'; "> 계정 탈퇴 </button>
                    </div>
                </div>
            </form>
    </div>

    <!-- Start Contact -->
    <div class="container py-5">
        <div class="row py-5">
            <div class="row">
                <div class="form-group col-md-6 mb-3">
                    <label for="inputname">이름</label>
                    <p> <?php echo $name; ?></p>
                </div>
                <div class="form-group col-md-6 mb-3">
                    <label for="inputemail">이메일</label>
                    <p> <?php echo $email; ?></p>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6 mb-3">
                    <label for="inputname">군번</label>
                    <p> <?php echo $serialnumber; ?></p>
                </div>
                <div class="form-group col-md-6 mb-3">
                    <label for="inputemail">아이디</label>
                    <p> <?php echo $id; ?></p>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6 mb-3">
                    <label for="inputname">휴대전화번호</label>
                    <p> <?php echo $phone; ?></p>
                </div>
                <div class="form-group col-md-6 mb-3">
                    <label for="inputemail">군 부대 소속</label>
                    <p> <?php echo $belong_str; ?></p>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6 mb-3">
                    <label for="inputname">부대가 속한 도시 & 군</label>
                    <p> <?php echo $city_str; ?></p>
                </div>
                <div class="form-group col-md-6 mb-3">
                    <label for="inputemail">상세 소속 및 사무실 연락처</label>
                    <p> <?php echo $office; ?></p>
                    <p> <?php echo $officePhone; ?></p>
                </div>
            </div>

        </div>
    </div>
    <!-- End Contact -->

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