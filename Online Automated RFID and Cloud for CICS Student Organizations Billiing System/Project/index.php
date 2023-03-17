<!DOCTYPE html>
<html>
<head>
	<title>LOGIN</title>
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
	<link rel="stylesheet" href="style.css">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<script type="text/javascript" src="callback.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.24/sweetalert2.all.js"></script>
	
</head>
<body>

	<div class="page login_page">
		<div class="form">
			<div class="form_photo" >
				<div class="photo_image">
				</div>
			</div>
			<div class="form_input">
				<form id="form" class="forms" action="login.php" method="post">
					<h2 class="login_h">CICS<span><sup>+PORTAL</sup></span></h2>
					<input type="text" id="uname" required class="input" name="uname" require  oninvalid="this.setCustomValidity('Please enter your email here!')"oninput="this.setCustomValidity('')"><br>
					<label for="uname"  class="input-label uname-label">Username</label>
					<input type="password" id="pass" required class="input" name="password" require  oninvalid="this.setCustomValidity('Please enter your password here!')"oninput="this.setCustomValidity('')"><br>
					<label for="password" class="input-label pass-label">Password</label>
					<div class="g-recaptcha" data-sitekey="6LfkY_4iAAAAADabBMp6RdMpoz6iiw_6yI5-Qqh_" data-callback="callback" data-expired-callback="recaptchaExpired"  ></div>
					<div class="btn_container">
						<button id="submit-button" class="submit_btn" type="submit" disabled>LOGIN</button>
					</div>
					<div class="signup_div">
						<a href = "register.php" target="_self" >Create an account</a>
					</div>
					<!-- <script>
						   $(function(){
                                $('#submit-button').click(function(e){
                                    
                                    var valid = this.form.checkValidity();
                                    

                                    if(valid){
                                    
                                    var uname =  $('#uname').val();
                                    var pass =  $('#pass').val();
                                    
            
                                        e.preventDefault();	
										$.ajax({
                                            type: 'POST',
                                            url: 'login.php',
                                            data: {uname: uname, pass:pass},
                                            success: function(data){
                                            Swal.fire({
                                                        'title': 'Success',
                                                        'text': 'Done!',
                                                        'type': 'success'
                                                        
                                                        }).then(function(){ 
                                                
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

							});
					</script> -->
					
				</form>
				<script type="text/javascript">
      			function callback() {
        		const submitButton = document.getElementById("submit-button");
        		submitButton.removeAttribute("disabled");
      			}
				function recaptchaExpired(){
					const sbtn = document.getElementById("submit-button");
					sbtn.setAttribute("disabled");
    			}
    			</script>
			
	
			</div>
		</div>
	</div>

</body>
</html>
