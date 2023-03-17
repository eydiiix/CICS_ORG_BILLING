<?php
include "db_conn.php";
session_start();           

    
    
     //-- for org showing data
    $intesssql = "SELECT * FROM organizations WHERE username='intess'"; 
    $accesssql = "SELECT * FROM organizations WHERE username='access'";
    $cicssql = "SELECT * FROM organizations WHERE username='cics'";  
    $jpcssql = "SELECT * FROM organizations WHERE username='jpcs'"; 
    //-- state query
    $intessresult= mysqli_query($conn,$intesssql);
    $accessresult=mysqli_query($conn,$accesssql);
    $cicsresult = mysqli_query($conn, $cicssql);
    $jpcsresult= mysqli_query($conn,$jpcssql);
    // -- fetch data
    $icontent = mysqli_fetch_assoc($intessresult);
    $acontent = mysqli_fetch_assoc($accessresult);
    $ccontent = mysqli_fetch_assoc($cicsresult);
    $jcontent = mysqli_fetch_assoc($jpcsresult);
    $hiddensr = $_POST['hiddensrme']; //based on jquery

    $ihidden = $_POST['ihidden'];
    $ahidden = $_POST['ahidden'];
    $chidden = $_POST['chidden'];
    $jhidden = $_POST['jhidden'];

        if(isset($_POST)){
                
                //Student Query
                $studquery = "SELECT * from students where srcode = '$hiddensr'";
                $studqueryresults = mysqli_query($conn,$studquery);
                $studquerycontents = mysqli_fetch_assoc($studqueryresults);

                $ifunds = $icontent['accufunds'] + $icontent['fee'];
                $afunds = $acontent['accufunds'] + $acontent['fee'];
                $cfunds = $ccontent['accufunds'] + $ccontent['fee'];
                $jfunds = $jcontent['accufunds'] + $jcontent['fee'];

                $iavail = $icontent['availfunds'] + $icontent['fee'];
                $aavail = $acontent['availfunds'] + $acontent['fee'];
                $cavail = $ccontent['availfunds'] + $ccontent['fee'];
                $javail = $jcontent['availfunds'] + $jcontent['fee'];
              
              

                $paidisql = "SELECT * FROM intess WHERE srcode ='$hiddensr' AND status='Paid';";
                $paidasql = "SELECT * FROM access WHERE srcode ='$hiddensr' AND status='Paid';";
                $paidcsql = "SELECT * FROM `cics-sc` WHERE srcode ='$hiddensr' AND status='Paid';";
                $paidjsql = "SELECT * FROM jpcs WHERE srcode ='$hiddensr' AND status='Paid';";

                $paidisqlresult = mysqli_query($conn, $paidisql);
                $paidasqlresult = mysqli_query($conn, $paidasql);
                $paidcsqlresult = mysqli_query($conn, $paidcsql);
                $paidjsqlresult = mysqli_query($conn, $paidjsql);
    

                $findisql = "SELECT * FROM intess WHERE srcode ='$hiddensr';";
                $findasql = "SELECT * FROM access WHERE srcode ='$hiddensr';";
                $findcsql = "SELECT * FROM `cics-sc` WHERE srcode ='$hiddensr';";
                $findjsql = "SELECT * FROM jpcs WHERE srcode ='$hiddensr';";

                $findisqlresult = mysqli_query($conn, $findisql);
                $findasqlresult = mysqli_query($conn, $findasql);
                $findcsqlresult = mysqli_query($conn, $findcsql);
                $findjsqlresult = mysqli_query($conn, $findjsql);
               

                $findisqlresultcont = mysqli_fetch_assoc($findisqlresult);
                $findasqlresultcont = mysqli_fetch_assoc($findasqlresult);
                $findcsqlresultcont = mysqli_fetch_assoc($findcsqlresult);
                $findjsqlresultcont = mysqli_fetch_assoc($findjsqlresult);

                $findsql = "SELECT * FROM students WHERE srcode ='$hiddensr';";
                $findsqlresult = mysqli_query($conn, $findsql);
                $findsqlresultcont = mysqli_fetch_assoc($findsqlresult);

                $useriorg = $icontent['username'];
                $useraorg = $acontent['username'];
                $usercorg = $ccontent['username'];
                $userjorg = $jcontent['username'];
                
                $studyear = strval($findsqlresultcont['year']);
                
                
                if(empty($hiddensr)){
                echo "none";

                } elseif(!empty($hiddensr)) {


                if($studquerycontents['program']=='BS in Information Technology'){


                if($ihidden == $icontent['fee']){
                    if (mysqli_num_rows($paidisqlresult) == 1) {
                           
                            
                        } else {
                         if (mysqli_num_rows($findisqlresult) == 0) {

                             $ijoinsql = "INSERT INTO `intess` (`username`, `srcode`, `year`, `status`) VALUES ('$useriorg','$hiddensr','$studyear','Paid')";
                             $iaccavasql = "UPDATE `organizations` SET `accufunds`='$ifunds',`availfunds`='$iavail' WHERE username = 'intess'";
                             $ijoinsqlresults = mysqli_query($conn, $ijoinsql);
                             $iaccavasqlresults = mysqli_query($conn, $iaccavasql);
                            
                          
                              
                        } else {
                               $payisql = "UPDATE `intess` SET `status`='Paid' WHERE `srcode`='$hiddensr'";
                              $iaccavasql = "UPDATE `organizations` SET `accufunds`='$ifunds',`availfunds`='$iavail' WHERE username = 'intess'";
                              $payisqlresults = mysqli_query($conn, $payisql);
                              $iaccavasqlresults = mysqli_query($conn, $iaccavasql);
                                echo "INTESS MEMBER PAID";
                                
                              
                         }
                     }
                }

            }
            if($studquerycontents['program']=='BS in Computer Sciences'){
                if($ahidden == $acontent['fee']){
                    if (mysqli_num_rows($paidasqlresult) == 1) {
                            echo "ACCESS PAID";
                           
                           
                        } else {
                         if (mysqli_num_rows($findasqlresult) == 0) {

                             $ajoinsql = "INSERT INTO `access` (`username`, `srcode`, `year`, `status`) VALUES ('$useraorg','$hiddensr','$studyear','Paid')";
                             $aaccavasql = "UPDATE `organizations` SET `accufunds`='$afunds',`availfunds`='$aavail' WHERE username = 'access'";
                             $ajoinsqlresults = mysqli_query($conn, $ajoinsql);
                             $aaccavasqlresults = mysqli_query($conn, $aaccavasql);
                            echo "STudent Access Created";
                            
                             
                        } else {
                              $payasql = "UPDATE `access` SET `status`='Paid' WHERE `srcode`='$hiddensr'";
                              $aaccavasql = "UPDATE `organizations` SET `accufunds`='$afunds',`availfunds`='$aavail' WHERE username = 'access'";
                              $payasqlresults = mysqli_query($conn, $payasql);
                              $aaccavasqlresults = mysqli_query($conn, $aaccavasql);
                                echo "ACCESS MEMBER PAID";
                                
                              
                         }
                     }
                }
            }

                if($chidden == $ccontent['fee']){
                    if (mysqli_num_rows($paidcsqlresult) == 1) {
                            echo "CICS PAID";
                           
                        } else {
                         if (mysqli_num_rows($findcsqlresult) == 0) {
                             $cjoinsql = "INSERT INTO `cics-sc` (`username`, `srcode`, `year`, `status`) VALUES ('$usercorg','$hiddensr','$studyear','Paid')";
                             $caccavasql = "UPDATE `organizations` SET `accufunds`='$cfunds',`availfunds`='$cavail' WHERE username = 'cics'";
                             $cjoinsqlresults = mysqli_query($conn, $cjoinsql);
                             $caccavasqlresults = mysqli_query($conn, $caccavasql);
                            echo "STudent CICS Created";
                            
                              
                        } else {
                              $paycsql = "UPDATE `cics-sc` SET `status`='Paid' WHERE `srcode`='$hiddensr'";
                              $caccavasql = "UPDATE `organizations` SET `accufunds`='$cfunds',`availfunds`='$cavail' WHERE username = 'cics'";
                              $paycsqlresults = mysqli_query($conn, $paycsql);
                              $aaccavasqlresults = mysqli_query($conn, $caccavasql);
                                echo "CICS MEMBER PAID";
                              
                         }
                     }
                }
                

                if($jhidden == $jcontent['fee']){
                    if (mysqli_num_rows($paidjsqlresult) == 1) {
                            echo "JPCS PAID";
                           
                        } else {
                         if (mysqli_num_rows($findjsqlresult) == 0) {
                             $jjoinsql = "INSERT INTO `jpcs` (`username`, `srcode`, `year`, `status`) VALUES ('$userjorg','$hiddensr','$studyear','Paid')";
                             $jaccavasql = "UPDATE `organizations` SET `accufunds`='$jfunds',`availfunds`='$javail' WHERE username = 'jpcs'";
                             $jjoinsqlresults = mysqli_query($conn, $jjoinsql);
                             $jaccavasqlresults = mysqli_query($conn, $jaccavasql);
                            echo "STudent JPCS Created";
                             
                              
                        } else {
                              $payjsql = "UPDATE `jpcs` SET `status`='Paid' WHERE `srcode`='$hiddensr'";
                              $jaccavasql = "UPDATE `organizations` SET `accufunds`='$jfunds',`availfunds`='$javail' WHERE username = 'jpcs'";
                              $payjsqlresults = mysqli_query($conn, $payjsql);
                              $jaccavasqlresults = mysqli_query($conn, $jaccavasql);
                                echo "JPCS MEMBER PAID";
                               
                              
                         }
                     }
                }
                


                }
                
        }else{

        }
                        
?>