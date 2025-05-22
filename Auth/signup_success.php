<?php
session_start();
if (empty($_SESSION['email'])) {
  header("Location: add_student");
  exit();
}

$name = $_SESSION['name'];
$admission_no = $_SESSION['admission_no'];
$email = $_SESSION['email'];

//destroy all session
session_unset();    // Unset all session variables
session_destroy();  // Destroy the session itself

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registration Successful | <?php echo $app_name; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" type="image/png" sizes="16x16" href="../uploadImage/Logo/gradeplus.jpeg">
  <style>
    .success-card {
      max-width: 600px;
      margin: auto;
      padding: 30px;
      margin-top: 80px;
      border-radius: 16px;
      box-shadow: 0 0 20px rgba(0,0,0,0.15);
      background: #fff;
      text-align: center;
    }
    .success-icon {
      font-size: 80px;
      color: #28a745;
    }
    .btn-custom {
      background: #28a745;
      color: #fff;
      padding: 10px 25px;
      border-radius: 50px;
      text-decoration: none;
    }
    .btn-custom:hover {
      background: #218838;
      color: #fff;
    }
  </style>
</head>
<body class="bg-light">

  <div class="success-card" style="width: 119%;">
    <div class="success-icon mb-3">
      ✅
    </div>
    <h2 class="mb-3">Student Registration Successful!</h2>
    <p class="lead">Congratulations, <strong><?php echo $name; ?></strong> 🎉</p>
    <p>Your registration has been completed successfully.</p>

    <div class="text-start mt-4 mb-3">
      <p><strong>Student ID:</strong> <?php echo $admission_no; ?></p>
      <p><strong>Email:</strong> <?php echo $email; ?></p>
    </div>

    <a href="../Student/index" class="btn btn-custom mt-3">Go to Student Portal</a>
  </div>

</body>
</html>
