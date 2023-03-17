<?php
include "db_conn.php";


$rsrcode        = $_POST['srcode'];
$rfirstname 		= $_POST['firstname'];
$rlastname 		= $_POST['lastname'];
$rmiddlename 	= $_POST['middlename'];
$rsuffix         = $_POST['suffix'];
$remail 			= $_POST['email'];
$ryear	        = $_POST['year'];
$rprogram	    = $_POST['program'];
$rsection	    = $_POST['section'];
$rsPhoto	        = "defaultimg.jpg";
$rpassword 		= password_hash($rsrcode.$rlastname, PASSWORD_DEFAULT);
$rstatus         = "enrolled";


if(isset($_POST)){
    $studentquery = "SELECT * from students WHERE srcode = '$rsrcode'";
    $studentqueryresults = mysqli_query($conn, $studentquery);
    if (mysqli_num_rows($studentqueryresults) == 1) {
                http_response_code(500);
        } else {
        $createaccount = "INSERT INTO `students`(`srcode`, `email`, `password`, `lname`, `fname`, `mname`, `suffix`, `program`, `section`, `year`, `sPhoto`, `status`) VALUES ('$rsrcode','$remail','$rpassword','$rlastname','$rfirstname','$rmiddlename','$rsuffix','$rprogram','$rsection','$ryear','$rsPhoto','$rstatus')";
        $createresults = mysqli_query($conn, $createaccount);
        echo "Created Account Successfully";
        if($rprogram == "BS in Information Technology"){
            $cicsquery = "INSERT INTO `cics-sc`(`username`, `srcode`, `year`, `status`) VALUES ('cics','$rsrcode','$ryear','Unpaid')";
            $cicsqueryresults = mysqli_query($conn,$cicsquery);

            $intessquery = "INSERT INTO `intess`(`username`, `srcode`, `year`, `status`) VALUES ('intess','$rsrcode','$ryear','Unpaid')";
            $intessresults = mysqli_query($conn,$intessquery);
        }
        else if($rprogram == "BS in Computer Sciences"){
            $cicsquery = "INSERT INTO `cics-sc`(`username`, `srcode`, `year`, `status`) VALUES ('cics','$rsrcode','$ryear','Unpaid')";
            $cicsqueryresults = mysqli_query($conn,$cicsquery);

            $accessquery = "INSERT INTO `access`(`username`, `srcode`, `year`, `status`) VALUES ('intess','$rsrcode','$ryear','Unpaid')";
            $accessresults = mysqli_query($conn,$accessquery);
        }
    }
}

    ?>