<?php 
include 'Includes/dbcon.php';
session_start();
?>
<?php
$query = "SELECT regStat FROM tbltemp";
$rs = $conn->query($query);
$rows = $rs->fetch_assoc();
if($rows['regStat'] == "1"){

if(isset($_POST['register'])){
    
  $firstName=$_POST['firstName'];
  $lastName=$_POST['lastName'];
  $admissionNumber=$_POST['admissionNumber'];
  $branchId=$_POST['branchId'];
  $classId=$_POST['classId'];
  $query = "SELECT Id from tblbatch where classId = '$classId'";
  $rs = $conn->query($query);
	$rows = $rs->fetch_assoc();
	$batchId = $rows['Id'];
   
   
    $query=mysqli_query($conn,"select * from tblstudents where admissionNumber ='$admissionNumber'");
    $ret=mysqli_fetch_array($query);

    if($ret > 0){ 

        $statusMsg = "<div class='alert alert-danger' role='alert'>You Already Exist!</div>";
    }
    else{

    $query=mysqli_query($conn,"insert into tblstudents(firstName,lastName,admissionNumber,branchId,classId,batchId) 
    value('$firstName','$lastName','$admissionNumber','$branchId','$classId','$batchId')");

    if ($query) {
        
        $statusMsg = "<div class='alert alert-success' role='alert'>Success</div>";
            
    }
    else
    {
         $statusMsg = "<div class='alert alert-danger' role='alert'>Error ! Please Try Again</div>";
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="img/logo/attnlg.jpg" rel="icon">
    <title>KUCET</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">

<script>
    function validateForm() {
      var input = document.getElementById("admissionNumberInput");
      var inputValue = input.value.trim(); 
      if (inputValue.length !== 10) {
        alert("Input must be exactly 10 characters long.");
        return false;
       }
      return true;
    }
    function validateInputLength(input, expectedLength) {
      input.value = input.value.trim();
      if (input.value.length !== expectedLength) {
        alert("Enter Vaild Roll Number.");
        input.value = "";
      }
  }
</script>
</head>

<body class="bg-gradient-login" style="background-image: url('img/logo/loral1.jpe00g');">
    <!-- Login Content -->
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <h5 align="center">ATTENDANCE MANAGEMENT SYSTEM</h5><h5 align="center"> K U C E & T</h5>
                                    <div class="text-center">
                                        <img src="img/logo/attnlg.jpg" style="width:100px;height:100px">
                                        <img src="img/logo/attnlgcoll.jpg" style="width:90px;height:90px">
                                        <br><br>
                                        <h1 class="h4 text-gray-900 mb-4">Register</h1>
                                        <div class="text-center">
                                          <?php echo $statusMsg; ?>
                                        </div>
                                    </div>
                                    <form class="user" method="Post" action="">
                                        <div class="form-group">
                                        		<input type="text" class="form-control" required name="admissionNumber" oninput='this.value = this.value.toUpperCase()' pattern=".{10}" maxlength="10" id="exampleInputFirstName" placeholder="Enter Full Admission Number" >
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" required name="firstName" required id="exampleInputFirstName" placeholder="Enter Your First Name" >
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" required name="lastName" required id="exampleInputLastName" placeholder="Enter Your Last Name" >
                                        </div>
                                        <div class="form-group">
								                         <?php
								                        $qry= "SELECT * FROM tblbranch ORDER BY branchName ASC";
								                        $result = $conn->query($qry);
								                        $num = $result->num_rows;
								                        if ($num > 0){
								                          echo ' <select required name="branchId" class="form-control mb-3">';
								                          echo'<option value="">--Select Your Branch--</option>';
								                          while ($rows = $result->fetch_assoc()){
								                          echo'<option value="'.$rows['Id'].'" >'.$rows['branchName'].'</option>';
								                              }
								                                  echo '</select>';
								                              }
								                            ?>
								                        </div>
								                        <div class="form-group">
								                         <?php
								                        $qry= "SELECT * FROM tblclass where className = 'I' ORDER BY className ASC";
								                        $result = $conn->query($qry);
								                        $rows = $result->fetch_assoc();
								                          echo ' <select required name="classId" class="form-control mb-3">';
								                          echo'<option value="">--Select Your Semester--</option>';
								                          echo'<option value="'.$rows['Id'].'" >Regular I Semester</option>';
								                        $qry= "SELECT * FROM tblclass where className = 'III' ORDER BY className ASC";
								                        $result = $conn->query($qry);
								                        $rows = $result->fetch_assoc();
								                          echo'<option value="'.$rows['Id'].'" >Lateral I Semester</option>';
								                          echo '</select>';
								                            ?>
								                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-success btn-block" style="background-color:#727f2f;" value="Register" name="register" />
                                        </div>
                                    </form><br>
<p align="center">Registered? Check Your Attendance <a href="viewStudentAttendance.php">Click Here</a></p>
                                    <div class="text-center">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <?php include "Includes/footer.php";?>
    <!-- Login Content -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
</body>
<?php }else{ ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="img/logo/attnlg.jpg" rel="icon">
    <title>Student Registration - KUCET</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">

</head>
<body class="bg-gradient-login" style="background-image: url('img/logo/loral1.jpe00g');">
    <!-- Login Content -->
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <h5 align="center">ATTENDANCE MANAGEMENT SYSTEM</h5><h5 align="center"> K U C E & T</h5>
                                    <div class="text-center">
                                        <img src="img/logo/attnlg.jpg" style="width:100px;height:100px">
                                        <img src="img/logo/attnlgcoll.jpg" style="width:90px;height:90px">
                                        <br><br>
                                        <h1 class="h4 text-gray-900 mb-4">Register</h1>
                                        <h3 class="h5 text-gray-900 mb-4">Form Disabled. Please, Contact The Administrator To Enable The Form.</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Content -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
</body>
<?php } ?>
</html>
