
<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';


if (isset($_GET['status']) && isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "edit")
{
       $Id= $_GET['Id'];
       $status= $_GET['status'];
       if($status == '1'){
         $qquery=mysqli_query($conn,"update tblattendance set status='0' where Id = '$Id'");
       }else{
         $qquery=mysqli_query($conn,"update tblattendance set status='1' where Id = '$Id'");
       }
       if ($qquery) {

           $statusMsg = "<div class='alert alert-success'  style='margin-right:50px;'>Attendance Updated Successfully!</div>";
           
       }
       else
       {
           $statusMsg = "<div class='alert alert-danger' style='margin-right:50px;'>An error Occurred!</div>";
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
  <title>Faculty - KUCET</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  
<script>
let cId;
let bId;
function classArmDropdown1(cId,bId) {
if (cId == "" || bId == "") {
    document.getElementById("txtHint").innerHTML = "";
    return;
} else { 
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("txtHint").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET","ajaxClassArms.php?cid="+cId+"&bid="+bId,true);
    xmlhttp.send();
}
}
   function savebranch(str){
     bId = str
     classArmDropdown1(cId,bId)
   }
   function saveclass(str){
     cId = str
     classArmDropdown1(cId,bId)
   }
</script>
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
      <?php include "Includes/sidebar.php";?>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
       <?php include "Includes/topbar.php";?>
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">View Attendance</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">View Attendance</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Enter Details</h6>
                    <?php echo $statusMsg; ?>
                </div>
                <div class="card-body">
								  <form method="post">
								<div class="form-group row mb-3">
								    <div class="col-xl-6">
								    <label class="form-control-label">Select Branch<span class="text-danger ml-2">*</span></label>
								     <?php
								    $qry= "SELECT MIN(tblbranch.Id) AS Id, tblbranch.branchName
								FROM tblclassteacher
								INNER JOIN tblbranch ON tblbranch.Id = tblclassteacher.branchId
								WHERE tblclassteacher.emailAddress = '$_SESSION[emailAddress]'
								GROUP BY tblbranch.branchName
								ORDER BY branchName ASC";
								    $result = $conn->query($qry);
								    $num = $result->num_rows;		
								    if ($num > 0){
								      echo ' <select required name="branchId" onchange="savebranch(this.value)" class="form-control mb-3">';
								      echo'<option value="">--Select Branch--</option>';
								      while ($rows = $result->fetch_assoc()){
								      echo'<option value="'.$rows['Id'].'" >'.$rows['branchName'].'</option>';
								          }
								              echo '</select>';
								          }
								        ?>  
								    </div>
								    <div class="col-xl-6">
								    <label class="form-control-label">Select Semester<span class="text-danger ml-2">*</span></label>
								     <?php
								    $qry= "SELECT MIN(tblclass.Id) AS Id, tblclass.className
								FROM tblclassteacher
								INNER JOIN tblclass ON tblclass.Id = tblclassteacher.classId
								WHERE tblclassteacher.emailAddress = '$_SESSION[emailAddress]'
								GROUP BY tblclass.className
								ORDER BY className ASC";
								    $result = $conn->query($qry);
								    $num = $result->num_rows;		
								    if ($num > 0){
								      echo ' <select required name="classId" onchange="saveclass(this.value)" class="form-control mb-3">';
								      echo'<option value="">--Select Semester--</option>';
								      while ($rows = $result->fetch_assoc()){
								      echo'<option value="'.$rows['Id'].'" >'.$rows['className'].'</option>';
								          }
								              echo '</select>';
								          }
								        ?>  
								    </div>
								    <div class="col-xl-6">
								    <label class="form-control-label">Select Subjects<span class="text-danger ml-2">*</span></label>
								        <?php
								            echo"<div id='txtHint'></div>";
								        ?>
								    </div>
								               <div class="col-xl-6">
								               <label class="form-control-label">Select Date<span class="text-danger ml-2">*</span></label>
								               <input type="date" class="form-control" name="singleDate" id="exampleInputFirstName">
								               </div>
								    </div>
                        <!-- <div class="col-xl-6">
                        <label class="form-control-label">Class Arm Name<span class="text-danger ml-2">*</span></label>
                      <input type="text" class="form-control" name="classArmName" value="<?php echo $row['classArmName'];?>" id="exampleInputFirstName" placeholder="Class Arm Name">
                        </div> -->
                     
                    <button type="submit" name="view" class="btn btn-primary">View Attendance</button>
                  </form>
                </div>
              </div>

              <!-- Input Group -->
                 

                  <?php

                    if(isset($_POST['view'])){
                    
                    $dateTaken =  $_POST['singleDate'];
                      $branchId=$_POST['branchId'];
                      $classId=$_POST['classId'];
	                    $classArmId=$_POST['classArmId'];
	                    
                      echo "<div class='row'>
                                    <div class='col-lg-12'>
                                    <div class='card mb-4'>
                                      <div class='card-header py-3 d-flex flex-row align-items-center justify-content-between'>
                                        <h6 class='m-0 font-weight-bold text-primary'>Attendance</h6>
                                      </div>
                                      <div class='table-responsive p-3'>
                                        <table class='table align-items-center table-flush table-hover' id='dataTableHover'>
                                          <thead class='thead-light'>
                                            <tr>
                                              <th>Admission No</th>
                                              <th>First Name</th>
                                              <th>Last Name</th>
                                              <th>Status</th>
                                              <th>Change Status</th>
                                              
                                            </tr>
                                          </thead>
                                         
                                          <tbody>";
                                
                      

                      $query = "SELECT tblattendance.Id,tblattendance.status,
                      tblstudents.firstName,tblstudents.lastName,tblstudents.admissionNumber
                      FROM tblattendance
                      INNER JOIN tblstudents ON tblstudents.admissionNumber = tblattendance.admissionNo
                      where tblattendance.dateTimeTaken = '$dateTaken' and tblattendance.branchId = '$branchId' and tblattendance.classId = '$classId' and tblattendance.classArmId = '$classArmId' and tblattendance.dateTimeTaken='$dateTaken'";
                      $rs = $conn->query($query);
                      $num = $rs->num_rows;
                      $sn=0;
                      $status="";
                      if($num > 0)
                      { 
                        while ($rows = $rs->fetch_assoc())
                          {
                              if($rows['status'] == '1'){$status = "Present"; $colour="#00FF00";}else{$status = "Absent";$colour="#FF0000";}
                             $sn = $sn + 1;
                            echo"
                              <tr>
                               <td>".$rows['admissionNumber']."</td>
                                 <td>".$rows['firstName']."</td>
                                <td>".$rows['lastName']."</td>
                                <td style='color:".$colour."'>".$status."</td>
                                <td><a href='?action=edit&status=".$rows['status']."&Id=".$rows['Id']."'>Change</a></td>
                              </tr>";
                          }
                      }
                      else
                      {
                           echo   
                           "<div class='alert alert-danger' role='alert'>
                            No Record Found!
                            </div>";
                      }
                    }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            </div>
          </div>
          <!--Row-->

          <!-- Documentation Link -->
          <!-- <div class="row">
            <div class="col-lg-12 text-center">
              <p>For more documentations you can visit<a href="https://getbootstrap.com/docs/4.3/components/forms/"
                  target="_blank">
                  bootstrap forms documentations.</a> and <a
                  href="https://getbootstrap.com/docs/4.3/components/input-group/" target="_blank">bootstrap input
                  groups documentations</a></p>
            </div>
          </div> -->

        </div>
        <!---Container Fluid-->
      </div>
      <!-- Footer -->
       <?php include "Includes/footer.php";?>
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
   <!-- Page level plugins -->
  <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
  </script>
</body>

</html>
