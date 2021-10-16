<?php
    # 기초함수 불러오기
    require_once("/app/modules/dbconn.php");
    require_once("/app/modules/security.php");
    
    @session_start();
    function alert($text){
        //alert 스크립트 실행
        echo "<script>alert('{$text}');</script>";
    }   

    function alertback($msg)
    {
        //alert 스크립트 실행 후 이전페이지로 이동
        die("<script>alert('{$msg}');history.back()</script>");
    }   

    function redirect($url){
        //특정 url 리다이렉트
        echo ("<meta http-equiv='Refresh' content='1; URL={$url}'>");
    }

    function returnResult($code, $message){
        $json_array = array(
            'status' =>
            array(
                'code' => (int)$code,
                'message' => $message,
            )
        );
        return json_encode($json_array, JSON_UNESCAPED_UNICODE);
    }

    function sql_select($query){
        //SQL select 쿼리 시 $result[칼럼명]으로 호출 가능하게 해주는 함수
        global $db;

        mysqli_query($db, "set session character_set_connection=utf8;");
        mysqli_query($db, "set session character_set_results=utf8;");
        mysqli_query($db, "set session character_set_client=utf8;");

        $query_result = mysqli_query($db, $query);
        if($query_result != False) {
            $row = mysqli_fetch_assoc($query_result);
            $result = $row;
            mysqli_free_result($query_result);
            // [오류] 쿼리 한줄 실행할때마다 데이터베이스가 닫혀서 문제 발생으로 이 부분을 주석처리함.
            // mysqli_close($db);
        }
        else{
            $result = False;
        }
        return $result;
    }

    function sql_insert($query){
        //SQL insert 시 $query 문을 실행시켜주는 함수
        global $db;

        mysqli_query($db, "set session character_set_connection=utf8;");
        mysqli_query($db, "set session character_set_results=utf8;");
        mysqli_query($db, "set session character_set_client=utf8;");
        
        return mysqli_query($db, $query);
    }

    function isemail($email){
        //email 여부 확인 함수. email인 경우 true 리턴
        $check_email=preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email);
        return $check_email;
    }

    // https://for1123.tistory.com/30
    function passwordCheck($_str){
        $pw = $_str;
        $num = preg_match('/[0-9]/u', $pw);
        $eng = preg_match('/[a-z]/u', $pw);
        $spe = preg_match("/[\!\@\#\$\%\^\&\*]/u",$pw);
    
        if(strlen($pw) < 10 || strlen($pw) > 30)
        {
            return array(false,"비밀번호는 영문, 숫자, 특수문자를 혼합하여 최소 10자리 ~ 최대 30자리 이내로 입력해주세요.");
            exit;
        }
    
        if(preg_match("/\s/u", $pw) == true)
        {
            return array(false, "비밀번호는 공백없이 입력해주세요.");
            exit;
        }
    
        if( $num == 0 || $eng == 0 || $spe == 0)
        {
            return array(false, "영문, 숫자, 특수문자를 혼합하여 입력해주세요.");
            exit;
        }
    
        return array(true);
    }

?>