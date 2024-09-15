<?php 
include 'Includes/dbcon.php';
include 'sendgmail/mail.php';
session_start();
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
                                        <h1 class="h4 text-gray-900 mb-4">Forgot Password</h1>
                                        <!-- <h3 class="h5 text-gray-900 mb-4">Please, Contact the Administrator</h3> -->
                                    </div>
                                    <form class="user" method="Post" action="">
                                        <div class="form-group">
                                            <input type="email" class="form-control" required name="email" id="exampleInputEmail" placeholder="Enter Email Address">
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary btn-block" value="Send Reset Link" name="submit" />
                                        </div>
                                    </form>
                                    
  <?php

    if(isset($_POST['submit'])){
    			$email = $_POST['email'];
    
            $Query = $conn->prepare("SELECT * FROM tblclassteacher WHERE emailAddress = ?");
						$Query->bind_param("s", $email);
						$Query->execute();
						$rs = $Query->get_result();
						$num = $rs->num_rows;
						if($num > 0){
							$token = bin2hex(random_bytes(32));
							$query = $conn->prepare("INSERT INTO password_reset_tokens (email, token, created_at, expires_at) VALUES(?,?, NOW(), DATE_ADD(NOW(), INTERVAL 1 HOUR))");
              $query->bind_param("ss", $email, $token);
              $query->execute();
					    if ($query) {
					        $statusMsg = sendPasswordResetLink($email, $token);
					    }else{
					         $statusMsg = "<div class='alert alert-danger' role='alert' '>An Error Occurred!</div>";
					    }
						}else{
							$statusMsg = "<div class='alert alert-danger' role='alert'> Your Email Is Not In Our Database. Check Email And Try Again</div>";
						}
				}
	?>

                                    <div class="text-center">
                                    <?php echo $statusMsg; ?>
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
