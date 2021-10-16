<?php

    error_reporting(E_ALL);
    
    /* 보안 관련 함수 모음입니다. */
    function prevent_sqli($input){
        global $db;
        /* SQL Injection 방어함수입니다. */
        $result = mysqli_real_escape_string($db, $input);
        return $result;
    }

    function prevent_xss($input){
        /* XSS 공격 방어 함수입니다. */
        $result = htmlspecialchars($input, ENT_HTML5 | ENT_QUOTES | ENT_SUBSTITUTE | ENT_DISALLOWED);
        return $result;
    }

    function passhash($password){
        $salt = "Th1\$i\$v3ryS3cUr3s41T";
        $pepper = "AnDThi\$iSP3PP3r";
        $plainpass = $salt.$password.$pepper;
        $hashpass = hash("sha256", $plainpass);
        return $hashpass;
    }

?>
