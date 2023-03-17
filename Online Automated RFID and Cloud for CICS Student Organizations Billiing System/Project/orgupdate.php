<?php
include "db_conn.php";
    $orgname = $_POST['orgfee'];
    $new = $_POST['newfee'];
    if(isset($_POST)){
        if(empty($new)){
        echo "Input a Value!";
        http_response_code(500);
        }else{
        $orgnewquery = "UPDATE `organizations` SET `fee`='$new' WHERE `username`='$orgname'";
        mysqli_query($conn,$orgnewquery);
        echo "Done";
    }
}
?>
