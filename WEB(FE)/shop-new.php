<!DOCTYPE html>

<html lang="en">
<head>
    <title>전우장터 - 상품 등록</title>
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

    <script src="assets/js/jquery-1.11.0.min.js"></script>
    <script src="assets/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/templatemo.js"></script>
    <script src="assets/js/custom.js"></script>

    <style type="text/css">

    input[type=file] {
        display: none;
    }

    .my_button {
        display: inline-block;
        width: 200px;
        text-align: center;
        padding: 10px;
        background-color: #006BCC;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
    }



    .imgs_wrap {

        border: 2px solid #A8A8A8;
        margin-top: 30px;
        margin-bottom: 30px;
        padding-top: 10px;
        padding-bottom: 10px;

    }
    .imgs_wrap img {
        max-width: 150px;
        margin-left: 10px;
        margin-right: 10px;
    }

    </style>

    <script type="text/javascript">

        // 이미지 정보들을 담을 배열
        var sel_files = [];


        $(document).ready(function(){
            $("#input_imgs").on("change", handleImgFileSelect);
        }); 

        function fileUploadAction() {
            console.log("fileUploadAction");
            $("#input_imgs").trigger('click');
        }

        function handleImgFileSelect(e) {

            // 이미지 정보들을 초기화
            sel_files = [];
            $(".imgs_wrap").empty();

            var files = e.target.files;
            var filesArr = Array.prototype.slice.call(files);

            var index = 0;
            filesArr.forEach(function(f) {
                if(!f.type.match("image.*")) {
                    alert("확장자는 이미지 확장자만 가능합니다.");
                    return;
                }

                sel_files.push(f);

                var reader = new FileReader();
                reader.onload = function(e) {
                    var html = "<a href=\"javascript:void(0);\" onclick=\"deleteImageAction("+index+")\" id=\"img_id_"+index+"\"><img src=\"" + e.target.result + "\" data-file='"+f.name+"' class='selProductFile' title='Click to remove'></a>";
                    $(".imgs_wrap").append(html);
                    index++;

                }
                reader.readAsDataURL(f);
                
            });
        }

        function deleteImageAction(index) {
            console.log("index : "+index);
            console.log("sel length : "+sel_files.length);

            sel_files.splice(index, 1);

            var img_id = "#img_id_"+index;
            $(img_id).remove(); 
        }

        function submitAction() {
            console.log("업로드 파일 갯수 : "+sel_files.length);
            var data = new FormData();

            for(var i=0, len=sel_files.length; i<len; i++) {
                var name = "image_"+i;
                data.append(name, sel_files[i]);
            }
            data.append("image_count", sel_files.length);

            // add post data
            let place = document.getElementById('place').value;
            data.append("place", place);
            let price = document.getElementById('price').value;
            data.append("price", price);
            // let category = document.getElementById('category').value;
            let category = document.getElementById("category");
            category = category.options[category.selectedIndex].value;
            data.append("category", category);
            let title = document.getElementById('title').value;
            data.append("title", title);
            let body = document.getElementById('body').value;
            data.append("body", body);
            let saleway = document.getElementById("saleway");
            saleway = saleway.options[saleway.selectedIndex].value;
            data.append("saleway", saleway);

            if(sel_files.length < 1) {
                alert("1개 이상의 파일을 선택해주세요.");
                return;
            }           

            var xhr = new XMLHttpRequest();
            xhr.open("POST","product/add_product.do.php");
            xhr.onload = function(e) {
                if(this.status == 200) {
                    //  console.log("Result : "+e.currentTarget.responseText);
                    // alert(e.currentTarget.responseText);
                    // alert(e.currentTarget.response);
                    alert("상품 등록에 성공하였습니다.");
                    history.back();
                }
            }

            xhr.send(data);
        }

    </script>

</head>

<body>
	<!-- Header -->
	<header id="header"></header>


    <!-- Start Contact -->
    <div class="container py-3">
        <section class="bg-success py-3">
            <div class="container">
                <div class="row align-items-center py-3">
                    <div class="col-md-8 text-white">
                        <h1>전우장터</h1>
                        <p>
                            물건을 등록해볼까요? 얼마 걸리지 않습니다 :)
                        </p>
                    </div>
                    <div class="col-md-4">
                        <img src="assets/img/about-hero.svg" alt="About Hero">
                    </div>
                </div>
            </div>
        </section>

        <div class="row py-5">
            <form class="col-md-9 m-auto" role="form" action="product/add_product.do.php" method="post" enctype="multipart/form-data">
            <!-- 이미지 업로드 여러개 -> 기능 추가 -->
                <div class="mb-3">
                    <br>
                    <label for="inputsubject">거래장소</label>
                    <input type="text" required="required" class="form-control mt-1" id="place" name="place" placeholder="거래장소" data-error="장소를 입력해주세요.">
                </div>
                <div class="mb-3">
                    <label for="inputsubject">가격</label>
                    <input type="number" required="required" class="form-control mt-1" id="price" name="price" placeholder="가격" data-error="가격을 입력해주세요.">
                </div>
                
                <!-- 번개 혹은 당근 카테고리 참고 --> 
                <div class="mb-3">
                    <label for="inputmessage">카테고리</label>
                    <br>
                    <select name="category" id="category">
                        <option value="0">의류</option>
                        <option value="1">신발</option>
                        <option value="2">가방</option>
                        <option value="3">시계 & 쥬얼리</option>
                        <option value="4">패션 액세서리</option>
                        <option value="5">디지털/가전</option>
                        <option value="6">스포츠/레저</option>
                        <option value="7">스타굿즈</option>
                        <option value="8">키덜트</option>
                        <option value="9">음반/악기</option>
                        <option value="10">도서/문구</option>
                        <option value="11">뷰티/미용</option>
                        <option value="12">가구/인테리어</option>
                        <option value="13">생활/가공식품</option>
                        <option value="14">기타 (ETC)</option>
                    </select>                    
                </div>
                <div class="mb-3">
                    <label for="inputmessage">판매방법</label>
                    <br>
                    <select name="saleway" id="saleway">
                        <option value="0">부대 내 직거래, 보관함, 부대 외</option>
                        <option value="1">부대 내 직거래</option>
                        <option value="2">부대 내 보관함</option>
                        <option value="3">부대 내 직거래, 보관함</option>
                        <option value="4">부대 외</option>
                        <option value="5">부대 내 직거래, 부대 외</option>
                    </select>                    
                </div>
                <div class="mb-3">
                    <label for="inputsubject">제목</label>
                    <input type="text" required="required" class="form-control mt-1" id="title" name="title" placeholder="제목" data-error="제목을 입력해주세요.">
                </div>
                <div class="mb-3">
                <label for="inputmessage">본문</label>
                    <textarea class="form-control mt-1" id="body" name="body" placeholder="본문" rows="8" required="required"></textarea>
                </div>
                <div class="mb-3">
                    <div>
                        <h4>이미지 미리보기</h4>
                        <div class="input_wrap">
                        <input type="file" id="input_imgs" multiple/>
                        
                    </div>
                    <div>
                        <div class="imgs_wrap">
                            <img id="img" />
                        </div>
                    </div>
                    <a href="javascript:" onclick="fileUploadAction();" class="my_button">파일 업로드</a>
                    <a href="javascript:" class="my_button" onclick="submitAction();">상품 등록</a>
                </div>

            </form>
        </div>
    </div>
    <!-- End Contact -->

	<!-- Footer -->
	<footer id="footer"></footer>


<script type="text/javascript">
	//헤더 모듈화
	$(document).ready(function(){
		$("#header").load("/header.php")
	});
	//푸터 모듈화
	$(document).ready(function(){
		$("#footer").load("/footer.php")
	});
</script>
</body>

</html>