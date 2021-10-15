<?php
include_once ("phpqrcode/qrlib.php");
require_once("/app/modules/common.php");


function qrGenrater($qrContents){
    // $qrContents = $_POST["qr"];
    #alert($qrContents);
    $qreslut = explode(",", $qrContents);
    // var_dump($qreslut)

    $filePath = sha1($qrContents).".png";

    if(!file_exists($filePath)) {
        $ecc = 'H';
        $pixel_Size = 10;
        $frame_Size = 10;
        QRcode::png($qrContents, $filePath, $ecc, $pixel_Size, $frame_Size);
    }

    #거래 확정 후 상품에 qr 정보 업데이트
    $query = "update product set buyer = '".$qreslut[1]."', qrpath = '".$filePath."', qrdata = '".$qrContents."' where articleid = '".$qreslut[0]."' ";
    // $result = mysqli_query($db, $query);
    sql_insert($query);
}

// $qrContents = $_POST["qr"];
// #alert($qrContents);

// $qreslut = explode(",", $qrContents);

// $filePath = sha1($qrContents).".png";

// if(!file_exists($filePath)) {
//     $ecc = 'H';
//     $pixel_Size = 10;
//     $frame_Size = 10;
//     QRcode::png($qrContents, $filePath, $ecc, $pixel_Size, $frame_Size);
// }

// #거래 확정 후 상품에 qr 정보 업데이트
// $query = "update product set buyer = '".$qreslut[1]."', qrpath = '".$filePath."', qrdata = '".$qrContents."' where articleid = '".$qreslut[0]."' ";
// $result = mysqli_query($db, $query);

# Print QR
# echo "save filename : ".$filePath;
# echo "<hr/>";
# echo "<center><img src='".$filePath."'/></center>"
?>