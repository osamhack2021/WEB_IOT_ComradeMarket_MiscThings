<!DOCTYPE html>
<html lang="en">

<head>
    <title>전우장터 - 신고 게시판 (글 작성)</title>
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

    <!-- Load map styles -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
</head>

<?php
    include_once($_SERVER['DOCUMENT_ROOT']."/modules/common.php");

    @session_start();
    if(!isset($_SESSION['login_session'])){
        alertback("로그인이 필요한 서비스입니다.");
    }
?>

<body>
    <!-- Header -->
	<header id="header"></header>

    <!-- Modal -->
    <div class="modal fade bg-white" id="templatemo_search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="w-100 pt-1 mb-5 text-right">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="get" class="modal-content modal-body border-0 p-0">
                <div class="input-group mb-2">
                    <input type="text" class="form-control" id="inputModalSearch" name="q" placeholder="Search ...">
                    <button type="submit" class="input-group-text bg-success text-light">
                        <i class="fa fa-fw fa-search text-white"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- Start Content Page -->
    <div class="container-fluid bg-light py-5">
        <div class="col-md-6 m-auto text-center">
            <h1 class="h1">Contact Us</h1>
            <p>
                중고거래 도중 불편하셨던 점이나, 개선이 필요한 점 혹은 플랫폼을 사용하시면서, 
                사기 혹은 악의적인 사용자로 인해 피해를 입으셨다면, 사기 게시판을 통해 
                이를 저희에게 알려주세요! :) 
            </p>
        </div>
    </div>

    <!-- Start Contact -->
    <div class="container py-5">
        <div class="row py-5">
            <form class="col-md-9 m-auto" enctype="multipart/form-data" method="post" role="form" action="report/add_report.do.php">
                <div class="row">
                    <div class="mb-3">
                        <img style="width: 500px;" id="preview-image" src="assets/img/preview.png">
                        <br>
                        <label for="inputname">Image File [.jpg, .jpeg, .png]</label>
                        <input type="file" id="valuePic" name="valuePic">
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3">
                        <label for="inputname">비밀 여부 확인</label> 
                        <br>
                        <input type="radio" id="status" name="status" value="0" checked="checked"> 비밀 글 
                        <input type="radio" id="status" name="status" value="1"> 공개 글
                    </div>
                </div>
                <div class="mb-3">
                    <label for="inputsubject">제목</label>
                    <input type="text" class="form-control mt-1" id="title" name="title" placeholder="title" required="required">
                </div>
                <div class="mb-3">
                    <label for="inputmessage">본문</label>
                    <textarea class="form-control mt-1" id="body" name="body" placeholder="Message" rows="8" required="required"></textarea>
                </div>
                <div class="row">
                    <div class="col text-end mt-2">
                        <button type="submit" class="btn btn-success btn-lg px-3">업로드</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End Contact -->


    <!-- Start Footer -->
    <footer id="footer"></footer>
    <!-- End Footer -->

    <!-- Start Script -->
    <script src="assets/js/jquery-1.11.0.min.js"></script>
    <script src="assets/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/templatemo.js"></script>
    <script src="assets/js/custom.js"></script>

    <script type="text/javascript">
        //헤더 
        $(document).ready(function(){
            $("#header").load("header.php")
        });
        //푸터
        $(document).ready(function(){
            $("#footer").load("footer.php")
        });
        // 이미지 미리보기 테스트
        function readImage(input) {
            // 인풋 태그에 파일이 있는 경우
            if(input.files && input.files[0]) {
                // 이미지 파일인지 검사 (생략)
                // FileReader 인스턴스 생성
                const reader = new FileReader()
                // 이미지가 로드가 된 경우
                reader.onload = e => {
                    const previewImage = document.getElementById("preview-image")
                    previewImage.src = e.target.result
                }
                // reader가 이미지 읽도록 하기
                reader.readAsDataURL(input.files[0])
            }
        }

        const inputImage = document.getElementById("valuePic")
        inputImage.addEventListener("change", e => {
            readImage(e.target)
        })

        // image ajax 
        
        var fd = new FormData();
        var files = $("#valuePic").get(0).files; // this is my file input in which We can select multiple files.
        fd.append("label", "sound");

        for (var i = 0; i < files.length; i++) {
            fd.append("UploadedImage" + i, files[i]);
        }

        $.ajax({
            type: "POST",
            url: 'product/add_product.do.php',
            contentType: false,
            processData: false,
            data: fd,
            success: function (e) {
                alert("success");                    
            }        
        })

        // 라디오 버튼에 따른 활성화 여부 
        $(document).ready(function(){
        // 라디오버튼 클릭시 이벤트 발생
        $("input:radio[name=status]").click(function(){

            if($("input[name=status]:checked").val() == "1"){
                $("input:password[name=passwd]").attr("disabled",true);
                // radio 버튼의 value 값이 1이라면 활성화

            }else if($("input[name=status]:checked").val() == "0"){
                $("input:password[name=passwd]").attr("disabled",false);
                // radio 버튼의 value 값이 0이라면 비활성화
            }
        });
        });

        
    </script>

    <!-- End Script -->
</body>

</html>