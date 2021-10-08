 <?php
    // for hangul.
    header("Content-Type:text/html;charset=utf-8");
    
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    //모듈 로드
    include_once("/app/modules/common.php");

    @session_start();
    if(!isset($_SESSION['login_session'])){
        alertback("로그인이 필요한 서비스입니다.");
    }

    // 세션 값 가져오기
    $id = $_SESSION['id'];
    $name = $_SESSION['name'];
    $admin = $_SESSION['admin'];

    // idx 값 GET으로 가져오기
    if(isset($_GET['idx'])) {
        $idx =  $_GET['idx'];
    } else {
        alertback("삭제 글 번호를 확인해주세요.");
    }

    $idx = prevent_sqli($idx);
    # 게시글 값 가져오기
    $sql = "SELECT * FROM report where idx='{$idx}'";
    $result = sql_select($sql);

    // 유저 검증
    if($result['id'] == $id or $admin == 1){
        // 삭제 진행
        $secure_idx = prevent_sqli($idx);

        $sql = "DELETE FROM report WHERE idx='$secure_idx'";
        $result = sql_insert($sql);

        if($result) {
            alert("글 삭제에 성공 하였습니다.");
        } else {
            alert("글 삭제에 실패 하였습니다..");
        }
        redirect("../report.php");
    }else{
        alertback("삭제 권한이 부족합니다..");
    }
?>