<?php

    header("Content-Type:text/html;charset=utf-8");

    //모듈 로드
    include_once("/app/modules/common.php");

    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    // METHOD 확인
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        echo("잘못된 요청 입니다.");
        return;
    }

    @session_start();
    if (!isset($_SESSION['login_session'])) {
        echo("로그인이 필요한 서비스입니다.");
        return;
    }

    # 요청 시간
    $uploadtime = time();
    $uploadtime = $uploadtime + 32400;
    # 작성자 이름 
    $userid =  $_SESSION['id'];

    # POST
    $place_sell = $_POST['place'];
    $price = intval($_POST['price']);
    $category = intval($_POST['category']);
    $title = $_POST['title'];
    $body = $_POST['body'];
    $saleway = intval($_POST['saleway']);

    // 필요한 값 체크 및 검증
    if (!isset($place_sell) && !isset($price) && !isset($category) && !isset($title) && !isset($body)) {
        echo("상품 등록을 진행하기 위한 최소한의 내용을 충족해주세요!");
    }

    // 값 체크
    if (iconv_strlen($title,'utf-8') <= 0){
        echo("제목을 작성하지 않으셨습니다. 다시 시도해주세요.");
    }

    if (iconv_strlen($body,'utf-8') <= 0){
        echo("본문을 작성하지 않으셨습니다. 다시 시도해주세요.");
    }

    # 길이 체크
    if(isset($title)){
        if (iconv_strlen($title,'utf-8') > 100){
            echo("제목이 너무 길어 처리할 수 없습니다. 다시 시도해주세요.");
        }
    }

    if(isset($body)){
        if (iconv_strlen($body,'utf-8') > 4000){
            echo("본문이 너무 길어 처리할 수 없습니다. 다시 시도해주세요.");
        }
    }


    // 상품 등록시 aid 확인 및 파일 디렉토리 생성
    $sql = "SELECT * FROM product ORDER BY articleid DESC LIMIT 1";
    $result = sql_select($sql);

    // 쿼리 조회 결과가 있는지 확인
    if($result) {
        // echo($result);
        $articleid = $result['articleid'];
    } else {
        echo mysqli_error($db);
        // $articleid = 1;
    }

    $articleid += 1;

    // 디렉토리 생성
    $dir = '/app/assets/p_img/'.$articleid.'/';
    if (!file_exists($path)) {
        mkdir($dir, 0777, true);
    }

    // 파일 업로드 진행
    $imageKind = array ('image/pjpeg', 'image/jpeg', 'image/JPG', 'image/X-PNG', 'image/PNG', 'image/png', 'image/x-png');
    // $dir = '/app/assets/p_img/'.$articleid.'/';

    // 이미지 카운터 확인
    $image_check = $_POST['image_count'];

    if($image_check <= 0){
        alertback("반드시 이미지 하나 이상을 업로드해주셔야 합니다.");
    }
    
    for($i=0; $i<$_POST['image_count']; $i++) {
        
        $image_id = "image_".$i;
        $image_file = time().$i.".jpg";
    
        if(isset($_FILES[$image_id]) && !$_FILES[$image_id]['error']) {
            if(in_array($_FILES[$image_id]['type'], $imageKind)) {
                if(move_uploaded_file($_FILES[$image_id]['tmp_name'], $dir.$image_file)) {
                    // echo "Success Upload Image";
                } else {
                    echo "Error Upload Image";
                }
            } else {
                echo "Not Image Type";
            }
        } else {
            echo "Image Upload Fail";
        }
    
    }    

    $safe_userid = prevent_sqli($userid);

    // 멤버 세션값 기반 -> 유저 정보 확인
    $sql = "SELECT * FROM member where id='{$safe_userid}'";
    $result = sql_select($sql);

    // 쿼리 조회 결과가 있는지 확인
    if($result) {
        // echo "조회 성공";
    } else {
        echo("실패..");
        return;
    }

    // 유저 입력 정보
    // $place_sell = $_POST['place'];
    // $price = intval($_POST['price']);
    // $category = intval($_POST['category']);
    // $title = $_POST['title'];
    // $body = $_POST['body'];
    // $saleway = intval($_POST['saleway']);
    $imagepath = 'assets/p_img/'.$articleid.'/';

    // 필요한 유저 정보 가져오기
    $phone = $result['phone'];
    $office = $result['office'];
    $belong = $result['belong'];
    $city = $result['city'];


    // 기본 값 설정 및 데이터 검증
    $status = 0; 

    // 이상이 없다면, DB insert
    // articleid	title	body	price	category	place_sell	saleway	imagepath	uploadtime	id	city	office	phone	status	buyer	qrpath	qrdata
    // articleid	title	body	price	category	place_sell	saleway	imagepath	uploadtime	id	belong	city	office	phone	status	buyer	qrpath	qrdata	
    
    $title = prevent_xss($title);
    $body = prevent_xss($body);
    
                  
    $safe_var=array(prevent_sqli($title), prevent_sqli($body), prevent_sqli($price), prevent_sqli($category), prevent_sqli($place_sell), 
    prevent_sqli($saleway), prevent_sqli($imagepath), prevent_sqli($uploadtime),prevent_sqli($userid), prevent_sqli($belong), prevent_sqli($city),
    prevent_sqli($office), prevent_sqli($phone), prevent_sqli($status));

    $sql = "INSERT INTO product(`title`, `body`, `price`, `category`, `place_sell`, `saleway`, `imagepath`, `uploadtime`, 
    `id`, `belong`, `city`, `office`, `phone`, `status`) VALUES ('{$safe_var[0]}', '{$safe_var[1]}', '{$safe_var[2]}', '{$safe_var[3]}', '{$safe_var[4]}', '{$safe_var[5]}', '{$safe_var[6]}', '{$safe_var[7]}', '{$safe_var[8]}'
    , '{$safe_var[9]}', '{$safe_var[10]}', '{$safe_var[11]}', '{$safe_var[12]}', '{$safe_var[13]}')";

    $result = sql_insert($sql);
    echo $sql;

    if (!$result) {
        echo mysqli_error($db);
        // echo("작성 실패..");
    } else {
        // 사기 매물 제고 성공 안내 및 리다이렉트
        echo("작성 완료!");
    }
?>