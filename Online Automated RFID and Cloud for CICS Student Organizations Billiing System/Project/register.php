<?php
include 'db_conn.php';
?>
<!DOCTYPE html>
<html>
<style>
	body{
		display: block;
		position: relative;
	}
</style>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
	<title>Student Registration</title>
	<link rel="stylesheet" href="register.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&amp;display=swap" rel="stylesheet">
</head>
<body scroll="no">
	<nav class="reg_topnav">
		<div id="back">
		<i class="fa-solid fa-arrow-left"></i>
            <a href="logout.php">BACK</a><!--PALTAN MO NALANG KUNG SAN BABALIK HAHAH-->
        </div>
	</nav>
	<main class="register_dash">
		<div class="reg_div">
			<div class="reg_title">
				<h2 class="reg_h">CICS<span><sup>+PORTAL</sup></span></h2>
			</div>
			<form  class="form" action="register.php" method="POST">
				
				<input class="input" id="rsrcode" type="text" name="rsrcode" required oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="8">
				<label class="rsrcode" for="rsrcode">Sr-Code</label>
				<br>
				<input class="input" id="rfirstname" type="text" name="rfirstname" required/>
				<label class="rfirstname" for="rfirstname">First Name</label>
				<br>
				<input class="input" id="rlastname"  type="text" name="rlastname" required/>
				<label class="rlastname" for="rlastname">Last Name</label>
				<br>
				<div class="mns">
					<input class="input m_name" id="rmiddlename"  type="text" name="rmiddlename" required/>
					<label class="rmiddlename" for="rmiddlename">Middle Name</label>
					
					<select id="rsuffix" class="input s_name" onchange="suf()">
						<option hidden></option>
						<option value ="Jr."> Jr.</option>
						<option value ="II">II</option>
						<option value ="III">III</option>
					</select>
					<label class="rsuffix" for ="rsuffix">Suffix</label><br>
				</div>
				<br>

				<input class="input" id="remail"  type="email" name="remail" required>
				<label class="remail" for="remail">Email Address</label>
				<br>
				<div class="sc_details">
					<select id = "ryear" class="input sc_input" required onchange="yr()">
						<option hidden></option>
						<option value="1st">1st</option>
						<option value="2nd">2nd</option>
						<option value="3rd ">3rd</option>
						<option value="4th">4th</option>
					</select>
					<label class= "ryear" for="ryear">Year</label>

					<select id="rprogram" class="input sc_input" required onchange="pr()">
						<option></option> 
						<option value="BS in Information Technology">BSIT</option>
						<option value="BS in Computer Sciences">BSCS</option>
					</select>
					<label  class="rprogram" for="rprogram">Program</label>

					<input class="input sc_input" id="rsection"  type="text" name="rsection" required>
					<label class="rsection" for="rsection">Section</label>
				</div>
	
				<input class="rbtn" type="submit"  id="register" name="create" value="REGISTER">
				

				<input type="text" id="sfhidden" value="" name="sfhidden" hidden/>
				<input type="text" id="yrhidden" value="" name="yrhidden" hidden/>
				<input type="text" id="prhidden" value="" name="prhidden" hidden/>
				<input type="text" id="pwhidden" value="" name="pwhidden" hidden/>
				
				<script>

					function yr() {
						year = document.getElementById("ryear").value;
						document.getElementById("yrhidden").value = year;
						}
					function pr() {
						program = document.getElementById("rprogram").value;
						document.getElementById("prhidden").value = program;
						}
					function suf(){
						program = document.getElementById("rsuffix").value;
						document.getElementById("sfhidden").value = program;
						}
				</script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

		<script>
	 		$(function(){
                                $('#register').click(function(e){
                                    
                                    var valid = this.form.checkValidity();
                                    

                                    if(valid){
                                    
                                    var srcode =  $('#rsrcode').val();
									var firstname =  $('#rfirstname').val();
									var lastname =  $('#rlastname').val();
									var middlename = $('#rmiddlename').val();
									var suffix =  $('#sfhidden').val();
									var email =  $('#remail').val();
									var year =  $('#yrhidden').val();
									var program =  $('#prhidden').val();
									var section =  $('#rsection').val();


                                        e.preventDefault();	

                                        $.ajax({
                                            type: 'POST',
                                            url: 'registerprocess.php',
                                            data: {srcode:srcode,firstname:firstname,lastname:lastname,middlename:middlename,suffix:suffix,email:email,year:year,program:program,section:section},
                                            success: function(data){
                                            Swal.fire({
                                                        'title': 'System Message',
                                                        'text': data,
														 'icon': 'success',
                                                        'type': 'success'
                                                        }).then(function(){ 
															window.location.href = "logout.php";

                                                }
                                                );
                                                    
                                            },
                                            error: function(data){
                                                Swal.fire({
                                                        'title': 'Errors',
                                                        'text': 'Existing Account Found!.',
                                                        'type': 'error'
														
                                                        })
                                            }
                                        });
                                        
                                        
                                    }else{
                                        
                                    }
                                });		

                            });
                              
	
		</script>
	</form>
</div>

</body>
</html>
