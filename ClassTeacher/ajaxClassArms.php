<?php

include '../Includes/dbcon.php';
include '../Includes/session.php';

    $cid = intval($_GET['cid']);
    $bid = intval($_GET['bid']);
    

        $queryss=mysqli_query($conn,"SELECT tblclassarms.Id,tblclassarms.classArmName 
                              FROM tblclassteacher
                              INNER JOIN tblclassarms ON tblclassarms.Id = tblclassteacher.classArmId
                              Where tblclassteacher.emailAddress ='$_SESSION[emailAddress]' AND tblclassteacher.branchId=".$bid." AND tblclassteacher.classId=".$cid." ORDER BY classArmName ASC");                        
        $countt = mysqli_num_rows($queryss);

        echo '
        <select required name="classArmId" class="form-control mb-3">';
        echo'<option value="">--Select Subjects--</option>';
        while ($row = mysqli_fetch_array($queryss)) {
        echo'<option value="'.$row['Id'].'" >'.$row['classArmName'].'</option>';
        }
        echo '</select>';
?>
