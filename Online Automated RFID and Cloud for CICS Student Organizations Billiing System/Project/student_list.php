<?php  
 $connect = mysqli_connect("localhost", "root", "", "cics");  
 $query ="SELECT `students`.`srcode` as `srcode`,
 `students`.`lname` as `lname` ,
 `students`.`fname` as `fname`,
 `students`.`mname` as `mname`,
 `students`.`section` as `section`,
 `students`.`year` as `year`,  
 `cics-sc`.`status` as `cics-sc`,
 `intess`.`status` as `intess`,
 `access`.`status` as `access`,
 `jpcs`.`status` as `jpcs`
 FROM `students`
 INNER JOIN `cics-sc` ON  `cics-sc`.`srcode` = `students`.`srcode`
 LEFT OUTER JOIN `intess` ON  `intess`.`srcode` = `students`.`srcode`
 LEFT OUTER JOIN `access` ON `access`.`srcode` = `students`.`srcode`
 LEFT OUTER JOIN `jpcs` ON `jpcs`.`srcode`= `students`.`srcode`";  
 $result = mysqli_query($connect, $query);  
 ?>  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="list.css">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
    <title>CICS PORTAL - xStudent List</title>  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>            
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" /> <title>CICS-Student List</title>
</head>
<body>
    <nav class="back_topnav">
		<div id="back">
		<i class="fa-solid fa-arrow-left"></i>
            <a href="admin_dashboard.php">BACK</a><!--PALTAN MO NALANG KUNG SAN BABALIK HAHAH-->
        </div>
	</nav>
    <main class="list_page">
        <div id="list_st">
        <div class="table-responsive">  
                    <table id="employee_data" class="table table-striped table-bordered">  
                            <thead>  
                                <tr>  
                                    <td>SR-CODE</td>  
                                    <td>Lastname</td>  
                                    <td>Firstname</td>  
                                    <td>Middlename</td>  
                                    <td>Section</td>  
                                    <td>Year</td>  
                                    <td>CICS-SC</td>  
                                    <td>INTESS</td>  
                                    <td>ACCESS</td>  
                                    <td>JPCS</td>  
                                </tr>  
                            </thead>  
                        <?php  
                        while($row = mysqli_fetch_array($result))  
                        {  
                            echo '  
                                <tr>  
                                    <td>'.$row["srcode"].'</td>  
                                    <td>'.$row["lname"].'</td>  
                                    <td>'.$row["fname"].'</td>  
                                    <td>'.$row["mname"].'</td>  
                                    <td>'.$row["section"].'</td>  
                                    <td>'.$row["year"].'</td>  
                                    <td>'.$row["cics-sc"].'</td>  
                                    <td>'.$row["intess"].'</td>  
                                    <td>'.$row["access"].'</td>  
                                    <td>'.$row["jpcs"].'</td>  
                                </tr>  
                                ';  
                            }  
                        ?>  
                    </table>  
                </div> 
    </main>
</body>
</html>

<script>  
    $(document).ready(function(){  
    $('#employee_data').DataTable();  });  
</script>

