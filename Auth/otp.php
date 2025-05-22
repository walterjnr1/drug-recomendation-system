<?php 
include('../inc/email.php'); 
include('config.php'); 

if (empty($_SESSION['otp'])) {
  header("Location: add_student");
  }
$email = $_SESSION['email'];
$password = $_SESSION['password'];

if (isset($_POST['btnverify'])) {
  $otp = implode('', $_POST['otp']);  

  // Check if OTP is valid and not expired (within 15 mins)
  $stmt = $conn->prepare("SELECT * FROM otps WHERE email = ? AND code = ? AND TIMESTAMPDIFF(MINUTE, created_at, NOW()) < 15");
  $stmt->bind_param("ss", $email, $otp);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    // delete otp from otps table
    $delete_otp_query = "DELETE FROM otps WHERE email = '$email'";
    mysqli_query($conn, $delete_otp_query);

    // update status in students table
    $sql_student = "UPDATE students SET status=? WHERE parent_email=?";
    $stmt2 = $dbh->prepare($sql_student);
    $stmt2->execute(['1', $email]);

    $admission_no = $_SESSION['admission_no'];
    $name = $_SESSION['name'];

    // send email notification
    $message = "
    <html>
    <head>
    <title>Student Registration | $app_name</title>
    </head>
    <body>
    <p>Dear <strong>$name</strong>,</p>
    <p>We are pleased to inform you that your registration has been completed.</p>
    <p><strong>Registration Details:</strong></p>
    <p>Name: <strong>$name</strong></p>
    <p>Email: <strong>$email</strong></p>
    <p>Password: <strong>$password</strong></p>
    <p>Student ID: <strong>$admission_no</strong></p>

    <p>Class: <strong>N/A</strong></p>
    <p>House: <strong>N/A</strong></p>
    <p>Kindly ensure all documents are submitted to the registration office. If not, please do so at your earliest convenience.</p>
    <p>Warm regards,</p>
    <p>$app_name Team</p>
    </body>
    </html>";

    $subject = "Complete Your Registration | $app_name";
    if (sendEmail($email, $subject, $message)) {
      header("Location: student_success");
    } else {
      $_SESSION['error'] = 'Registration succeeded but email notification failed.';
    }

  } else {
    // If no matching OTP found
    $_SESSION['error'] = 'Invalid or expired OTP. Please try again.';
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo $app_name; ?> - OTP verification</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../Admin/dist/css/popup_style.css">
  <link rel="icon" type="image/png" sizes="16x16" href="../uploadImage/Logo/gradeplus.jpeg">

  <style>
    .otp-input {
      width: 60px;
      height: 60px;
      font-size: 24px;
      text-align: center;
      margin: 0 5px;
    }
  .style1 {color: #003300}
  </style>
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

  <div class="card p-4 shadow-lg" style="max-width: 700px; width: 100%; height:40% " >
    <h4 class="text-center mb-4">Enter OTP Code to complete your registration </h4>
    <p class="text-center mb-4 style1">OTP was sent to your Email (<?php echo $email  ; ?>) </p>
    
    <form action="" method="POST" id="otpForm">
      <div class="d-flex justify-content-center mb-3">
        <input type="text" name="otp[]" maxlength="1" class="form-control otp-input" oninput="moveToNext(this, 0)">
        <input type="text" name="otp[]" maxlength="1" class="form-control otp-input" oninput="moveToNext(this, 1)">
        <input type="text" name="otp[]" maxlength="1" class="form-control otp-input" oninput="moveToNext(this, 2)">
        <input type="text" name="otp[]" maxlength="1" class="form-control otp-input" oninput="moveToNext(this, 3)">
        <input type="text" name="otp[]" maxlength="1" class="form-control otp-input" oninput="moveToNext(this, 4)">
      </div>
      <div class="d-grid">
          <button type="submit" name="btnverify" class="btn btn-primary">Verify</button>
      </div>
    </form>
  </div>

  <script>
    function moveToNext(input, index) {
      const inputs = document.querySelectorAll('.otp-input');
      if (input.value.length === 1 && index < inputs.length - 1) {
        inputs[index + 1].focus();
      }
    }
  </script>
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

