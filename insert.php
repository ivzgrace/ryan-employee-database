<?php
require_once('dbconfig.php');
session_start();



   /* check if user logged in */
   $user_check = $_SESSION['login_user'];
   
   $ses_sql = mysqli_query($dbconnect,"select Username from Users where Username = '$user_check' ");
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   
   $login_session = $row['Username'];
   

   if(!isset($_SESSION['login_user'])){
      header("location:login.php");
   }
   /* end of checking */
if(isset($_POST['submit'])){

    $lname = $_POST['lname'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $phone = $_POST['contact'];
    $hiredate = $_POST['hiredate'];


  if(empty($lname) && empty($fname) && empty($dob)){
    header("location:entry.php");
  }else{


     
      $result = mysqli_query($dbconnect,"SELECT * FROM Employee WHERE (lastname = '".$lname."' AND firstname = '".$fname."') AND bdate ='".$dob."'");
      echo $result->num_rows;
      if ($result->num_rows === 0) {
        die($dbconnect->error);
      }else{


        if ($result->num_rows > 0) {
          $_SESSION['fname'] = $fname;
          $_SESSION['lname'] = $lname;
          $_SESSION['bday'] = $dob; 
           echo "Duplicate Employee <a href='update.php'>Update Employee Record</a>";
           // do something to alert user about non-unique email
        } else {
          /*$result2 = "INSERT IGNORE INTO Employee (firstname, midname, lastname, email, phone, hiredate, bdate, emp_status) 
          	VALUES ('".$fname."', '".$mname."', '".$lname."', '".$email."', '".$phone."', '".$hiredate."','".$dob."', '1')";

          if ($dbconnect->query($result2) === false) {
          	echo "SQL error:".$dbconnect->error;}
          else{
          	$empid = "EPID".date('my').$dbconnect->insert_id;
          	$empidresult = "UPDATE Employee SET empid='".$empid."' WHERE id='".$dbconnect->insert_id."'";

          	if ($dbconnect->query($empidresult) === TRUE) {
            echo " Record added successfully <a href='view.php'>View Employees</a>";
        	} else {
        	    echo "Error adding record: " . $dbconnect->error;
        	}
          }*/
        }

      }
  }

}

mysqli_close($dbconnect);

?>