<?php
include "db_conn.php";

$orguser = $_POST['orguser'];
$invoiceamt = $_POST['invoiceamt'];
$availfunds = $_POST['availfunds'];
$newavailfunds = intval($availfunds) - intval($invoiceamt);
$invoicetl = $_POST['invoicetl'];
$desc = $_POST['desc'];

if(isset($_POST)){
 if($invoiceamt>$availfunds){
        http_response_code(500);
    } else {
        if (empty($invoiceamt)) {
            http_response_code(500);
        } else if (empty($invoicetl)) {
            http_response_code(500);
        } else if (empty($desc)) {
            http_response_code(500);
        } else {
            $insertinvoicesql = "INSERT INTO `orginvoice`(`username`, `title`, `description`, `amount`) VALUES ('$orguser','$invoicetl','$desc','$invoiceamt')";
            $updateavailfunds = "UPDATE `organizations` SET `availfunds`='$newavailfunds' WHERE `username` = '$orguser'";
            $insertinvoicesqlresults = mysqli_query($conn, $insertinvoicesql);
            $updateavailfundsresults = mysqli_query($conn, $updateavailfunds);
        }
    }

}else{
    http_response_code(500);
}




?>