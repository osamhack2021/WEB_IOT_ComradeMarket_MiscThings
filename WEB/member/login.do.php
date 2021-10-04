<?php
    header("Content-Type:text/html;charset=utf-8");
    
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    //각종 모듈 로드
    include_once("/app/modules/common.php");

    //METHOD 확인
    if($_SERVER["REQUEST_METHOD"] != "POST"){
        alertback("잘못된 요청 입니다.");
    }

    @session_start();

    if(isset($_SESSION['login_session'])){
        alert("이미 로그인하셨습니다.");
        redirect("../index.html");
    }else{
        // id와 password를 post로 받아옴
        $id = $_POST['ID'];
        $password = $_POST['PW'];

        //id와 password 보안처리
        $secure_id = prevent_sqli($id);
        $password = passhash($password);

        //쿼리 전송
        $query = "select * from member where id='{$secure_id}'";
        $row = sql_select($query);

        //id가 존재하지 않을 경우 id 존재하지 않음 알림
        if(!isset($row['id'])){
            alertback("아이디가 존재하지 않습니다. 비회원이시라면 회원가입해주십시오.");
        }
        else{
            if($row["password"] == $password){
                //로그인 성공시 세션 생성
                @session_start();

                $_SESSION['id'] = $secure_id;
                $_SESSION['name'] = $row['name'];
                $_SESSION['admin'] = $row['admin'];

                // session_id 업데이트
                $session_value = session_id();
                $_SESSION['login_session'] = $session_value;

                // var_dump($_SESSION);

                //쿼리 전송
                $query = "UPDATE member SET login_session=`$session_value` WHERE id=`$secure_id`";
                $row = sql_select($query);

                if($row != False){
                    alert("로그인 과정에서 문제가 발생했습니다.");
                }

                //로그인 성공 알림
                alert("로그인에 성공하였습니다.");
                redirect("../index.php");

            }else{
                //로그인 실패 시 확인 알림
                alertback("아이디나 패스워드를 확인해주세요.");
            }
        }
    }
?>