<?php 
session_start();
include "db_conn.php";

if (isset($_SESSION['username'])) {
    //-- for cics admin
    $username = $_SESSION['username'];
    $adminsql = "SELECT * FROM organizations WHERE username='$username'"; 
	$adminresult = mysqli_query($conn, $adminsql);
    $admincontent = mysqli_fetch_assoc($adminresult);
    //-- for org showing data
    $intesssql = "SELECT * FROM organizations WHERE username='intess'"; 
    $accesssql = "SELECT * FROM organizations WHERE username='access'"; 
    $jpcssql = "SELECT * FROM organizations WHERE username='jpcs'"; 
    //-- state query
    $intessresult= mysqli_query($conn,$intesssql);
    $accessresult=mysqli_query($conn,$accesssql);
    $jpcsresult= mysqli_query($conn,$jpcssql);
    // -- fetch data
    $icontent = mysqli_fetch_assoc($intessresult);
    $acontent = mysqli_fetch_assoc($accessresult);
    $jcontent = mysqli_fetch_assoc($jpcsresult);

    // -- BSIT and BSCS Totality
    $result=mysqli_query($conn,"SELECT count(*) as members from `students`");
    $data=mysqli_fetch_assoc($result);
    // Percentage 
    $ppercent=mysqli_query($conn,"SELECT count(*) as paid from `cics-sc` WHERE status = 'Paid'");
    $upercent=mysqli_query($conn,"SELECT count(*) as totalstudents from `cics-sc`");
    $pcpercent=mysqli_fetch_assoc($ppercent);
    $ucpercent=mysqli_fetch_assoc($upercent);

    $paidpercent = (intval($pcpercent['paid'])/intval($ucpercent['totalstudents'])) * 100;
    $paidpercent2dp = round($paidpercent, 2);

    $decreasepercent = ((((intval($admincontent['accufunds']) - intval($admincontent['availfunds']))) / (intval($admincontent['accufunds']))) * 100);
    $decreasepercent2dp = round($decreasepercent, 2);
    
    $totalpercentage = (((intval($admincontent['accufunds']))/((intval($admincontent['fee'])) * (intval($data['members']))))*100);
    $totalpercentage2dp = round($totalpercentage,2)
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
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
                                <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Admin Dashboard</title>
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
                    <li><i class="fa-solid fa-sitemap"></i><a href="#org">Organizations</a></li>
                    <li><i class="fa-solid fa-id-card"></i><a href="#mfc">Membership</a></li>
                    <li><i class="fa-solid fa-edit"></i><a href="#edit_fee">Settings</a></li>
                    <li><i class="fa-solid fa-rectangle-list"></i><a href="student_list.php">Member List</a></li>
                    <li><i class="fa-solid fa-arrow-right-from-bracket"></i><a href="logout.php">Logout</a></li>
                </ul>
            </div>             
        </div>
        <div class="main_dash">
            <div id="spacer"></div>
            <!-- HOME -->
           
            <section  id="dashboard">
                <div class="dash_box2 dash_navigation_title">
                    <h1>DASHBOARD</h1>
                    
                </div>
                <div class="dash_box1">
                    <div class="d_bx1 bx_shdw">
                        <div class="dbx">
                                <h2>Members</h2>
                                <h5>| BSIT & BSCS</h5>
                        </div>
                        <div class="dbx_content">
                                <i id="member_icon" class="fa-solid fa-users"></i>
                                <div class="dbx_info">
                                    <h3><?php echo $ucpercent['totalstudents']?></h3> 
                                    <h5><span><?php echo $paidpercent2dp?>%</span> paid</h5>
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
                                    <h3><?php echo $admincontent['availfunds']?></h3>
                                    <h5><span><?php echo $decreasepercent2dp;?>%</span> decrease</h5>
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
                                <h3><?php echo $admincontent['accufunds']?></h3>
                                <h5><span><?php echo $totalpercentage2dp;?>%</span> of total</h5>
                        </div>
                    </div>
                </div>
                <div class=" dash_box3 bx_shdw" id="box3">
                    <div class="dbx3 dbx">
                        <h2>Report</h2>
                        <h5>| Analytics</h5>
                    </div>

                    <div class="chart_div" id="chart"></div>
                </div>
            </section>
            <!-- OTHER ORGANIZATIONS -->
            <section id="org">
                <?php
                 //--members from organizations that were paid
                $intessmembers = mysqli_query($conn,"SELECT count(*) as intessmembers from intess");
                $intessmembersdata = mysqli_fetch_assoc($intessmembers);
                $intesstotal = (intval($intessmembersdata['intessmembers']))*(intval($icontent['fee']));

                $accessmembers = mysqli_query($conn,"SELECT count(*) as accessmembers from access ");
                $accessmembersdata = mysqli_fetch_assoc($accessmembers);
                $accesstotal = (intval($accessmembersdata['accessmembers']))*(intval($acontent['fee']));


                $jpcsmembers = mysqli_query($conn,"SELECT count(*) as jpcsmembers from jpcs");
                $jpcsmembersdata = mysqli_fetch_assoc($jpcsmembers);
                $jpcstotal = (intval($jpcsmembersdata['jpcsmembers']))*(intval($jcontent['fee']));
                ?>
                <div class="dash_box2 dash_navigation_title">
                <h1>ORGANIZATIONS</h1>
                </div>
                <div class="dash_box2 bx_shdw">
                    <div class="dbx">
                                <h2><?php echo strtoupper($icontent['username']);?></h2>
                                <h5>| Information</h5>
                    </div>
                    <div class="org_fund_box dbx_content">
                        <img id="org_icon_img" src="image/<?php echo $icontent['filename'];?>" alt="">
                        <div class="org_dbx dbx2 dbx_info">
                                <h3>₱ <?php echo $icontent['accufunds']?><span> / ₱ <?php echo $intesstotal;?></span></h3>
                                <h5><span><?php echo $intessmembersdata['intessmembers']?></span> members</h5>
                        </div>  
                    </div>
                </div>
                <div class="dash_box2 bx_shdw">
                    <div class="dbx">
                                <h2><?php echo strtoupper($acontent['username']);?></h2>
                                <h5>| Information</h5>
                    </div>
                    <div class="org_fund_box dbx_content">
                        <img id="org_icon_img" src="image/<?php echo $acontent['filename'];?>" alt="">
                        <div class="org_dbx dbx2 dbx_info">
                                <h3>₱ <?php echo $acontent['accufunds']?><span> / ₱ <?php echo $accesstotal;?></span></h3>
                                <h5><span><?php echo $accessmembersdata['accessmembers']?></span> members</h5>
                        </div>  
                    </div>
                </div>
                <div class="dash_box2 bx_shdw">
                    <div class="dbx">
                                <h2><?php echo strtoupper($jcontent['username']);?></h2>
                                <h5>| Information</h5>
                    </div>
                    <div class="org_fund_box dbx_content">
                        <img id="org_icon_img" src="image/<?php echo $jcontent['filename'];?>" alt="">
                        <div class="org_dbx dbx2 dbx_info">
                                <h3>₱ <?php echo $jcontent['accufunds']?><span> / ₱ <?php echo $jpcstotal;?></span></h3>
                                <h5><span><?php echo $jpcsmembersdata['jpcsmembers']?></span> members</h5>
                        </div>  
                    </div>
                </div>
            </section>
            <!-- MEMBERSHIP FEE COLLECTION -->
            <section id="mfc">
                <div class="dash_box2 dash_navigation_title">
                    <h1>MEMBERSHIP FEE COLLECTION</h1>
                </div>
                <div class="dash_box2 bx_shdw srch_card">
                    <div id="srch_input_div">
                        <form action="" method="post">
                            <input id="search_inpt" type="text" required name="srcode"  oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="8"/>
                            <input id="search_btn" type="submit" value="SEARCH"/>
                            <label for="srcode" id="search_inpt_lbl">ENTER SR-CODE . . </label>
                        </form>
                    </div>
                    <div class="student_card">
                        <div id="card_info" class="crd_box">
                            <div id="crd_logo">
                                <div id="img_div">
                                    
                                </div>
                            </div>
                            <h4 id="st_name">XXXXXXXX X XXXXX XXXXX</h4>
                            <div id="section_box">
                                <h6>SECTION:</h6>
                                <h4 id="section">XX-XX-XXXX</h4>
                            </div>
                            <h1 id="sr_code">00-00000</h1>
                        </div>
                        <div id="card_img" class="crd_box">
                            <div id="crd_ttl">
                                <h1>CICS</h1>
                                <h4>MEMBER CARD</h4>
                            </div>
                            <div id="st_img">
                                <img id="imgdef" src="image/defaultimg.jpg" alt="">
                            </div>
                        </div>
                    </div>  
                    <div id="payment_div">
                        <form action="admin_dashboard.php" method="post" id="fees">
                            <input disabled class="checkbox" id="intess" type="checkbox" name="org_fee[]" onclick="IntessFunction()" value="<?php echo ($icontent['fee']);?>" />
                            <label class="checkbox_lbl"><?php echo strtoupper($icontent['username']);?> (₱ <?php echo ($icontent['fee']);?>)</label>
                            <input disabled class="checkbox" id="access" type="checkbox" name="org_fee[]" onclick="AccessFunction()" value="<?php echo ($acontent['fee']);?>" />
                            <label class="checkbox_lbl"><?php echo strtoupper($acontent['username']);?>(₱ <?php echo ($acontent['fee']);?>)</label>
                            <input disabled class="checkbox" id="cics-sc" type="checkbox" name="org_fee[]" onclick="CicsFunction()" value="<?php echo ($admincontent['fee']);?>" />
                            <label class="checkbox_lbl"><?php echo strtoupper($admincontent['username']);?>-SC (₱ <?php echo ($admincontent['fee']);?>)</label>
                            <input disabled class="checkbox" id="jpcs" type="checkbox" name="org_fee[]" onclick ="JpcsFunction()" value="<?php echo ($jcontent['fee']);?>" />
                            <label class="checkbox_lbl"><?php echo strtoupper($jcontent['username']);?> (₱ <?php echo ($jcontent['fee']);?>)</label><br/>
                            
                            <input type="hidden" value="0" id="ihidden" name = "ihidden"/>
                            <input type="hidden" value="0" id="ahidden" name = "ahidden"/>
                            <input type="hidden" value="0" id="chidden" name = "chidden"/>
                            <input type="hidden" value="0" id="jhidden" name = "jhidden"/>
                            <input type="hidden" value="<?php echo $icontent['accufunds']?>" id="iaccu" name="iaccu"/>
                            <input type="hidden" value="<?php echo $icontent['availfunds']?>" id="iavail" name="iavail"/>
                            <input type="hidden" value="<?php echo $acontent['accufunds']?>" id="aaccu" name="aaccu"/>
                            <input type="hidden" value="<?php echo $acontent['availfunds']?>" id="aavail" name="aavail"/>
                            <input type="hidden" value="<?php echo $admincontent['accufunds']?>" id="caccu" name="caccu"/>
                            <input type="hidden" value="<?php echo $admincontent['availfunds']?>" id="cavail" name="cavail"/>
                            <input type="hidden" value="<?php echo $jcontent['accufunds']?>" id="jaccu" name="jaccu"/>
                            <input type="hidden" value="<?php echo $jcontent['availfunds']?>" id="javail" name="javail"/>
                            
                    
                            <!-- changing value of hidden input -->
                            <script>
                               
                                var Icheckbox = document.getElementById("intess");
                                var Acheckbox = document.getElementById("access");
                                var Ccheckbox = document.getElementById("cics-sc");
                                var Jcheckbox = document.getElementById("jpcs");

                                var iaccu = parseInt(document.getElementById('iaccu').value);
                                var aaccu = parseInt(document.getElementById('aaccu').value);
                                var caccu = parseInt(document.getElementById('caccu').value);
                                var jaccu = parseInt(document.getElementById('jaccu').value);

                                var iavail = parseInt(document.getElementById('iavail').value);
                                var aavail = parseInt(document.getElementById('aavail').value);
                                var cavail = parseInt(document.getElementById('cavail').value);
                                var javail = parseInt(document.getElementById('javail').value);

                             function IntessFunction(){
                                if(Icheckbox.checked==true){
                                    parseInt(document.getElementById("ihidden").value="<?php echo $icontent['fee']?>");
                                    var ihidden = parseInt(document.getElementById('ihidden').value);
                                    var ahidden = parseInt(document.getElementById('ahidden').value);
                                    var chidden = parseInt(document.getElementById('chidden').value);
                                    var jhidden = parseInt(document.getElementById('jhidden').value);
                                    var total =  ihidden+ahidden+chidden+jhidden;
                                    document.getElementById('total').innerHTML = "₱" + total;

                                    var totalaccu = ihidden + iaccu;
                                    var totalavail = ihidden + iavail;
                                    document.getElementById('iaccu').value = totalaccu;
                                    document.getElementById('iavail').value = totalavail;
                                    
                                 }else if(Icheckbox.checked==false){
                                    document.getElementById("ihidden").value="0";
                                    var ihidden = parseInt(document.getElementById('ihidden').value);
                                    var ahidden = parseInt(document.getElementById('ahidden').value);
                                    var chidden = parseInt(document.getElementById('chidden').value);
                                    var jhidden = parseInt(document.getElementById('jhidden').value);
                                    var total =  ihidden+ahidden+chidden+jhidden;
                                    document.getElementById('total').innerHTML = "₱" + total;

                                    document.getElementById('iaccu').value = parseInt(<?php echo $icontent['accufunds']?>);
                                    document.getElementById('iavail').value = parseInt(<?php echo $icontent['availfunds']?>);
                                 }
                                }
                                function AccessFunction(){
                                    if(Acheckbox.checked==true){
                                        document.getElementById("ahidden").value="<?php echo $acontent['fee']?>";
                                        var ihidden = parseInt(document.getElementById('ihidden').value);
                                        var ahidden = parseInt(document.getElementById('ahidden').value);
                                        var chidden = parseInt(document.getElementById('chidden').value);
                                        var jhidden = parseInt(document.getElementById('jhidden').value);
                                        var total =  ihidden+ahidden+chidden+jhidden;
                                        document.getElementById('total').innerHTML = "₱" + total;

                                        var totalaccu = ahidden + aaccu;
                                        var totalavail = ahidden + aavail;
                                        document.getElementById('aaccu').value = totalaccu;
                                        document.getElementById('aavail').value = totalavail;
                                    }else if(Acheckbox.checked==false){
                                        document.getElementById("ahidden").value="0";
                                        var ihidden = parseInt(document.getElementById('ihidden').value);
                                        var ahidden = parseInt(document.getElementById('ahidden').value);
                                        var chidden = parseInt(document.getElementById('chidden').value);
                                        var jhidden = parseInt(document.getElementById('jhidden').value);
                                        var total =  ihidden+ahidden+chidden+jhidden;
                                        document.getElementById('total').innerHTML = "₱" + total;

                                        document.getElementById('aaccu').value = parseInt(<?php echo $acontent['accufunds']?>);
                                        document.getElementById('aavail').value = parseInt(<?php echo $acontent['availfunds']?>);
                                    }
                                    }
                                function CicsFunction(){
                                    if(Ccheckbox.checked==true){
                                        document.getElementById("chidden").value="<?php echo $admincontent['fee']?>";
                                        var ihidden = parseInt(document.getElementById('ihidden').value);
                                        var ahidden = parseInt(document.getElementById('ahidden').value);
                                        var chidden = parseInt(document.getElementById('chidden').value);
                                        var jhidden = parseInt(document.getElementById('jhidden').value);
                                        var total =  ihidden+ahidden+chidden+jhidden;
                                        document.getElementById('total').innerHTML ="₱" +  total;

                                        var totalaccu = chidden + caccu;
                                        var totalavail = chidden + cavail;
                                        document.getElementById('caccu').value = totalaccu;
                                        document.getElementById('cavail').value = totalavail;
                                    }else if(Ccheckbox.checked==false){
                                        document.getElementById("chidden").value="0";
                                        var ihidden = parseInt(document.getElementById('ihidden').value);
                                        var ahidden = parseInt(document.getElementById('ahidden').value);
                                        var chidden = parseInt(document.getElementById('chidden').value);
                                        var jhidden = parseInt(document.getElementById('jhidden').value);
                                        var total =  ihidden+ahidden+chidden+jhidden;
                                        document.getElementById('total').innerHTML = "₱" + total;

                                        document.getElementById('caccu').value = parseInt(<?php echo $admincontent['accufunds']?>);
                                        document.getElementById('cavail').value = parseInt(<?php echo $admincontent['availfunds']?>);
                                    }
                                    }
                                function JpcsFunction(){
                                if(Jcheckbox.checked==true){
                                    document.getElementById("jhidden").value="<?php echo $jcontent['fee']?>";
                                    document.getElementById("payment_btn").removeAttribute ("disabled");
                                    var ihidden = parseInt(document.getElementById('ihidden').value);
                                    var ahidden = parseInt(document.getElementById('ahidden').value);
                                    var chidden = parseInt(document.getElementById('chidden').value);
                                    var jhidden = parseInt(document.getElementById('jhidden').value);
                                    var total =  ihidden+ahidden+chidden+jhidden;
                                    document.getElementById('total').innerHTML ="₱" +  total;

                                    var totalaccu = jhidden + jaccu;
                                    var totalavail = jhidden + javail;
                                    document.getElementById('jaccu').value = totalaccu;
                                    document.getElementById('javail').value = totalavail;
                                 }else if(Jcheckbox.checked==false){
                                    document.getElementById("payment_btn").setAttribute ('disabled','');
                                    document.getElementById("jhidden").value="0";
                                    var ihidden = parseInt(document.getElementById('ihidden').value);
                                    var ahidden = parseInt(document.getElementById('ahidden').value);
                                    var chidden = parseInt(document.getElementById('chidden').value);
                                    var jhidden = parseInt(document.getElementById('jhidden').value);
                                    var total =  ihidden+ahidden+chidden+jhidden;
                                    document.getElementById('total').innerHTML ="₱" +  total;

                                    document.getElementById('jaccu').value = parseInt(<?php echo $jcontent['accufunds']?>);
                                    document.getElementById('javail').value = parseInt(<?php echo $jcontent['availfunds']?>);
                                 }
                                }
                           
                            </script>
                            <div id="py_div">
                                <h5>TOTAL:<span id = "total">₱0</span></h5>
                                <input disabled  id="payment_btn" type="submit" name="payme"  value="COLLECT"/>
                                <input type="hidden" id="hiddensr" name="hiddensr"/>
                                

                                <script>
                                //--JQUERY POP-UP THINGY
                                $(function(){
                                $('#payment_btn').click(function(e){
                                    
                                    var valid = this.form.checkValidity();
                                    

                                    if(valid){
                                    
                                    var ihidden =  $('#ihidden').val();
                                    var ahidden =  $('#ahidden').val();
                                    var chidden =  $('#chidden').val();
                                    var jhidden =  $('#jhidden').val();
                                    var hiddensrme = $('#hiddensr').val();
            
                                        e.preventDefault();	
                                    swal.fire({
                                        title: 'Are you sure?',
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
                                            url: 'bills.php',
                                            data: {hiddensrme: hiddensrme, ihidden:ihidden, ahidden:ahidden, chidden:chidden,jhidden:jhidden},
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
                                                        'text': 'There were errors while saving the data.',
                                                        'type': 'error'
                                                       
                                                        }).then(function(){ 
                                                location.reload();
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
                                
                            </div>
                           
                        </form>
                    </div>
                  
                    <?php include "db_conn.php";
                
                        if(isset($_POST['srcode'])){
                            $search = $_POST['srcode'];
                            $sql = "SELECT * FROM students WHERE srcode ='$search';";
                            $msql = "SELECT mname ,  SUBSTR(mname, 1 , 1 ) FROM students ; ";
                            $mresult = $conn->query($msql);
                            $result = $conn->query($sql);

                            $paidisql = "SELECT * FROM intess WHERE srcode ='$search' AND status='Paid';";
                            $paidcsql = "SELECT * FROM `cics-sc` WHERE srcode ='$search' AND status='Paid';";
                            $paidasql = "SELECT * FROM access WHERE srcode ='$search' AND status='Paid';";
                            $paidjsql = "SELECT * FROM jpcs WHERE srcode ='$search' AND status='Paid';";

                            $paidisqlresult = mysqli_query($conn, $paidisql);
                            $paidcsqlresult = mysqli_query($conn, $paidcsql);
                            $paidasqlresult = mysqli_query($conn, $paidasql);
                            $paidjsqlresult = mysqli_query($conn, $paidjsql);
                            

                            if ($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                                if($row['srcode'] == "$search"){
                                    echo '<script>document.getElementById("search_inpt").value = "'.$row['srcode'].'"</script>';
                                    echo '<script>document.getElementById("hiddensr").value = "'.$row['srcode'].'"</script>';
                                    echo '<script>document.getElementById("imgdef").src="./image/'.$row['sPhoto'].'";</script>';
                                    echo '<script>document.getElementById("sr_code").innerHTML="'.$row['srcode'].'"</script>'; 
                                    echo '<script>document.getElementById("st_name").innerHTML="'.$row['lname'].' '.$row['fname'].'" + " " + " '.$row['mname'].'".substr(1,1)+"."+"'.$row['suffix'].'"</script>'; 
                                    echo '<script>document.getElementById("section").innerHTML="'.$row['section'].'"</script>';
                                    echo "<script>document.location.href = 'admin_dashboard.php#mfc';</script>";
                                   
                                   
                                        if(mysqli_num_rows($paidcsqlresult)==1){

                                        }else{
                                            echo "<script>
                                            document.getElementById('cics-sc').checked = true;
                                            document.getElementById('cics-sc').removeAttribute ('disabled');
                                            </script>";
                                            echo '<script>document.getElementById("chidden").value="'.$admincontent['fee'].'"</script>';
                                            echo '<script>document.getElementById("payment_btn").removeAttribute ("disabled");</script>';
                                        }
                                        if(mysqli_num_rows($paidjsqlresult)==1){

                                        }else{
                                            echo "<script>
                                            document.getElementById('jpcs').removeAttribute ('disabled');
                                            </script>";
                                            
                                        }

                                    if($row['program'] == "BS in Information Technology"){

                                        if (mysqli_num_rows($paidisqlresult) == 1) {
                                        
                                        } else{
                                            echo "<script>
                                            document.getElementById('intess').checked = true;
                                            document.getElementById('intess').removeAttribute ('disabled');
                                            </script>";
                                            echo '<script>document.getElementById("ihidden").value="'.$icontent['fee'].'"</script>'; 
                                            echo '<script>document.getElementById("payment_btn").removeAttribute ("disabled");</script>';
                                        }

                                    }else if($row['program'] == "BS in Computer Sciences"){
                                        if (mysqli_num_rows($paidasqlresult) == 1) {
                        
                                        } else{
                                            echo "<script>
                                            document.getElementById('access').checked = true;
                                            document.getElementById('access').removeAttribute ('disabled');
                                            </script>";
                                            echo '<script>document.getElementById("ahidden").value="'.$acontent['fee'].'"</script>'; 
                                            echo '<script>document.getElementById("payment_btn").removeAttribute ("disabled");</script>';
                                        }
                                    }

                                    echo "<script> 
                                    var ihidden = parseInt(document.getElementById('ihidden').value);
                                    var ahidden = parseInt(document.getElementById('ahidden').value);
                                    var chidden = parseInt(document.getElementById('chidden').value);
                                    var jhidden = parseInt(document.getElementById('jhidden').value);
                                    var total =  ihidden+ahidden+chidden+jhidden;
                                    document.getElementById('total').innerHTML = '₱' +  total;
                                    
                                    var iaccu = parseInt(document.getElementById('iaccu').value);
                                    var iavail = parseInt(document.getElementById('iavail').value);
                                    var caccu = parseInt(document.getElementById('caccu').value);
                                    var cavail = parseInt(document.getElementById('cavail').value);
                                    
                                    var totalaccu = ihidden + iaccu;
                                    var totalavail = ihidden + iavail;
                                    var cicstotalaccu = chidden + caccu;
                                    var cicstotalavail = chidden + cavail;

                                    document.getElementById('iaccu').value = totalaccu;
                                    document.getElementById('iavail').value = totalavail;
                                    document.getElementById('caccu').value = cicstotalaccu;
                                    document.getElementById('cavail').value = cicstotalavail;
                            
                                </script>";
                                }else{
                                    echo "<script>
                                            document.getElementById('access').checked = false;
                                            document.getElementById('cics-sc').checked = false;
                                            document.getElementById('intess').disabled = false;    
                                        </script>";
                                    echo '<script>document.getElementById("imgdef").src="./image/defaultimg.png";</script>';
                                    echo '<script>document.getElementById("sr_code").innerHTML="00-00000";</script>'; 
                                    echo '<script>document.getElementById("st_name").innerHTML="XXXXXXXX X XXXXX XXXXX";</script>'; 
                                    echo '<script>document.getElementById("section").innerHTML="XX-XX-XXXX";</script>';
                                    echo "<script>document.location.href = 'admin_dashboard.php#mfc';</script>";
                                }     
                            }
                            }else { ?>
                                <script>
                                    Swal.fire({
                                        icon : 'error',
                                        title : 'System Message',
                                        text : 'Student not found!'

                                    });
                                </script>
                            <?php  echo "<script>

                                        document.location.href = 'admin_dashboard.php#mfc';
                                    </script>";
                                }
                        }

                    ?>      

        </div> 
        </section>
        <div class=" dash_box3 bx_shdw sp" id="box3">
            <div class="dbx3 dbx">
                <h2>Expense</h2>
                <h5>| Invoice </h5>
            </div>
            <form class="desc_div" action="POST">
                <div class="inpt__div">
                    <input type="text" id="invoicetl" name="_title" placeholder="TITLE" class="dv_inptl"  required/>
                    <input type ="hidden" id ="cicsavailfunds" value="<?php echo $admincontent['availfunds']?>"/>
                    <input type ="hidden" id ="cicsuser" value="<?php echo $admincontent['username']?>"/>
                    <input type="text" id="invoiceamt"name="_amount" placeholder="AMOUNT" class="dv_inptr" required oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="8"/>
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
                                    var availfunds =  $('#cicsavailfunds').val();
                                    var orguser =  $('#cicsuser').val();
                                    
            
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
        <!-- EDIT FEE -->
        <section id="edit_fee">
        <div class="dash_box2 dash_navigation_title">
                    <h1>SETTINGS</h1>
                    
                </div>
                <div class="dash_box2 bx_shdw fc_card">
                    <div class="dbx">
                                <h2>UPDATE FEE</h2>
                                <h5>| Membership</h5>
                    </div>
                    <div class="fee_card">
                            <input id="newintess" type="hidden" value="<?php echo $icontent['username'];?>"/>
                            <input id="newaccess" type="hidden" value="<?php echo $acontent['username'];?>"/>
                            <input id="newcics" type="hidden" value="<?php echo $admincontent['username'];?>"/>
                            <input id="newjpcs" type="hidden" value="<?php echo $jcontent['username'];?>"/>
                        <form action="" method="POST">
                            <label class="fee_lbl" for="fee_intess">INTESS</label>
                            <input  class="fee_input" type="text" placeholder="NEW AMOUNT" name="fee_intess" id="new_fee_intess"  oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="8"/>
                            <input id="intess_update" class="fee_update_btn" type="submit" value="UPDATE"/>
                            <script>
                                //--JQUERY POP-UP THINGY
                                $(function(){
                                $('#intess_update').click(function(e){
                                    
                                    var valid = this.form.checkValidity();
                                    

                                    if(valid){
                                    
                                    var orgfee =  $('#newintess').val();
                                    var newfee =  $('#new_fee_intess').val();
                                    
            
                                        e.preventDefault();	
                                    swal.fire({
                                        title: 'Change Intess Value?',
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
                                            url: 'orgupdate.php',
                                            data: {orgfee: orgfee, newfee:newfee},
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
                                                        'icon' :'error',
                                                        'text': 'Input Value',
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
                    <div class="fee_card">
                        <form action="" method="POST">
                            <label class="fee_lbl" for="fee_access">ACCESS</label>
                            <input  class="fee_input" type="text" placeholder="NEW AMOUNT" id="new_fee_access" name="fee_access"  oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="8"/>
                            
                            <input id="access_update" class="fee_update_btn" type="submit" value="UPDATE"/>
                            <script>
                                //--JQUERY POP-UP THINGY
                                $(function(){
                                $('#access_update').click(function(e){
                                    
                                    var valid = this.form.checkValidity();
                                    

                                    if(valid){
                                    
                                    var orgfee =  $('#newaccess').val();
                                    var newfee =  $('#new_fee_access').val();
                                    
            
                                        e.preventDefault();	
                                    swal.fire({
                                        title: 'Change Access Value?',
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
                                            url: 'orgupdate.php',
                                            data: {orgfee: orgfee, newfee:newfee},
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
                    <div class="fee_card">
                        <form action="" method="POST">
                            <label class="fee_lbl" for="fee_cics-sc">CICS-SC</label>
                            <input  class="fee_input" type="text" placeholder="NEW AMOUNT" id="new_fee_cics" name="fee_cics-sc"  oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="8"/>
                            <input id="cics-sc_update" class="fee_update_btn" type="submit" value="UPDATE"/>
                            <script>
                                //--JQUERY POP-UP THINGY
                                $(function(){
                                $('#cics-sc_update').click(function(e){
                                    
                                    var valid = this.form.checkValidity();
                                    

                                    if(valid){
                                    
                                    var orgfee =  $('#newcics').val();
                                    var newfee =  $('#new_fee_cics').val();
                                    
            
                                        e.preventDefault();	
                                    swal.fire({
                                        title: 'Change CICS_SC Value?',
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
                                            url: 'orgupdate.php',
                                            data: {orgfee: orgfee, newfee:newfee},
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
                    <div class="fee_card">
                        <form action="" method="POST">
                            <label class="fee_lbl" for="fee_jpcs">JPCS</label>
                            <input  class="fee_input" type="text" placeholder="NEW AMOUNT" id="new_fee_jpcs" name="fee_jpcs"  oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="8"/>
                            
                            <input id="jpcs_update" class="fee_update_btn" type="submit" value="UPDATE"/>
                            <script>
                                //--JQUERY POP-UP THINGY
                                $(function(){
                                $('#jpcs_update').click(function(e){
                                    
                                    var valid = this.form.checkValidity();
                                    

                                    if(valid){
                                    
                                    var orgfee =  $('#newjpcs').val();
                                    var newfee =  $('#new_fee_jpcs').val();
                                    
            
                                        e.preventDefault();	
                                    swal.fire({
                                        title: 'Change JPCS Value?',
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
                                            url: 'orgupdate.php',
                                            data: {orgfee: orgfee, newfee:newfee},
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
                </div>
            </section>
        </div> 

<!-- SIDE DASH -->
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
                ?>
                <script>
                        Swal.fire({
                                'title': 'Success',
                                'text': 'Image Uploaded Successfully!',
                                'type': 'success'
                                                        
                        });
                </script>
                <?php
                } else {
                    echo "<script>alert('Failed to Upload!')
                    document.location.href = 'admin_dashboard.php';
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
                <h6 class="side_head2"><?php echo $admincontent['orgname']?></h6>
            </div>
            <footer>
                <div id="div_time"></div>
            </footer>
            <?php
                }
            ?>
            
        </div>
    </div>
</main>

<!-- PHP select squery students of CICS Department -->

<?php 
    // Paid Query
    $st1=mysqli_query($conn,"SELECT count(*) as 1stpaid from `cics-sc` WHERE year = '1st' && `status` = 'Paid'");
    $nd1=mysqli_query($conn,"SELECT count(*) as 2ndpaid from `cics-sc` WHERE year = '2nd' && `status` = 'Paid'");
    $rd1=mysqli_query($conn,"SELECT count(*) as 3rdpaid from `cics-sc` WHERE year = '3rd' && `status` = 'Paid'");
    $th1=mysqli_query($conn,"SELECT count(*) as 4thpaid from `cics-sc` WHERE year = '4th' && `status` = 'Paid'");
    $st1pd=mysqli_fetch_assoc($st1);
    $nd1pd=mysqli_fetch_assoc($nd1);
    $rd1pd=mysqli_fetch_assoc($rd1);
    $th1pd=mysqli_fetch_assoc($th1);
    // Unpaid Query
    $st2=mysqli_query($conn,"SELECT count(*) as 1stpaid from `cics-sc` WHERE year = '1st' && `status` = 'Unpaid'");
    $nd2=mysqli_query($conn,"SELECT count(*) as 2ndpaid from `cics-sc` WHERE year = '2nd' && `status` = 'Unpaid'");
    $rd2=mysqli_query($conn,"SELECT count(*) as 3rdpaid from `cics-sc` WHERE year = '3rd' && `status` = 'Unpaid'");
    $th2=mysqli_query($conn,"SELECT count(*) as 4thpaid from `cics-sc` WHERE year = '4th' && `status` = 'Unpaid'");
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
        return val 
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
<script src="http://code.jquery.com/jquery-latest.js"></script>
            <script>
                $(document).ready(function(){
		        $("#div_time").load("time.php");
                setInterval(function() {
                $("#div_time").load("time.php");
                }, 1000);
            });
</script>

</body>
</html>


<?php 
    }else{
        header("Location: index.php");
        exit();
}
?>