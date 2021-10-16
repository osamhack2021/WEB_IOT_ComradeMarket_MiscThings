<!DOCTYPE html>

<html lang="en">
<head>
    <title>전우장터 - Register</title>
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
	function area_info($도="") {
		$area_1 = array("국방부","육군","해군","공군");
		$area_2 = array();
		$area_2["국방부"]		= array("육군본부","해군본부","공군본부","국군화생방방호사령부","국군지휘통신사령부","국군수송사령부","국군심리전단","사이버작전사령부", "군사안보지원사령부","국방정보본부","국방시설본부");
		$area_2["육군"]		= array("제1군단","제2군단","제3군단","제5군단","제6군단","7기동군단","8군단","수기사","1사단","2공정사단","3사단","5사단","6사단","7사단","8사단");
		$area_2["해군"]		= array("진해기지사령부/진해특정경비지역사령부","전력분석시험평가단","정보체계관리단","사이버작전센터","해군작전사령부","제1함대","제2함대","제3함대");
		$area_2["공군"]		= array("제3훈련비행단","제5공중기동비행단","제15특수임무비행단","제39정찰비행단","제6탐색구조비행전대","제1전투비행단","제8전투비행단","제10전투비행단","제11전투비행단","제16전투비행단");
		
		if($도 == "")	return $area_1;
		else		return $area_2[$도];
	}
	$area_list		= area_info();
	$area_list2		= area_info($area_list[0]);
?>

<?php 
	function map_info($도="") {
		$area_1 = array("서울특별시","부산광역시","대구광역시","인천광역시","광주광역시","대전광역시","울산광역시","세종특별자치시","경기도","강원도","충청도","전라도","경상도","제주특별자치도");
		$area_2 = array();
		$area_2["서울특별시"]		= array("서울특별시");
		$area_2["부산광역시"]		= array("부산광역시");
		$area_2["대구광역시"]		= array("대구광역시");
		$area_2["인천광역시"]		= array("인천광역시");
		$area_2["광주광역시"]		= array("광주광역시");
		$area_2["대전광역시"]		= array("대전광역시");
		$area_2["울산광역시"]		= array("울산광역시");
		$area_2["세종특별자치시"]	= array("세종");
		$area_2["경기도"]		= array("수원","안양","안산","용인","부천","광명","평택","과천","오산","시흥","군포","의왕","하남","이천","안성","김포","화성","광주","여주","양평","고양","의정부","동두천","구리","남양주","파주","양주","포천","연천","가평");
		$area_2["강원도"]		= array("춘천","원주","강릉","동해","태백","속초","삼척","홍천","횡성","영월","평창","정선","철원","화천","양구","인제","고성","양양");
		$area_2["충청도"]		= array("청주","충주","제천","보은","옥천","영동","증평","진천","괴산","음성","단양","천안","공주","보령","아산","서산","논산","계룡","당진","금산","부여","서천","청양","홍성","예산","태안");
		$area_2["전라도"]		= array("전주","군산","익산","정읍","남원","김제","완주","진안","무주","장수","임실","순창","고창","부안","목포","여수","순천","나주","광양","담양","곡성","구례","고흥","보성","화순","장흥","강진","해남","영암","무안","함평","영광","장성","완도","진도","신안");
		$area_2["경상도"]		= array("포항","경주","김천","안동","구미","영주","영천","상주","문경","경산","군위","의성","청송","영양","영덕","청도","고령","성주","칠곡","예천","봉화","울진","울릉","창원","진주","통영","사천","김해","밀양","거제","양산","의령","함안","창녕","고성","남해","하동","산청","함양","거창","합천");
		$area_2["제주특별자치도"]	= array("제주","서귀포");

		if($도 == "")	return $area_1;
		else		return $area_2[$도];
	}
	$area_list3		= map_info();
	$area_list4		= map_info($area_list3[0]);
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
                            군 내 중고거래 플랫폼, 전우장터에 오신걸 환영합니다. <br><br>
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

        <div class="row py-5">
            <form class="col-md-9 m-auto" method="post" role="form" action="member/register.do.php" name="register">   
            <input type="hidden" id= "city" name="city" value="0" />
            <input type="hidden" id="belong" name="belong" value="0" />

                <div class="mb-3">
                    <label for="inputsubject">성함</label>
                    <input type="text" required="required" class="form-control mt-1" id="name" name="name" placeholder="이름" data-error="이름을 입력해주세요.">
                </div>
                <div class="mb-3">
                    <label for="inputsubject">아이디</label>
                    <input type="text" required="required" class="form-control mt-1" id="ID" name="ID" placeholder="아이디" data-error="아이디를 입력해주세요.">
                </div>
                <div class="mb-3">
                    <label for="inputsubject">군번 - 제외</label>
                    <input type="text" required="required" class="form-control mt-1" id="serialnumber" name="serialnumber" placeholder="군번" data-error="군번을 입력해주세요.">
                </div>
                <div class="mb-3">
                    <label for="inputmessage">패스워드</label>
                    <input type="password" required="required" class="form-control mt-1" id="PW" name="PW" placeholder="패스워드" data-error="패스워드를 입력해주세요.">
                </div>
                <div class="mb-3">
                    <label for="inputmessage">패스워드 확인</label>
                    <input type="password" required="required" class="form-control mt-1" id="PWcheck" name="PWcheck" placeholder="패스워드" data-error="패스워드를 다시 한번 입력해주세요.">
                </div>
                <div class="mb-3">
                    <label for="inputmessage">이메일</label>
                    <input type="email" required="required" class="form-control mt-1" id="email" name="email" placeholder="이메일" data-error="이메일을 입력해주세요.">
                </div>
                <div class="mb-3">
                    <label for="inputmessage">휴대전화번호 - 제외</label>
                    <input type="number" required="required" class="form-control mt-1" id="phone" name="phone" placeholder="휴대전화번호" data-error="전화번호를 입력해주세요.">
                </div>
                <div class="mb-3">
                    <label for="inputmessage">부대가 속한 도시 & 군</label>
                    <!-- <input type="text" required="required" class="form-control mt-1" id="belong" name="belong" placeholder="군 소속" data-error="군 소속을 입력해주세요."> -->
                    <br>
                    
                    <div>
                        <!-- 결과물 가독성을 편하게 하기 위하여 multiple 속성을 명시 -->
                        <select name="client_area3" onchange="setArea4(this.value)" multiple> 
                            <?php foreach($area_list3 AS $area) { 
                                echo'<option value="'.$area.'">'.$area.'</option>';
                            }?>
                        </select>
                        <select name="client_area4" onchange="change_city_val(this)" multiple>
                            <?php foreach($area_list4 AS $area) { 
                                echo'<option value="'.$area.'">'.$area.'</option>';
                            }?>
                        </select>
                    </div>

                </div>
                <div class="mb-3">
                    <label for="inputmessage">군 소속, 부대</label>
                    <!-- <input type="text" required="required" class="form-control mt-1" id="belong" name="belong" placeholder="군 소속" data-error="군 소속을 입력해주세요."> -->
                    <br>
                    <div>
                        <!-- 결과물 가독성을 편하게 하기 위하여 multiple 속성을 명시 -->
                        <select name="client_area" onchange="setArea2(this.value)" multiple> 
                            <?php foreach($area_list AS $area) { 
                                echo'<option value="'.$area.'">'.$area.'</option>';
                            }?>
                        </select>
                        <select name="client_area2" onchange="change_belong_val(this)" multiple>
                            <?php foreach($area_list2 AS $area) { 
                                echo'<option value="'.$area.'">'.$area.'</option>';
                            }?>
                        </select>
                    </div>
                    
                </div>
                <div class="mb-3">
                    <label for="inputmessage">상세 소속</label>
                    <input type="text" required="required" class="form-control mt-1" id="office" name="office" placeholder="상세 소속" data-error="상세 소속을 입력해주세요.">
                </div>
                <div class="mb-3">
                    <label for="inputmessage">사무실 연락처</label>
                    <input type="number" required="required" class="form-control mt-1" id="officePhone" name="officePhone" placeholder="사무실 연락처" data-error="사무실 연락처를 입력해주세요.">
                </div>
                <div class="col d-grid">
                    <button type="submit" class="btn btn-success btn-lg" name="submit" value="submit">회원가입</button>
                </div>

                </div>
            </form>
        </div>
    </div>

    <!-- End Contact -->

    <!-- footer -->
	<?php include "footer.php"; ?>



<script src="assets/js/jquery-1.11.0.min.js"></script>
<script src="assets/js/jquery-migrate-1.2.1.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/templatemo.js"></script>
<script src="assets/js/custom.js"></script>
<script language="javascript">
	function setArea2(area1) {
		var areaArr = new Array();
		
		<?php 
		foreach($area_list AS $area) { 
			$areaArr = area_info($area); 
			$areaTxt=""; 
			foreach($areaArr AS $area2) { 
				$areaTxt .= "'$area2',"; 
			} 
			$areaTxt = substr($areaTxt,0,-1);
		?>
			areaArr["<?php echo $area; ?>"] = [<?php echo $areaTxt?>]; 
		<?php
		} 
		?>
		
		var html = "";
        var area_code = 0;

        if(area1 == "육군"){
            console.log("육군");
            area_code = 200;
        }else if(area1 == "해군"){
            console.log("해군");
            area_code = 300;
        }else if(area1 == "공군"){
            console.log("공군");
            area_code = 400;
        }else{
            console.log("국직");
            area_code = 100;    
        }

		areaArr[area1].forEach(function(element){ 
            html += "<option value='"+area_code+"'>"+element+"</option>"; 
            area_code = area_code + 1;
        });

		$("select[name='client_area2']").empty();
		$("select[name='client_area2']").append(html);
	}

    function setArea4(area3) {
		var areaArr = new Array();
		
		<?php 
		foreach($area_list3 AS $area) { 
			$areaArr = map_info($area); 
			$areaTxt=""; 
			foreach($areaArr AS $area2) { 
				$areaTxt .= "'$area2',"; 
			} 
			$areaTxt = substr($areaTxt,0,-1);
		?>
			areaArr["<?php echo $area; ?>"] = [<?php echo $areaTxt?>]; 
		<?php
		} 
		?>
		
		var html = "";
        var area_code = 0;

        if(area3 == "서울특별시"){
            area_code = 0;
        }else if(area3 == "부산광역시"){
            area_code = 1;
        }else if(area3 == "대구광역시"){
            area_code = 2;
        }else if(area3 == "인천광역시"){
            area_code = 3;
        }else if(area3 == "광주광역시"){
            area_code = 4;
        }else if(area3 == "대전광역시"){
            area_code = 5;
        }else if(area3 == "울산광역시"){
            area_code = 6;
        }else if(area3 == "세종특별자치시"){
            area_code = 7;
        }else if(area3 == "경기도"){
            area_code = 100;
        }else if(area3 == "강원도"){
            area_code = 200;
        }else if(area3 == "충청도"){
            area_code = 300;
        }else if(area3 == "전라도"){
            area_code = 400;
        }else if(area3 == "경상도"){
            area_code = 500;
        }else if(area3 == "제주특별자치도"){
            area_code = 600;
        }else{
            area_code = 8;    
        }
		areaArr[area3].forEach(function(element){ 
            html += "<option value='"+area_code+"'>"+element+"</option>"; 
            area_code = area_code + 1;
        });

		$("select[name='client_area4']").empty();
		$("select[name='client_area4']").append(html);
	}
</script>

<script type="text/javascript">
    function change_city_val(obj){
        document.getElementById("city").value = obj.value; 
    }
    function change_belong_val(obj){
        // document.register.belong = obj.value;
        document.getElementById("belong").value = obj.value; 
    }
</script>

</body>

</html>