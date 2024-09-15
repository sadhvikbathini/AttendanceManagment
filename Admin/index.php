
<?php 
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
  <title>Admin - KUCET</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
</head>

<?php if(isset($_POST['print'])){
   echo"<body onload='window.print()' id='page-top'>";
  }else{
    "<body id='page-top'>";
    }
?>
  <div id="wrapper">
    <!-- Sidebar -->
 
   <?php if(isset($_POST['print'])){}
          else{
           include "Includes/sidebar.php"; 
          }
      ?>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        
           <?php if(isset($_POST['print'])){}
                  else{
                   include "Includes/topbar.php";
                  } 
                ?>
        <!-- Topbar -->
        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <?php if(isset($_POST['print'])){
                      echo "<a href='./'>Back</a>";
                   }
                   else{
                    echo "<h1 class='h3 mb-0 text-gray-800'>Administrator</h1>";
                   } 
                 ?>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">View Attendance</li>
            </ol>
          </div>
<?php 
if(isset($_POST['print'])){}
 else{
?>
 <form method="post">
      <div class="form-group row mb-3">
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
       <div  class="col-xl-6">
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
       <button type="submit" name="view" class="btn btn-primary">View Attendance</button>
       <button type="submit" name="print" class="btn btn-primary">Print Attendance</button>
       </div>
      </div>
 </form>

<?php 
 }
?>



 <div class="table-responsive p-3">
 
       <?php
 if(isset($_POST['view']) || isset($_POST['print'])){
         
         
        $classId=$_POST['classId'];
        $branchId=$_POST['branchId'];
       
       
       // Get all subjects for the class and branch using prepared statement
       $subjectsQuery = $conn->prepare("SELECT Id, classArmName FROM tblclassarms WHERE branchId = ? AND classId = ?");
       $subjectsQuery->bind_param("ss", $branchId, $classId);
       $subjectsQuery->execute();
       $subjectsResult = $subjectsQuery->get_result();
       
       if ($subjectsResult->num_rows > 0) {
       echo "<table class='table align-items-center table-flush table-hover' id='dataTableHover'><tr>";
       echo "<th>Roll Number</th>";
       $classArms = [];
           while ($subject = $subjectsResult->fetch_assoc()) {
                 $classArms[] = $subject;
               // Print the subject name as a heading
               echo "<th>" . htmlspecialchars($subject['classArmName']) . "</th>";
                }
       echo "</tr><tr><td><table class='table align-items-center table-flush table-hover' id='dataTableHover'>";
       $attendanceQuery = $conn->prepare("
             SELECT 
                 s.admissionNumber AS StudentID,
                 s.firstName AS FirstName,
                 s.lastName AS LastName
             FROM 
                 tblstudents s
             JOIN 
                 tblattendance a ON s.admissionNumber = a.admissionNo
             WHERE 
                 s.branchId = ?
                 AND s.classId = ?
                 AND a.branchId = s.branchId
                 AND a.classId = s.classId
             GROUP BY 
                 s.Id
             ORDER BY 
                 s.Id;
         ");
         $attendanceQuery->bind_param("ss", $branchId, $classId);
         $attendanceQuery->execute();
         $attendanceResult = $attendanceQuery->get_result();
         while ($row = $attendanceResult->fetch_assoc()) {
             echo "<tr>
                     <td>" . htmlspecialchars($row['StudentID']) . "</td>
                     <td>" . htmlspecialchars($row['FirstName']) . "</td>
                     <td>" . htmlspecialchars($row['LastName']) . "</td>
                   </tr>";
         }
         echo "</table></td>";
         
           foreach ($classArms as $subject) { 
           
               $attendanceQuery = $conn->prepare("
                   SELECT 
                       ROUND(
                           (SUM(CASE WHEN a.status = '1' THEN 1 ELSE 0 END) / COUNT(a.status)) * 100
                       ) AS AttendancePercentage
                   FROM 
                       tblstudents s
                   JOIN 
                       tblattendance a ON s.admissionNumber = a.admissionNo
                   WHERE 
                       s.branchId = ?
                       AND s.classId = ?
                       AND a.branchId = s.branchId
                       AND a.classId = s.classId
                       AND a.classArmId = ?
                   GROUP BY 
                       s.Id
                   ORDER BY 
                       s.Id;
               ");
               $attendanceQuery->bind_param("sss", $branchId, $classId, $subject['Id']);
               $attendanceQuery->execute();
               $attendanceResult = $attendanceQuery->get_result();
       
               if ($attendanceResult->num_rows > 0) {
                   // Start a table for this subject
                   echo "<td><table class='table align-items-center table-flush table-hover' id='dataTableHover'>";
       
                   // Loop through each student's attendance percentage
                   while ($row = $attendanceResult->fetch_assoc()) {
                       echo "<tr>
                               <td>" . htmlspecialchars($row['AttendancePercentage']) . "%</td>
                             </tr>";
                   }
       

                   echo "</table></td>";

               } 
               else { echo "<td>No attendance records found for this subject.</td>"; }
           }
           echo "</tr></table>";
       }
       else { echo "No subjects found for the specified class and branch."; }

 }
       ?>

 </div>
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
