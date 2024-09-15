<?php 

include '../Includes/dbcon.php';
include '../Includes/session.php';


if(isset($_POST['save'])){

    
    $admissionNo=$_POST['admissionNo'];
    $classId=$_POST['classId'];
    $queryy = "SELECT Id from tblbatch where classId = '$classId'";
    $rss = $conn->query($queryy);
		$rowss = $rss->fetch_assoc();
		$batchId = $rowss['Id'];
    $branchId=$_POST['branchId'];
    $classArmId=$_POST['classArmId'];
    $check=$_POST['check'];
    $dateTaken=$_POST['dateTaken'];
    $N = count($admissionNo);
    $status = "";

$qurty=mysqli_query($conn,"select * from tblattendance  where branchId = '$branchId' and classId = '$classId' and classArmId = '$classArmId' and batchId = '$batchId' and dateTimeTaken='$dateTaken'");
$count = mysqli_num_rows($qurty);
              
if($count == 0){ 
              
 
  $qus=mysqli_query($conn,"select * from tblstudents  where classId = '$classId' and branchId = '$branchId'");
  while ($ros = $qus->fetch_assoc())
  {
      $qquery=mysqli_query($conn,"insert into tblattendance(admissionNo,branchId,classId,batchId,classArmId,status,dateTimeTaken) 
      value('$ros[admissionNumber]','$branchId','$classId','$batchId','$classArmId','0','$dateTaken')");
              
  }
}


  $qurty=mysqli_query($conn,"select * from tblattendance where branchId = '$branchId' and classId = '$classId' and classArmId = '$classArmId' and batchId = '$batchId' and dateTimeTaken='$dateTaken' and status = '1'");
  $count = mysqli_num_rows($qurty);

  if($count > 0){

      $statusMsg = "<div class='alert alert-danger' style='margin-right:50px;'>Attendance has been taken for today!</div>";

  }

    else 
    {

        for($i = 0; $i < $N; $i++)
        {
                $admissionNo[$i]; 

                if(isset($check[$i])) 
                {
                      $qquery=mysqli_query($conn,"update tblattendance set status='1' where branchId = '$branchId' and classId = '$classId' and classArmId = '$classArmId' and batchId = '$batchId' and dateTimeTaken='$dateTaken' and admissionNo = '$check[$i]'");

                      if ($qquery) {

                          $statusMsg = "<div class='alert alert-success'  style='margin-right:50px;'>Attendance Taken Successfully!</div>";
                      }
                      else
                      {
                          $statusMsg = "<div class='alert alert-danger' style='margin-right:50px;'>An error Occurred!</div>";
                      }
                  
                }
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
  <title>Faculty - KUCET</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">



   <script>
    function classArmDropdown(str) {
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
        xmlhttp.open("GET","ajaxClassArms2.php?cid="+str,true);
        xmlhttp.send();
    }
}
let cId;
let bId;
function classArmDropdown1(cId,bId) {
if (cId == "" || bId == "") {
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
            <h1 class="h3 mb-0 text-gray-800">Take Attendance</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Take Attendance</li>
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
    <label class="form-control-label">Select Subject<span class="text-danger ml-2">*</span></label>
        <?php
            echo"<div id='txtHint'></div>";
        ?>
    </div>
<div class="col-xl-6">
  <label class="form-control-label">Select Date<span class="text-danger ml-2">*</span></label>
  <input type="date" class="form-control" name="singleDate" id="exampleInputFirstName">
</div>
    </div>
    <button type="submit" name="search" class="btn btn-primary">Search</button>
  </form>
</div>
</div>


              <!-- Input Group -->
        <form method='post'>
                <div class='row'>
                  <div class='col-lg-12'>
                  <div class='card mb-4'>
                    <div class='card-header py-3 d-flex flex-row align-items-center justify-content-between'>
                      <h6 class='m-0 font-weight-bold text-primary'>All Student </h6>
                      <h6 class='m-0 font-weight-bold text-danger'>Note: <i>Click on the checkboxes besides each student to take attendance!</i></h6>
                    </div>
                    <div class='table-responsive p-3'>
                    <?php echo $statusMsg; ?>
                      <table class='table align-items-center table-flush table-hover'>
                        <thead class='thead-light'>
                          <tr>
                            <th>#</th>
                            <th>Admission No</th>
                            <th>Check</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Branch</th>
                            <th>Class</th>
                          </tr>
                        </thead>
                        
                        <tbody>

                  <?php
                  
                  if(isset($_POST['search'])){
                  
                    $classId=$_POST['classId'];
                    $branchId=$_POST['branchId'];
                    $classArmId=$_POST['classArmId'];
                    $dateTaken=$_POST['singleDate'];
                      
                      $query = "SELECT tblstudents.Id,tblclass.className,tblbranch.branchName,tblstudents.firstName,
                      tblstudents.lastName,tblstudents.admissionNumber
                      FROM tblstudents
                      INNER JOIN tblclass ON tblclass.Id = tblstudents.classId
                      INNER JOIN tblbranch ON tblbranch.Id = tblstudents.branchId
                      where tblstudents.classId = $classId and tblstudents.branchId = $branchId";
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
                                <td>".$sn."</td>
                                <td>".$rows['admissionNumber']."</td>
                                <td><input name='check[]' type='checkbox' value=".$rows['admissionNumber']." class='form-control'></td>
                                <td>".$rows['firstName']."</td>
                                <td>".$rows['lastName']."</td>
                                <td>".$rows['branchName']."</td>
                                <td>".$rows['className']."</td>
                              </tr>";
                              echo "<input name='admissionNo[]' value=".$rows['admissionNumber']." type='hidden' class='form-control'>
                              <input name='classId' value=".$classId." type='hidden' class='form-control'>
                              <input name='branchId' value=".$branchId." type='hidden' class='form-control'>
                              <input name='classArmId' value=".$classArmId." type='hidden' class='form-control'>
                              <input name='dateTaken' value=".$dateTaken." type='hidden' class='form-control'>";
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
                  <br>
                  <button type="submit" name="save" class="btn btn-primary">Take Attendance</button>
                  </form>
                </div>
              </div>
            </div>
            </div>
          </div>
          <!--Row-->

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
      $('#dataTable').DataTable(); 
      $('#dataTableHover').DataTable(); 
    });
  </script>
</body>

</html>
