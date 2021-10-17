<?php
    # 기초함수 불러오기
    require_once("/app/modules/dbconn.php");
    require_once("/app/modules/security.php");
    // require_once($_SERVER['DOCUMENT_ROOT']."/modules/security.php");
    
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

    function getRemoteFile($url)
    {
        // host name 과 url path 값을 획득
        $parsedUrl = parse_url($url);
        $host = $parsedUrl['host'];
        if (isset($parsedUrl['path'])) {
            $path = $parsedUrl['path'];
        } else {
            // url이 http://www.mysite.com 같은 형식이라면
            $path = '/';
        }

        if (isset($parsedUrl['query'])) {
            $path .= '?' . $parsedUrl['query'];
        }

        if (isset($parsedUrl['port'])) {
            $port = $parsedUrl['port'];
        } else {
            // 대부분의 사이트들은 80포트를 사용
            $port = '80';
        }

        $timeout = 10;
        $response = '';
        // 원격 서버에 접속한다
        $fp = @fsockopen($host, $port, $errno, $errstr, $timeout );

        if( !$fp ) {
            echo "Cannot retrieve $url";
        } else {
            // 필요한 헤더들 전송
            fputs($fp, "GET $path HTTP/1.0\r\n" .
                "Host: $host\r\n" .
                "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.0.3) Gecko/20060426 Firefox/1.5.0.3\r\n" .
                "Accept: */*\r\n" .
                "Accept-Language: en-us,en;q=0.5\r\n" .
                "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7\r\n" .
                "Keep-Alive: 300\r\n" .
                "Connection: keep-alive\r\n" .
                "Referer: http://$host\r\n\r\n");

            // 원격 서버로부터 response 받음
            while ( $line = fread( $fp, 4096 ) ) {
                $response .= $line;
            }

            fclose( $fp );

            // header 부분 걷어냄
            $pos      = strpos($response, "\r\n\r\n");
            $response = substr($response, $pos + 4);
        }

        // 파일의 content 리턴
        return $response;
    }
?>