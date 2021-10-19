<?php

    header("Content-Type:text/html;charset=utf-8");

    //모듈 로드
    include_once("/app/modules/common.php");

    // error_reporting(E_ALL);
    // ini_set("display_errors", 1);

    // METHOD 확인
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        alertback("잘못된 요청 입니다.");
    }

    @session_start();
    if (!isset($_SESSION['login_session'])) {
        alertback("로그인이 필요한 서비스입니다.");
    }

    # 요청 시간
    // $requestTime = new DateTime();
    // $requestTime->format('Y-m-d H:i:s');
    // $requestTime = $requestTime->getTimestamp();
    // $requestTime = $requestTime + 32400;
    
    $requestTime = time();
    $requestTime = $requestTime + 32400;
    

    # 작성자 이름 
    $requestId =  $_SESSION['id'];

    # POST
    $status = $_POST['status'];
    $title = $_POST['title'];
    $body = $_POST['body'];
    $valuePic = $_POST['valuePic'];

    // 값 체크
    if (!isset($status) && !isset($title) && !isset($body)) {
        alertback("신고 게시글을 작성하기 위한 최소한의 내용을 충족해주세요!");
    }

    // 값 체크
    if (iconv_strlen($title,'utf-8') <= 0){
        alertback("제목을 작성하지 않으셨습니다. 다시 시도해주세요.");
    }

    if (iconv_strlen($body,'utf-8') <= 0){
        // alertback("본문을 작성하지 않으셨습니다. 다시 시도해주세요.");
    }

    # 길이 체크
    if(isset($title)){
        if (iconv_strlen($title,'utf-8') > 100){
            alertback("제목이 너무 길어 처리할 수 없습니다. 다시 시도해주세요.");
        }
    }

    if(isset($body)){
        if (iconv_strlen($body,'utf-8') > 1000){
            alertback("본문이 너무 길어 처리할 수 없습니다. 다시 시도해주세요.");
        }
    }

    // 이미지 체크 
    if(isset($_FILES['valuePic'])) {
        $report_img = $_FILES['valuePic'];
        if ($report_img['name'] != '' and isset($report_img['name'])) {
            //기본 업로드 설정 및 확장자 제한
            $upload_dir = '/app/assets/r_img';
            $ext_str = "jpg,png,jpeg";
            $allowed_extensions = explode(',', $ext_str);
            $max_file_size = 5242880;
            $max_file_mb = $max_file_size / 1024;
            $max_file_mb = (string)$max_file_mb;
            $ext = substr($report_img['name'], strrpos($report_img['name'], '.') + 1);

            //화이트리스트 밖의 확장자의 경우 업로드 불가
            if (!in_array($ext, $allowed_extensions)) {
                alertback("업로드할 수 없는 확장자 입니다.");
            }

            // 파일 크기 체크
            if ($report_img['size'] >= $max_file_size) {
                alertback($max_file_mb . "MB 까지만 업로드 가능합니다.");
            }

            $img_name = $report_img['name'] . date('Y-m-d H:i:s', time());
            $img_name = md5($img_name) . "." . $ext;
            move_uploaded_file($report_img['tmp_name'], "{$upload_dir}/{$img_name}");
            $upload_dir = "assets/r_img";
            $imagepath =  "{$upload_dir}/{$img_name}";
        }
    }
    else{
        alertback("이미지가 필요합니다.");
    }

    // hit, reply 값 
    $hit = 0;
    $reply = 0; 

    // 이상이 없다면, DB insert

    # $conn = mysqli_connect('localhost', 'project', 'P@ssW0rd2316', 'catchyou_web') or die('Error: Mysql Connection Error');
                        
    $safe_var=array(prevent_sqli($requestId), prevent_sqli($title), prevent_sqli($body), prevent_sqli($imagepath), prevent_sqli($status), prevent_sqli($requestTime), prevent_sqli($hit), prevent_sqli($reply));

    $sql = "INSERT INTO report(`id`, `title`, `body`, `imagepath`, `status`, `date`, `hit`, `reply`) VALUES ('{$safe_var[0]}', '{$safe_var[1]}', '{$safe_var[2]}', '{$safe_var[3]}', '{$safe_var[4]}', '{$safe_var[5]}', '{$safe_var[6]}', '{$safe_var[7]}')";
    $result = sql_insert($sql);

    if (!$result) {
        echo mysqli_error($db);
        alert("작성 실패..");
    } else {
        // 사기 매물 제고 성공 안내 및 리다이렉트
        alert("문의 게시판 글 작성 완료!");
        redirect("../report.php");
    }
?>