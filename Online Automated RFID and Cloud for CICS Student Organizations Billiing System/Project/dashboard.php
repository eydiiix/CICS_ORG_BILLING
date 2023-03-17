<?php 
session_start();
include "db_conn.php";

if (isset($_SESSION['username'])) {
     $uname = $_SESSION['username'];
     $orgsql = "SELECT * FROM organizations WHERE username='$uname'"; 
	$orgresult = mysqli_query($conn, $orgsql);
     $orgcontent = mysqli_fetch_assoc($orgresult);
       // -- ORGANIZATION MEMBERS TOTAL
    $result=mysqli_query($conn,"SELECT count(*) as members from `$uname`");
    $data=mysqli_fetch_assoc($result);
     // Percentage 
     $ppercent=mysqli_query($conn,"SELECT count(*) as paid from `$uname` WHERE status = 'Paid'");
     $upercent=mysqli_query($conn,"SELECT count(*) as totalstudents from `$uname`");
     $pcpercent=mysqli_fetch_assoc($ppercent);
     $ucpercent=mysqli_fetch_assoc($upercent);
 
     $paidpercent = (intval($pcpercent['paid']))/intval($ucpercent['totalstudents']) * 100;
     $paidpercent2dp = round($paidpercent, 2);

     $decreasepercent = ((((intval($orgcontent['accufunds']) - intval($orgcontent['availfunds']))) / (intval($orgcontent['accufunds']))) * 100);

     $totalpercentage = (((intval($orgcontent['accufunds']))/((intval($orgcontent['fee'])) * (intval($data['members']))))*100);
     $totalpercentage2dp = round($totalpercentage,2)
     
?>

<!DOCTYPE html>
<html>

<head>
     <meta charset="UTF-8">
     <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="dashboard.css">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
     <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&amp;display=swap" rel="stylesheet">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
     <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
     <title><?php echo strtoupper($orgcontent['username']) ?>- CICS Portal</title>
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
          <div id="out">
               <i class="fa-solid fa-arrow-right-from-bracket"></i>
               <a href="logout.php">LOGOUT</a>
          </div>
     </nav>
     <main class="org_page">
          <div class="side_nav bx_shdw">
               <div class="side_n-menu">
                    <ul id="menu">
                         <li><i class="fa-solid fa-house"></i><a href="#dashboard"></i>Dashboard</a></li>
                         <li><i class="fa-solid fa-arrow-right-from-bracket"></i><a href="logout.php">Logout</a></li>
                    </ul>
               </div>
          </div>
          <div class="main_dash">
               <div id="spacer"></div>
               <div class="dash_box2 dash_navigation_title" id="dashboard">
               <h1>DASHBOARD</h1>
               </div>
               <div class="dash_box1">
                    <div class="d_bx1 bx_shdw">
                         <div class="dbx">
                              <h2>Members</h2>
                              <h5>| BSIT</h5>
                         </div>
                         <div class="dbx_content">
                              <i id="member_icon" class="fa-solid fa-users"></i>
                              <div class="dbx_info">
                                   <h3><?php echo $data['members']?></h3> 
                                   <h5><span><?php echo $paidpercent2dp;?>%</span> paid</h5>
                              </div>
                         </div>
                    </div>
                    <div class="d_bx1 bx_shdw">
                         <div class="dbx">
                              <h2>Available Funds</h2>
                              <h5>| Today</h5>
                         </div>
                         <div class="dbx_content">
                              <i id="available_icon" class="fa-solid fa-hand-holding-dollar"></i>  
                              <div class="dbx_info">
                                   <h3>₱ <?php echo $orgcontent['availfunds']?></h3>
                                   <h5><span><?php echo $decreasepercent?>%</span> decrease</h5>
                              </div>
                         </div>
                    </div>
               </div>
               <div class="dash_box2 bx_shdw">
                    <div class="dbx">
                              <h2>Accumulated Funds</h2>
                              <h5>| </h5>
                             
                              
                    </div>
                    <div class="dbx_content">
                         <i id="collect_icon" class="fa-solid fa-peso-sign"></i>
                         <div class="dbx2 dbx_info">
                              <h3>₱ <?php echo $orgcontent['accufunds']?></h3>
                              <h5><span><?php echo $totalpercentage2dp?>%</span> of total</h5>
                         </div>
                    </div>
               </div>
     
               <!-- ------------------------------------ -->
               <div class="dash_box3 bx_shdw" id="box3">
                    <div class="dbx3 dbx">
                         <h2>Report</h2>
                         <h5>| Analytics</h5>
                    </div>
                    <div class="chart_div" id="chart"></div>                             
               </div>
               <div class=" dash_box3 bx_shdw sp" id="box3">
                    <div class="dbx3 dbx">
                         <h2>Expense</h2>
                         <h5>|  Invoice</h5>
                    </div>
                    <form class="desc_div" action="POST">
                         <div class="inpt__div">
                              <input type="text" id="invoicetl" name="_title" placeholder="TITLE" class="dv_inptl"  required/>
                              <input type="text" id="invoiceamt" name="_amount" placeholder="AMOUNT" class="dv_inptr" required oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="8"/>
                              <input type ="hidden" id ="orgavailfunds" value="<?php echo $orgcontent['availfunds']?>"/>
                              <input type ="hidden" id ="orguser" value="<?php echo $orgcontent['username']?>"/>
                         </div>
                         <textarea type="text" id="desc" name="_desc" class="desc_inpt" required></textarea>
                         <label for="_desc" class="_lbl desc__lbl">Description</label>
                         <div class="sub_div">
                              <input type="submit" id="spend" value="SPEND" class="sub_btn"/>
                         </div>
                         <script>
                $(function(){
                                $('#spend').click(function(e){
                                    
                                    var valid = this.form.checkValidity();
                                    

                                    if(valid){
                                    var invoicetl =  $('#invoicetl').val();
                                    var desc = $('#desc').val();
                                    var invoiceamt =  $('#invoiceamt').val();
                                    var availfunds =  $('#orgavailfunds').val();
                                    var orguser =  $('#orguser').val();
                                    
            
                                        e.preventDefault();	
                                    swal.fire({
                                        title: 'Do you wish to  proceed?',
                                        text: "You won't be able to revert this!",
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Confirm',
                                    }).then((result) => {
                                    if (result.value){
                                         $.ajax({
                                            type: 'POST',
                                            url: 'invoice.php',
                                            data: {invoicetl:invoicetl,desc:desc,invoiceamt: invoiceamt, availfunds:availfunds, orguser:orguser},
                                            success: function(data){
                                            Swal.fire({
                                                        'title': 'Success',
                                                        'text': 'Done!',
                                                        'type': 'success'
                                                        
                                                        }).then(function(){ 
                                                location.reload();
                                                }
                                                );
                                                        
                                                    
                                            },
                                            error: function(data){
                                                Swal.fire({
                                                        'title': 'Errors',
                                                        'text': 'Input Value',
                                                        'icon' :'error',
                                                        'type': 'error'
                                                       
                                                        }).then(function(){ 
                                              
                                                }
                                                );
                                                      
                                            }
                                            });
                                        
                                        
                                    }else{
                                        
                                    }
                                    
                                });		

                            }});
                        
                        });
                    

                            
                                </script>
                    </form>
               </div>
          </div>
          
          <div class="side_dash bx_shdw">
               
          <?php
               $msg = "";
               if (isset($_FILES["image"]["name"])) {
               
               $filename = $_FILES["image"]["name"];
               $tempname = $_FILES["image"]["tmp_name"];
               $folder = "./image/" . $filename;
               $db = mysqli_connect("localhost", "root", "","cics");
               $_uname = $_SESSION['username'];
               // Get all the submitted data from the form
               $sql = "UPDATE `login` SET `filename`='$filename' WHERE `username`='$_uname'";
               // Execute query
               mysqli_query($db, $sql);
               // Now let's move the uploaded image into the folder: image
               if (move_uploaded_file($tempname, $folder)) {
               echo  "<script>alert('Image uploaded successfully!')
                         document.location.href = 'dashboard.php';
                    </script>";
               } else {
                    echo "<script>alert('Failed to Upload!')
                    document.location.href = 'dashboard.php';
               </script>";
               }
               }
          ?>

                    
          <?php
               $_uname = $_SESSION['username'];
               $query = " SELECT `filename` FROM `login` WHERE `username` = '$_uname'";
               $result = mysqli_query($conn, $query);
               while ($data = mysqli_fetch_assoc($result)) {
          ?>
               <div class="side_image">
                    <img id="side_image" src="image/<?php echo $data['filename']; ?>">

                    <form id="form" method="POST" action="" enctype="multipart/form-data">
                         
                         <input id="image" type="file" name="image" value="" accept=".jpg, .jpeg, .png" style="display: none;"/> 
                         <div class="change">
                              <input type="button" value="" onclick="document.getElementById('image').click();" />
                              <i class="fa-solid fa-camera-rotate"></i>
                         </div>
                         
                    </form>
                    <script type="text/javascript">
                    document.getElementById("image").onchange = function(){
                    document.getElementById("form").submit();
                    };
                    </script>
               </div>
               <div class="side_content">
                    <h1 class="side_head1"><?php echo $_SESSION['username']?></h1>
                    <h6 class="side_head2"><?php echo $_SESSION['name']?></h6>
               </div>
               <footer>
                    <div id="div_time"></div>
               </footer>
               
               <script src="http://code.jquery.com/jquery-latest.js"></script>

               <script>
                    $(document).ready(function(){
                    $("#div_time").load("time.php");
                    setInterval(function() {
                    $("#div_time").load("time.php");
                    }, 1000);
                    });
               </script>
               
               <?php
               }
               ?>

               </div>
          </div>
     </main>
     <?php 
    // Paid Query
    $st1=mysqli_query($conn,"SELECT count(*) as 1stpaid from `$uname` WHERE year = '1st' && `status` = 'Paid'");
    $nd1=mysqli_query($conn,"SELECT count(*) as 2ndpaid from `$uname` WHERE year = '2nd' && `status` = 'Paid'");
    $rd1=mysqli_query($conn,"SELECT count(*) as 3rdpaid from `$uname` WHERE year = '3rd' && `status` = 'Paid'");
    $th1=mysqli_query($conn,"SELECT count(*) as 4thpaid from `$uname` WHERE year = '4th' && `status` = 'Paid'");
    $st1pd=mysqli_fetch_assoc($st1);
    $nd1pd=mysqli_fetch_assoc($nd1);
    $rd1pd=mysqli_fetch_assoc($rd1);
    $th1pd=mysqli_fetch_assoc($th1);
    // Unpaid Query
    $st2=mysqli_query($conn,"SELECT count(*) as 1stpaid from `$uname` WHERE year = '1st' && `status` = 'Unpaid'");
    $nd2=mysqli_query($conn,"SELECT count(*) as 2ndpaid from `$uname` WHERE year = '2nd' && `status` = 'Unpaid'");
    $rd2=mysqli_query($conn,"SELECT count(*) as 3rdpaid from `$uname` WHERE year = '3rd' && `status` = 'Unpaid'");
    $th2=mysqli_query($conn,"SELECT count(*) as 4thpaid from `$uname` WHERE year = '4th' && `status` = 'Unpaid'");
    $st2pd=mysqli_fetch_assoc($st2);
    $nd2pd=mysqli_fetch_assoc($nd2);
    $rd2pd=mysqli_fetch_assoc($rd2);
    $th2pd=mysqli_fetch_assoc($th2);
    
     // Chart value percentage
    $st=mysqli_query($conn,"SELECT count(*) as 1st from Students WHERE year = '1st'");
    $nd=mysqli_query($conn,"SELECT count(*) as 2nd from Students WHERE year = '2nd'");
    $rd=mysqli_query($conn,"SELECT count(*) as 3rd from Students WHERE year = '3rd'");
    $th=mysqli_query($conn,"SELECT count(*) as 4th from Students WHERE year = '4th'");
    $stresult=mysqli_fetch_assoc($st);
    $ndresult=mysqli_fetch_assoc($nd);
    $rdresult=mysqli_fetch_assoc($rd);
    $thresult=mysqli_fetch_assoc($th);
     $first = $stresult['1st'] ; // st <--- Total BSIT / No. 1st year
     $second = $ndresult['2nd'] ;// nd <--- Total BSIT / No. 2nd year
     $third = $rdresult['3rd'] ; // rd <--- Total BSIT / No. 3rd year
     $fourth = $thresult['4th']  ; // th <--- Total BSIT / No. 4th year

?>

<?php 

     // Chart value percentage

     $st = 34 ; // st <--- Total BSIT / No. 1st year
     $nd = 26 ; // nd <--- Total BSIT / No. 2nd year
     $rd = 24 ; // rd <--- Total BSIT / No. 3rd year
     $th = 16 ; // th <--- Total BSIT / No. 4th year

?>

<script>
  // Total Students
    var st = parseInt(<?php echo $first ?>);
    var nd = parseInt(<?php echo $second ?>);
    var rd = parseInt(<?php echo $third ?>);
    var th = parseInt(<?php echo $fourth ?>);
  // Paid Var
    var stpd = parseInt(<?php echo $st1pd['1stpaid']?>); 
    var ndpd = parseInt(<?php echo $nd1pd['2ndpaid']?>); 
    var rdpd = parseInt(<?php echo $rd1pd['3rdpaid']?>); 
    var thpd = parseInt(<?php echo $th1pd['4thpaid']?>); 
  // Unpaid Var
    var stud = parseInt(<?php echo $st2pd['1stpaid']?>); 
    var ndud = parseInt(<?php echo $nd2pd['2ndpaid']?>); 
    var rdud = parseInt(<?php echo $rd2pd['3rdpaid']?>); 
    var thud = parseInt(<?php echo $th2pd['4thpaid']?>); 
    
     var options = {
          series: [{
        name: 'Paid',
        data: [stpd, ndpd, rdpd, thpd]
        }, {
        name: 'Unpaid',
        data: [stud, ndud, rdud, thud]
        }],
          chart: {
          type: 'bar',
          height: 250,
          stacked: true,
          stackType: '100%',
          toolbar: {
               show: true,
               offsetX: 20,
               offsetY: -60,
               tools: {
               download: true,
               selection: true,
               zoom: false,
               zoomin: false,
               zoomout: false,
               pan: false,
               reset: false | '<img src="/static/icons/reset.png" width="50">',
               customIcons: []
                    }
               }
          },
          plotOptions: {
          bar: {
          horizontal: true,
          },
          },
          stroke: {
          width: 1,
          colors: ['#fff']
          },
          xaxis: {
          
          categories: ['1st','2nd', '3rd', '4th'],
          },
          tooltip: {
          y: {
          formatter: function (val) {
          return val + "%"
          }
          },
          x: {
          formatter: function (val) {
          return val + "Year Students"
          }
          }
          },
          fill: {
               opacity: 1
          },
          legend: {
               position: 'bottom',
               horizontalAlign: 'center',
               offsetY: 15,
               height: 40,
               }
          };

     var chartElement = new ApexCharts(document.querySelector("#chart"), options);
     chartElement.render();
</script>

</body>
</html>




<?php 
     }else{
          header("Location: index.php");
          exit();
}
?>

