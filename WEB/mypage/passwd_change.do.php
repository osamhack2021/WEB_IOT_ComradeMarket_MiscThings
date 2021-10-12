<?php
    // for hangul.
    header("Content-Type:text/html;charset=utf-8");
    
    //각종 모듈 로드
    include_once("/app/modules/common.php");

    # error_reporting(E_ALL);
    # ini_set("display_errors", 1);

    //METHOD 확인
    if($_SERVER["REQUEST_METHOD"] != "POST"){
        alertback("잘못된 요청 입니다.");
    }

    //로그인 체크
    if(!isset($_SESSION['login_session'])){
        alertback("먼저 로그인 해 주세요.");
    }

    // POST
    $id = $_SESSION['id'];

    $password = $_POST['passwd'];
    $n_password = $_POST['c_passwd'];
    $n_password_check = $_POST['ch_passwd'];


    //n_password 필드 검사
    if(!isset($n_password)){
        alertback("새 비밀번호를 입력해주세요.");
    }
    else {
        if (iconv_strlen($n_password, 'utf-8') < 6) {
            alertback("보안을 위해 비밀번호는 최소 6자리 이상으로 입력해주세요.");
        }
    }

    //n_password_check, n_password 필드 검사
    if(!isset($n_password_check)){
        alertback("확인용 비밀번호를 입력해주세요.");
    }
    else {
        if ($n_password_check != $n_password) {
            alertback("입력한 비밀번호와 일치하지 않습니다.");
        }
    }

    //id와 password 보안처리
    $secure_id = prevent_sqli($id);
    $password = passhash($password);

    //쿼리 전송
    $query = "select * from member where id='{$secure_id}'";
    $row = sql_select($query);

    //id가 존재하지 않을 경우 id 존재하지 않음 알림
    if(!isset($row['id'])){
        alertback("아이디가 존재하지 않습니다.");
    }
    else{
        if($row["password"] == $password){
            //패스워드를 sha256으로 해싱
            $n_password = passhash($n_password);

            $safe_var=array(prevent_sqli($id), prevent_sqli($n_password));

            //모두 확인하여 이상이 없으므로 DB에 데이터 넣기
            $query = "update member set password='{$safe_var[1]}' where id='{$safe_var[0]}'";
            sql_insert($query);

            //비밀번호 변경 성공 안내 및 메인페이지로 리다이렉트
            alert("비밀번호를 변경하였습니다. 보안을 위해 다시 로그인 해 주세요.");
            session_destroy();
            redirect("../login.html");
        }else{
            // 패스워드 오류시 
            alertback("기존 패스워드를 확인해주세요.");
        }
    }
?>