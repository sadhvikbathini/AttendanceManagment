<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';


if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "edit")
	{
        $Id= $_GET['Id'];

        $query = "SELECT * from tblbatch where Id = '$Id'";
        $rs = $conn->query($query);
				$rows = $rs->fetch_assoc();
				$batchId = $rows['Id'];
				$classId = $rows['classId'];
        $classIdpro=$classId + 1;
    
//--------------------------------DELETE------------------------------------------------------------------

    $query1 = mysqli_query($conn,"DELETE FROM tblattendance WHERE batchId='$batchId'");

       if ($query1 == TRUE) {}
       else{
       $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>Error : Not able to delete Attendance</div>"; 
        }
    
//------------------------Update and Save--------------------------------------------------

    $query = mysqli_query($conn,"update tblstudents set classId='$classIdpro' where classId ='$classId' and batchId='$batchId'");
    
   $querybatch = mysqli_query($conn,"update tblbatch set classId='$classIdpro' where classId ='$classId' and Id='$batchId'");

    
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
<?php include 'includes/title.php';?>
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
            <h1 class="h3 mb-0 text-gray-800">Promote Students</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Promote Students</li>
            </ol>
          </div>

          <div class="row">
       <div class="col-lg-12">
       <div class="card mb-4">
         <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
           <h6 class="m-0 font-weight-bold text-primary">All Batches</h6>
         </div>
         <div class="table-responsive p-3">
           <table class="table align-items-center table-flush table-hover" id="dataTableHover">
             <thead class="thead-light">
               <tr>
                 <th>#</th>
                 <th>Batch</th>
                 <th>Current Semster</th>
                 <th>Promote Students</th>
               </tr>
             </thead>
           
             <tbody>

           <?php
               $query = "SELECT tblbatch.Id,tblbatch.batchName,tblclass.className FROM tblbatch INNER JOIN tblclass ON tblclass.Id = tblbatch.classId";
               $rs = $conn->query($query);
               $num = $rs->num_rows;
               $sn=0;
               if($num > 0)
               { 
                 while ($rows = $rs->fetch_assoc())
                   {
                      $sn = $sn + 1;
                     echo"
                       <tr>
                         <td>".$sn."</td>
                         <td>".$rows['batchName']."</td>
                         <td>".$rows['className']."</td>
                         <td><a href='?action=edit&Id=".$rows['Id']."'>Promote All Students</a></td>
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
               
               ?>
             </tbody>
           </table>
         </div>
       </div>
     </div>
     </div>
          <!--Row-->
        </div>
        <!---Container Fluid-->
      </div>
      <!-- Footer -->
       
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
