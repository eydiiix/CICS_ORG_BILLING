
<?php 
session_start(); 
include "db_conn.php";

if (isset($_POST['uname']) && isset($_POST['password'])) {
	
	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}
	$uname = validate($_POST['uname']);
	$pass = validate($_POST['password']);
	// -- for superadmin/cics
	$adsql = "SELECT * FROM superadmin WHERE username='$uname'";
	$adresult = mysqli_query($conn, $adsql);
	// -- for organizations
	$sql = "SELECT * FROM login WHERE username='$uname'";
	$result = mysqli_query($conn, $sql);
	//-- for studentdashboard
	$studentsql = "SELECT * FROM `students` WHERE srcode='$uname'";
	$studentresult = mysqli_query($conn, $studentsql);

	if (empty($uname)) {
		header("Location: index.php?error=User Name is required");
	    exit();
	}else if(empty($pass)){
        header("Location: index.php?error=Password is required");
		exit();
	   
	}else if(mysqli_num_rows($adresult)=== 1){
			$adminrow = mysqli_fetch_assoc($adresult);
			if(password_verify($pass,$adminrow['password'])){
				$_SESSION['username'] = $adminrow['username'];
				header("Location: admin_dashboard.php");
				
				
			}else{
				header("Location: index.php?message=".urlencode('Incorrect email or password!'));
		        exit();
				
			}

	}else if(mysqli_num_rows($result) === 1){
			$row = mysqli_fetch_assoc($result);
			if(password_verify($pass,$row['password'])){
            	$_SESSION['username'] = $row['username'];
            	$_SESSION['name'] = $row['name'];
				$_SESSION['orgname'] = $row['orgname'];
				$_SESSION['filename'] = $row['filename'];
				$_SESSION['members'] = $row['members'];
            	header("Location: dashboard.php");
				exit();
            }else{
				header("Location: index.php?message=".urlencode('Incorrect email or password!'));
				exit();
				
			}

	}else if (mysqli_num_rows($studentresult) === 1) {
			$studentrow = mysqli_fetch_assoc($studentresult);

			if(password_verify($pass,$studentrow['password'])){
				$_SESSION['srcode'] = $studentrow['srcode'];
				header("Location: student_dashboard.php");
				exit();
			}else{
				header("Location: index.php?message=".urlencode('Incorrect email or password!'));
				exit();
				}
			}
	else{		echo "<script>alert('Incorrect email or password');</script>";
				header("Location: index.php?message=".urlencode('Incorrect email or password!'));
				exit();
	        	
			}
		
}else{
	header("Location: index.php");
	exit();
}