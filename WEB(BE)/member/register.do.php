
<?php
    // POST
    // input : name, id, serialnumber, pw, email, phone, belong, office, officePhone
    // default : idx, login_session, admin 
    
    // 	idx, name, id, serialnumber, pw, email, phone, belong, office, officePhone, admin, login_session

    // for hangul.
    header("Content-Type:text/html;charset=utf-8");
    
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    //모듈 로드
    include_once("/app/modules/common.php");

    //METHOD 확인
    if($_SERVER["REQUEST_METHOD"] != "POST"){
        alertback("잘못된 요청 입니다.");
    }

    // 로그인 여부 확인
    @session_start();
    if(isset($_SESSION['login_session'])){
        alertback("이미 로그인 하셨습니다.");
    }

    // input : name, id, serialnumber, PW, PWcheck, email, phone, belong, office, officePhone
    $name = $_POST['name'];
    $id = $_POST['ID'];
    $serialnumber = $_POST['serialnumber'];
    $pw1 = $_POST['PW'];
    $pw2 = $_POST['PWcheck'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $belong = $_POST['belong'];
    $city = $_POST['city'];
    $office = $_POST['office'];
    $officePhone = $_POST['officePhone'];

    //name 필드 공백여부 확인 및 글자수 체크
    if(!isset($name)){
        alertback("이름를 입력해주세요.");
    }
    else{
        if (iconv_strlen($name,'utf-8') > 30){
            alertback("이름은 30자 이내로 설정해주시기 바랍니다.");
        }
    }

    //id 필드 공백여부 확인 및 글자수/중복 체크
    if(!isset($id)){
        alert("아이디를 입력해주세요.");
    }
    else{
        if(iconv_strlen($id,'utf-8')>30) {
            alertback("아이디는 30자 이내로 설정해주시기 바랍니다.");
        }
        //중복 체크
        $secure_id = prevent_sqli($id);

        $query = "select * from member where email='{$secure_id}'";
        $row = sql_select($query);

        if($row != False){
            alertback("동일한 아이디가 이미 존재합니다.");
        }
    }
    
    //serialnumber 필드 공백여부 확인 및 글자수/중복 체크
    if(!isset($serialnumber)){
        alert("군번을 입력해주세요.");
    }
    else{
        if(iconv_strlen($serialnumber,'utf-8')>11) {
            alertback("군번이 정상적인 형식이 아닙니다.");
        }
        //중복 체크
        $secure_serialnumber = prevent_sqli($serialnumber);

        $query = "select * from member where serialnumber='{$secure_serialnumber}'";
        $row = sql_select($query);

        if($row != False){
            alertback("동일한 군번이 이미 존재합니다.");
        }
    }
    
    // 패스워드 비교 
    if($pw1 != $pw2){
        alertback("비밀번호가 일치하지 않습니다.");
    }

    //pw 필드 공백 여부 확인 및 자리수 검사
    if(!isset($pw1)){
        alertback("비밀번호를 입력해주세요.");
    }
    else {
        // PW 체크
        $checkValue = passwordCheck($pw1);

        if($checkValue[0] == false){
            alertback($checkValue[1]);
        }
    }

    //email 필드 공백여부 확인 및 글자수/중복 체크
    if(!isset($email)){
        alert("이메일을 입력해주세요.");
    }
    else{
        if(isemail($email)!=True or iconv_strlen($email,'utf-8')>50) {
            alertback("이메일이 정상적인 Email 형식이 아닙니다.");
        }
        //중복 체크
        $secure_email = prevent_sqli($email);

        $query = "select * from member where email='{$secure_email}'";
        $row = sql_select($query);

        if($row != False){
            alertback("동일한 이메일이 존재합니다.");
        }
    }

    // phone 필드 공백여부 확인 및 글자수 체크
    if(!isset($phone)){
        alertback("전화번호를 입력해주세요.");
    }
    else{
        if (iconv_strlen($name,'utf-8') > 11){
            alertback("정상적인 값이 아닙니다. 다시 시도해주세요.");
        }
    }

    // belong 필드 공백여부 확인 
    if(!isset($belong)){
        alertback("군 소속을 입력해주세요.");
    }

    // belong 필드 공백여부 확인 
    if(!isset($city)){
        alertback("지역을 입력해주세요.");
    }

    // office (상세 소속) 필드 공백여부 확인 및 글자수 체크
    if(!isset($office)){
        alertback("전화번호를 입력해주세요.");
    }
    else{
        if (iconv_strlen($office,'utf-8') > 100){
            alertback("입력 가능 범위를 넘었습니다.");
        }
    }

    // officePhone
    if(!isset($officePhone)){
        alertback("사무실 연락처를 입력해주세요.");
    }
    else{
        if (iconv_strlen($officePhone,'utf-8') > 11){
            alertback("정상적인 값이 아닙니다. 다시 시도해주세요.");
        }
    }

    //패스워드를 sha256으로 해싱 및 status 값 
    $pw = passhash($pw1);
    $admin = 0; 

    // input : name, id, serialnumber, PW, PWcheck, email, phone, belong, office, officePhone
    //모두 확인하여 이상이 없으므로 DB에 데이터 넣기
    // default : idx, admin, login_session
    
    $safe_var=array(prevent_sqli($name), prevent_sqli($id), prevent_sqli($serialnumber), $pw, prevent_sqli($email), 
    prevent_sqli($phone), prevent_sqli($belong), prevent_sqli($city), prevent_sqli($office), prevent_sqli($officePhone), $admin);

    $query = "INSERT INTO member(`name`, `id`, `serialnumber`, `password`, `email`, `phone`, `belong`,`city`,`office`, `officePhone`, `admin`) VALUES ('{$safe_var[0]}', 
    '{$safe_var[1]}', '{$safe_var[2]}', '{$safe_var[3]}', '{$safe_var[4]}', '{$safe_var[5]}', '{$safe_var[6]}', '{$safe_var[7]}','{$safe_var[8]}','{$safe_var[9]}', '{$safe_var[10]}')";
    
    // var_dump($query);
    // mysqli_query($db, $query);
    # sql_insert($query);

    $result = sql_insert($query);
    if($result === false){
        alertback("치명적인 오류가 발생하였습니다.");
        echo mysqli_error($db);
    }
    
    
    //회원가입 성공 안내 및 메인페이지로 리다이렉트
    alert("회원가입에 성공하였습니다.");
    redirect("../login.html");
?>