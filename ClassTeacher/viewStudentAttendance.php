
<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';



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
    function typeDropDown(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","ajaxCallTypes.php?tid="+str,true);
        xmlhttp.send();
    }
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
            <h1 class="h3 mb-0 text-gray-800">View Student Attendance</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">View Student Attendance</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Enter Student Details</h6>
                    <?php echo $statusMsg; ?>
                </div>
                <div class="card-body">
                  <form method="post">
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                      <label class="form-control-label">Admission Number<span class="text-danger ml-2">*</span></label>
                    <input type="text" class="form-control" required name="admissionNumber" placeholder = "Enter Roll Number" id="exampleInputFirstName" >
                      </div>
                    
                        <div class="col-xl-6">
                        <label class="form-control-label">Select Branch<span class="text-danger ml-2">*</span></label>
                         <?php
                        $qry= "SELECT * FROM tblbranch ORDER BY branchName ASC";
                        $result = $conn->query($qry);
                        $num = $result->num_rows;		
                        if ($num > 0){
                          echo ' <select required name="branchId" class="form-control mb-3">';
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
                        $qry= "SELECT * FROM tblclass ORDER BY className ASC";
                        $result = $conn->query($qry);
                        $num = $result->num_rows;		
                        if ($num > 0){
                          echo ' <select required name="classId" class="form-control mb-3">';
                          echo'<option value="">--Select Semester--</option>';
                          while ($rows = $result->fetch_assoc()){
                          echo'<option value="'.$rows['Id'].'" >'.$rows['className'].'</option>';
                              }
                                  echo '</select>';
                              }
                            ?>  
                        </div>
                        <div class="col-xl-6">
                        <label class="form-control-label">Type<span class="text-danger ml-2">*</span></label>
                          <select required name="type" onchange="typeDropDown(this.value)" class="form-control mb-3">
                          <option value="">--Select--</option>
                          <option value="1" >All</option>
                          <option value="2" >By Single Date</option>
                          <!-- <option value="3" >By Date Range</option> -->
                        </select>
                        </div>
                    </div>
                      <?php
                        echo"<div id='txtHint'></div>";
                      ?>
                    
                    <button type="submit" name="view" class="btn btn-primary">View Attendance</button>
                  </form>
                </div>
              </div>

              <!-- Input Group -->
                 <div class="row">
              <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Student's Attendance</h6>
                </div>
                <div class="table-responsive p-3">
                  

                  <?php

                    if(isset($_POST['view'])){
                      
                      
                       $classId=$_POST['classId'];
                       $branchId=$_POST['branchId'];
                       $admissionNumber =  $_POST['admissionNumber'];
                       $type =  $_POST['type'];
                    
                       if($type == "1"){ 
                            
                            echo"<table class='table align-items-center table-flush table-hover' id='dataTableHover'>
                          <thead class='thead-light'>
                            <tr>
                              
                              <th>Admission No</th>
                              <th>Subject</th>
                              <th>Attended</th>
                              <th>Total Classes</th>
                              <th>Attendance (%)</th>
                              <!-- <th>Date</th> -->
                            </tr>
                          </thead>
                         
                          <tbody>";

                        $query = "SELECT 
tblclassarms.classArmName, tblstudents.admissionNumber,
SUM(tblattendance.status = '0' or tblattendance.status = '1') AS total,
SUM(tblattendance.status = '1') AS statusOne
FROM tblattendance
INNER JOIN tblbranch ON tblbranch.Id = tblattendance.branchId
INNER JOIN tblclass ON tblclass.Id = tblattendance.classId
INNER JOIN tblclassarms ON tblclassarms.Id = tblattendance.classArmId
INNER JOIN tblstudents ON tblstudents.admissionNumber = tblattendance.admissionNo
WHERE tblattendance.admissionNo = '$admissionNumber'
AND tblattendance.branchId = '$branchId' 
AND tblattendance.classId = '$classId'
GROUP BY tblclassarms.classArmName
ORDER BY tblclassarms.classArmName ASC;";

                        $rs = $conn->query($query);
                        $num = $rs->num_rows;
                        $sn=0;
                        $status="";
                        if($num > 0)
                        { 
                          while ($rows = $rs->fetch_assoc())
                            {
                                
                               $sn = $sn + 1;
                              echo"
                                <tr>
                                  <td>".$rows['admissionNumber']."</td>
                                  <td>".$rows['classArmName']."</td>
                                  <td>".$rows['statusOne']."</td>
                                  <td>".$rows['total']."</td>
                                  <td>".$rows['statusOne'] * 100 / $rows['total']."% </td>
                                 
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
                        
                      echo"</tbody>
                    </table>";

                       
                       if($type == "2"){ 

                        $singleDate =  $_POST['singleDate'];

                        echo"<table class='table align-items-center table-flush table-hover' id='dataTableHover'>
                        <thead class='thead-light'>
                        <tr>
                          
                          <th>Admission No</th>
                          <th>Class Arm</th>
                          <th>Status</th>
                          <!-- <th>Date</th> -->
                        </tr>
                        </thead>
                                                 
                        <tbody>";

                         $query = "SELECT 
     tblclassarms.classArmName, tblstudents.admissionNumber,tblattendance.status
 FROM tblattendance
 INNER JOIN tblbranch ON tblbranch.Id = tblattendance.branchId
 INNER JOIN tblclass ON tblclass.Id = tblattendance.classId
 INNER JOIN tblclassarms ON tblclassarms.Id = tblattendance.classArmId
 INNER JOIN tblstudents ON tblstudents.admissionNumber = tblattendance.admissionNo
 WHERE tblattendance.admissionNo = '$admissionNumber' 
     AND tblattendance.branchId = '$branchId' 
     AND tblattendance.classId = '$classId'
     AND tblattendance.dateTimeTaken = '$singleDate'";
                        
                        
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
                                    <td>".$rows['classArmName']."</td>
                                    <td style='color:".$colour."'>".$status."</td>
                                   
                                  </tr>";
                              }
                          }
                          else
                          {
                               echo   
                               "<div class='alert alert-danger' role='alert'>
                                Attendance has not yet been taken for today.
                                </div>";
                          }
                        
                          
                        echo"</tbody>
                      </table>";
  
                        }
                       
                       }
                       

                    ?>
                </div>
              </div>
            </div>
            </div>
          </div>
          

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
