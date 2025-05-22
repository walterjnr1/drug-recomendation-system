<?php
include('config.php'); 

if (isset($_POST['btnlogin'])) {
  $admission_no = $conn->real_escape_string($_POST['txtadmission_no']);
  $password = $conn->real_escape_string($_POST['txtpassword']);

  $query = "SELECT s.class_id, s.id, s.admission_no, s.password, s.school_id, sc.code AS school_code 
            FROM students s LEFT JOIN schools sc ON s.school_id = sc.id WHERE s.admission_no = '$admission_no' 
            LIMIT 1";

  $result = mysqli_query($conn, $query);

  if ($student = mysqli_fetch_assoc($result)) {
      if (password_verify($password, $student['password'])) {
          $_SESSION['student_id'] = $student['id'];
		  $_SESSION['admission_no'] = $student['admission_no'];
          $_SESSION['school_id'] = $student['school_id'];
		  $_SESSION['class_id'] = $student['class_id'];

          $_SESSION['logged'] = time();

          // Capture login IP and time
          $ip = $_SERVER['REMOTE_ADDR'];
          $student_id = $student['id'];

          $insertLog = "INSERT INTO student_login_logs (student_id, ip_address) VALUES ('$student_id', '$ip')";
          mysqli_query($conn, $insertLog); // Store the login

          header("Location: ../Student/index"); // Redirect to student dashboard
          exit();
      } else {
          $_SESSION['error'] = "Invalid password!";
      }
  } else {
      $_SESSION['error'] = "No student found with this Admission Number.";
  }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Student login Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../Student/vendors/styles/popup_style.css">
  <link rel="icon" type="image/png" sizes="16x16" href="../uploadImage/Logo/gradeplus.jpeg">

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="../Student/vendors/styles/core.css">
	<link rel="stylesheet" type="text/css" href="../Student/vendors/styles/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="../Student/vendors/styles/style.css">

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-119386393-1');
	</script>
    <style type="text/css">
<!--
.style1 {
	color: #000000;
	font-weight: bold;
}
-->
    </style>
</head>
<body>
	<div class="login-header box-shadow">
		<div class="container-fluid d-flex justify-content-between align-items-center">
			<div class="brand-logo">
				<a href="#"><img src="../<?php echo $app_logo ; ?>" alt="" width="132" height="63"></a>
            </div>
			<div class="login-menu">
				<ul>
					<li><a href="add_student">Register</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6">
					<img src="../Student/vendors/images/forgot-password.png" alt="">
				</div>
				<div class="col-md-6">
					<div class="login-box bg-white box-shadow border-radius-10">
						<div class="login-title">
							<h2 class="text-center text-primary">Student Login Page</h2>
						</div>
						<h6 class="mb-20"></h6>

                        <form  action="" method="POST" >
                        <div class="input-group custom">
								<input type="text" name="txtadmission_no" class="form-control form-control-lg" placeholder="Admission Number">
								<div class="input-group-append custom">
								</div>
						  </div>
							<div class="input-group custom">
								<input type="password" name="txtpassword" class="form-control form-control-lg" placeholder=" Password">
								<div class="input-group-append custom">
								</div>
							</div>
						  <div class="row align-items-center">
								<div class="col-5">
									<div class="input-group mb-0">
									
                                     <button type="submit" name="btnlogin" class="btn btn-primary btn-lg btn-block">Login</button>
									</div>
								</div>
							    <p>&nbsp;</p>
							    <p><a href="student_forgot_password" class="style1">Forgot Password ?</a> </p>
						  </div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- js -->
	<script src="vendors/scripts/core.js"></script>
	<script src="vendors/scripts/script.min.js"></script>
	<script src="vendors/scripts/process.js"></script>
	<script src="vendors/scripts/layout-settings.js"></script>

    <?php if(!empty($_SESSION['success'])) {  ?>
<div class="popup popup--icon -success js_success-popup popup--visible">
  <div class="popup__background"></div>
  <div class="popup__content">
    <h3 class="popup__content__title">
      <strong>Success</strong>
    </h1>
    <p><?php echo $_SESSION['success']; ?></p>
    <p>
      <button class="button button--success" data-for="js_success-popup">Close</button>
    </p>
  </div>
</div>
<?php unset($_SESSION["success"]);
} ?>
<?php if(!empty($_SESSION['error'])) {  ?>
<div class="popup popup--icon -error js_error-popup popup--visible">
  <div class="popup__background"></div>
  <div class="popup__content">
    <h3 class="popup__content__title">
      <strong>Error</strong>
    </h1>
    <p><?php echo $_SESSION['error']; ?></p>
    <p>
      <button class="button button--error" data-for="js_error-popup">Close</button>
    </p>
  </div>
</div>
<?php unset($_SESSION["error"]);  } ?>
    <script>
      var addButtonTrigger = function addButtonTrigger(el) {
  el.addEventListener('click', function () {
    var popupEl = document.querySelector('.' + el.dataset.for);
    popupEl.classList.toggle('popup--visible');
  });
};

Array.from(document.querySelectorAll('button[data-for]')).
forEach(addButtonTrigger);
    </script>
</body>
</html>