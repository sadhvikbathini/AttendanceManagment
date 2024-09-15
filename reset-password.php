<?php
include 'Includes/dbcon.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['token'])) {
    $token = $_GET['token'];
    $query = "SELECT * FROM password_reset_tokens WHERE token = '$token' AND expires_at > NOW();";
		$rs = $conn->query($query);
		$num = $rs->num_rows;
		if($num > 0){
		  $statusMsg = "
		    <form class='user' method='post'>
            <div class='form-group'>
                <input type='password' class='form-control' required name='password' placeholder='Set New Password'>
            </div>
            <div class='form-group'>
                <input type='hidden' name='token' value='<?php echo htmlspecialchars($token); ?>'>
            </div>
            <div class='form-group'>
                <input type='submit' class='btn btn-primary btn-block' value='Reset Password' name='submit' />
            </div>
        </form>
		  ";
		}else{
		  $statusMsg = "<h3 class='h5 text-gray-900 mb-4'>I Think You Are Late. TOKEN EXPIRED!</h3>";
		}
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['password']) && isset($_POST['token'])) {
    $newPassword = $_POST['password'];
    $token = $_POST['token'];

    $token = $_GET['token'];
    $query = "SELECT * FROM password_reset_tokens WHERE token = '$token' AND expires_at > NOW();";
		$rs = $conn->query($query);
		$num = $rs->num_rows;
		$rows = $rs->fetch_assoc();
		if($num > 0){
		    $password = md5($newPassword);
		    $email = $rows['email'];
		    $query=mysqli_query($conn,"update tblclassteacher set password='$password' where emailAddress='$email' ");
        if ($query) {
          $delquery=mysqli_query($conn,"DELETE FROM password_reset_tokens WHERE email = '$email' ");
        	$statusMsg = "<h3 class='h5 text-gray-900 mb-4'>Password Changed Successfully! <a href='/index.php'> Now Login</a></h3>";
        }else{
          $statusMsg = "<h3 class='h5 text-gray-900 mb-4'>Error! Failed to Change Password.</h3>";
        }
		}else{
		  $statusMsg = "<h3 class='h5 text-gray-900 mb-4'>I Think You Are Late. TOKEN EXPIRED!</h3>";
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
    <title>Forget Password - KUCET</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-login">
    <!-- Login Content -->
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <img src="img/logo/attnlgcoll.jpg" style="width:90px;height:90px">
                                        <br><br>
                                        <h1 class="h4 text-gray-900 mb-4">Reset Password</h1>
                                    </div>
                                    <?php echo $statusMsg; ?>
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
    <!-- Login Content -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
</body>

</html>
