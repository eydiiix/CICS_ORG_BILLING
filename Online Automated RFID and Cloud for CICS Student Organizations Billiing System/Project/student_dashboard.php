<?php
include "db_conn.php";
session_start();
if (isset($_SESSION['srcode'])) {
    $uname = $_SESSION['srcode'];
    $studsql = "SELECT * FROM students WHERE srcode='$uname'"; 
	$studresult = mysqli_query($conn, $studsql);
    $studcontent = mysqli_fetch_assoc($studresult);

    //--orgsql
    $oisql = "SELECT * FROM organizations WHERE username ='intess' "; 
    $ocsql = "SELECT * FROM organizations WHERE username ='cics' "; 
    $oasql = "SELECT * FROM organizations WHERE username ='access' "; 
    $ojsql = "SELECT * FROM organizations WHERE username ='jpcs' "; 
    //--resuls
	$oiresult = mysqli_query($conn, $oisql);
    $oaresult = mysqli_query($conn, $oasql);
    $ocresult = mysqli_query($conn, $ocsql);
    $ojresult = mysqli_query($conn, $ojsql);
    //--fetch org data
    $oicontent = mysqli_fetch_assoc($oiresult);
    $oacontent = mysqli_fetch_assoc($oaresult);
    $occontent = mysqli_fetch_assoc($ocresult);
    $ojcontent = mysqli_fetch_assoc($ojresult);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Student-Dashboard</title>
    <style>
        .preloader{
			position: fixed;
			top: 0;
			left: 0;   
			width: 100vw;
			height: 100vh;
			display: flex;
			justify-content: center;
			align-items: center;
			background-color: #f7f0fb;
			background: black;
			z-index: 3;
			
			}
			.preloader--hidden{
			opacity: 0;
			visibility: hidden;
			}

			.preloader::after{
			content: "";
			width: 75px;
			height: 75px;
			border: 15px solid #dddddd;
			border-top-color: #7449f5;
			border-radius: 50%;
			animation: loading 0.75s ease infinite;
			}
			@keyframes loading {
			from{
				transform: rotate(0turn);
			}
			to{
				transform: rotate(1turn);
			}
			
			}
    </style>
    <script>
                window.addEventListener("load", () => {
                const loader = document.querySelector(".preloader");
                loader.classList.add("preloader--hidden");

                loader.addEventListener("transitionend",() => {
                document.body.removeChild(".preloader")
            })
        })
    
    </script>
</head>
<body>
    <div class="preloader"></div>
    <nav class="dash_topnav">
        <div id="logout">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            <a href="logout.php">LOGOUT</a>
        </div>
    </nav>
    <main class="student_dash"> 
        <div class="sub_sd">
            <div id="st_box2">
                <div id="sub_box1">
                    <div id="st_pic">
                        <img src="image/<?php echo $studcontent['sPhoto'];?>" alt="">
                    </div>
                    <div id="st_info">
                        <h4><?php echo $studcontent['fname']."   ".substr($studcontent['mname'],0,1)."."."   ".$studcontent['lname']; ?></h4><br>
                        <h5><?php echo $studcontent['srcode']?> | <?php echo $studcontent['section']?> </h5>
                    </div>
                </div>
            
                <div id="sub_box2">
                    <div id="sub_head">
                        <h3>Liabilities</h3>
                    </div>
                    <!-- This Php will show the division where the student is registered-->
                    <?php 
                    //--query of orgs
                    $studisql = "SELECT * FROM intess WHERE srcode='$uname'"; 
                    $studasql = "SELECT * FROM access WHERE srcode='$uname'"; 
                    $studcsql = "SELECT * FROM `cics-sc` WHERE srcode='$uname'"; 
                    $studjsql = "SELECT * FROM jpcs WHERE srcode='$uname'"; 
                    //--results
                    $studiresult = mysqli_query($conn, $studisql);
                    $studaresult = mysqli_query($conn, $studasql);
                    $studcresult = mysqli_query($conn, $studcsql);
                    $studjresult = mysqli_query($conn, $studjsql);
                    //--fetch data
                    $studicontent = mysqli_fetch_assoc($studiresult);
                    $studacontent = mysqli_fetch_assoc($studaresult);
                    $studccontent = mysqli_fetch_assoc($studcresult);
                    $studjcontent = mysqli_fetch_assoc($studjresult);

                    //-intess condition (div will show if the affected rows result is not 0)
                    if ($studiresult) {
                        if(mysqli_num_rows($studiresult)==0){
                        
                        }else if(mysqli_num_rows($studiresult)==1){
                            ?>
                            <div id="liability">
                            <div id="limage">
                                <img src="image/<?php echo $oicontent['filename'];?>" alt="">
                            </div>
                            <div class="lname">
                                <h3><?php echo $oicontent['username'];?> <span>(PHP <?php echo $oicontent['fee'];?>.00)</span></h3>
                                <h5><?php echo $oicontent['orgname'];?> </h5>
                            </div>
                            <div id="lstatus">
                                <h2><?php echo strtoupper($studicontent['status']);?></h2>
                            </div>
                            </div>  
                            <?php
                        }
                            
                    }else{
                        echo "";
                    }
                     //--access condition (div will show if the affected rows result is not 0)
                    if ($studaresult) {
                        if(mysqli_num_rows($studaresult)==0){
                        
                        }else if(mysqli_num_rows($studaresult)==1){
                            ?>
                            <div id="liability">
                            <div id="limage">
                                <img src="image/<?php echo $oacontent['filename'];?>" alt="">
                            </div>
                            <div class="lname">
                                <h3><?php echo $oacontent['username'];?> <span>(PHP <?php echo $oacontent['fee'];?>.00)</span></h3>
                                <h5><?php echo $oacontent['orgname'];?> </h5>
                            </div>
                            <div id="lstatus">
                                <h2><?php echo strtoupper($studacontent['status']);?></h2>
                            </div>
                            </div>  
                            <?php
                        }
                            
                    }else{
                        echo "";
                    }
                         //--cics condition (div will show if the affected rows result is not 0)
                    if ($studcresult) {
                        if(mysqli_num_rows($studcresult)==0){
                        
                        }else if(mysqli_num_rows($studcresult)==1){
                            ?>
                            <div id="liability">
                            <div id="limage">
                                <img src="image/<?php echo $occontent['filename'];?>" alt="">
                            </div>
                            <div class="lname">
                                <h3><?php echo $occontent['username'];?> <span>(PHP <?php echo $occontent['fee'];?>.00)</span></h3>
                                <h5><?php echo $occontent['orgname'];?> </h5>
                            </div>
                            <div id="lstatus">
                                <h2><?php echo strtoupper($studccontent['status']);?></h2>
                            </div>
                            </div>  
                            <?php
                        }
                            
                    }else{
                        echo "";
                    }
                         //--access condition (div will show if the affected rows result is not 0)
                         if ($studjresult) {
                            if(mysqli_num_rows($studjresult)==0){
                            
                            }else if(mysqli_num_rows($studjresult)==1){
                                ?>
                                <div id="liability">
                                <div id="limage">
                                    <img src="image/<?php echo $ojcontent['filename'];?>" alt="">
                                </div>
                                <div class="lname">
                                    <h3><?php echo $ojcontent['username'];?> <span>(PHP <?php echo $ojcontent['fee'];?>.00)</span></h3>
                                    <h5><?php echo $ojcontent['orgname'];?> </h5>
                                </div>
                                <div id="lstatus">
                                    <h2><?php echo strtoupper($studjcontent['status']);?></h2>
                                </div>
                                </div>  
                                <?php
                            }
                                
                        }else{
                            echo "";
                        }?>
                     
                   
                   
                   
                </div>
            </div>
        </div>
    </main>
</body>
</html>
<?php
}else{
          header("Location: index.php");
          exit();
}
?>