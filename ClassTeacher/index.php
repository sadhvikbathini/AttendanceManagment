
<?php 
include '../Includes/dbcon.php';
include '../Includes/session.php';


$todaysDate = date("Y-m-d");
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
            <h1 class="h3 mb-0 text-gray-800">Allotted Classes And Subjects
            </h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </div>

          <div class="row mb-3">
          <!-- New User Card Example -->
          <?php 
          

  $query = "SELECT
              tblbranch.branchName,
              tblclass.className,
              tblclassarms.classArmName,
              IF(EXISTS(
                SELECT 1 
                FROM tblattendance 
                WHERE tblattendance.branchId = tblclassteacher.branchId
                  AND tblattendance.classId = tblclassteacher.classId
                  AND tblattendance.classArmId = tblclassteacher.classArmId
                  AND tblattendance.dateTimeTaken = '$todaysDate'
              ), 'TAKEN', 'NOT TAKEN') AS attendanceStatus
            FROM
              tblclassteacher
            INNER JOIN tblbranch ON tblclassteacher.branchId = tblbranch.Id
            INNER JOIN tblclass ON tblclassteacher.classId = tblclass.Id
            INNER JOIN tblclassarms ON tblclassteacher.classArmId = tblclassarms.Id
            WHERE
              tblclassteacher.emailAddress = '$_SESSION[emailAddress]' ";
	$rs = $conn->query($query);
  $num = $rs->num_rows;
  $sn=0;
  if($num > 0)
  { 
    while ($rows = $rs->fetch_assoc())
      {
          $sn = $sn + 1;
        echo"<div class='col-xl-3 col-md-6 mb-4'>
              <div class='card h-100'>
                <div class='card-body'>
                  <div class='row no-gutters align-items-center'>
                    <div class='col mr-2'>
                      <div class='h5 mb-0 mr-3 font-weight-bold text-gray-800'>".$rows['branchName']."</div><br>
                      <div class='h5 mb-0 mr-3 font-weight-bold text-gray-800'>".$rows['className']." Semester</div><br>
                      <div class='text-xs font-weight-bold text-uppercase mb-1'>Subject</div>
                      <div class='h5 mb-0 mr-3 font-weight-bold text-gray-800'>".$rows['classArmName']."</div><br>
                      <div class='text-xs font-weight-bold text-uppercase mb-1'>Today's Attendance</div>
                      <div class='h5 mb-0 mr-3 font-weight-bold text-gray-800'>".$rows['attendanceStatus']."</div>
                      <div class='mt-2 mb-0 text-muted text-xs'>
                        <!-- <span class='text-success mr-2'><i class='fas fa-arrow-up'></i> 20.4%</span>
                        <span>Since last month</span> -->
                      </div>
                    </div>
                    <div class='col-auto'>
                      <i class='fas fa-users fa-2x text-info'></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>";
        }
    }
    else
    {
         echo   
         "<div class='alert alert-danger' role='alert'>
          No Record Found!
          </div>";
    }
    
?>
            
            
        </div>
        <!---Container Fluid-->
      </div>
      <!-- Footer -->
      <?php include 'Includes/footer.php';?>
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
  <script src="../vendor/chart.js/Chart.min.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>  
</body>

</html>
