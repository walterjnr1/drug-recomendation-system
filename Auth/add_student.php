<?php 
include('../inc/email.php'); 
include('config.php'); 


if(isset($_POST["btnsave"]))
{
    do {
        $admission_no = rand(100000, 999999);
        $stmt = $conn->prepare("SELECT * FROM students WHERE admission_no = ?");
        $stmt->bind_param("s", $admission_no);
        $stmt->execute();
        $result = $stmt->get_result();
    } while ($result->num_rows > 0);
    $otp = rand(10000, 99999);
    $_SESSION['otp']=$otp;
    $_SESSION['admission_no']=$admission_no;

    $school_id = $_POST['cmdschool'];
    $name = $_POST['txtname'];
    $sex = $_POST['cmdsex'];
    $dob = $_POST['txtdob'];
    $password = $_POST['txtpassword'];
    $phone = $_POST['txtphone'];
    $email = $_POST['txtemail'];
    $previous_school = $_POST['txtprevious_school'];
    
    $_SESSION['email']=$email;
    $_SESSION['name']=$name;
    $_SESSION['password']=$password;


    //fetch school
    $stmt = $dbh->query("SELECT * FROM schools where id='$school_id'");
    $row_school = $stmt->fetch();
    $school_name=$row_school['name'] ;
    $school_district=$row_school['district'] ;

    //fetch current session based on school id
    $stmt = $dbh->query("SELECT * FROM academic_session where school_id='$school_id' and status=1");
    $row_session = $stmt->fetch();
    $current_session_id=$row_session['id'] ;

    // Check if email already exists
    $sql = "SELECT * FROM students WHERE parent_email = ? and school_id='$school_id'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = 'Email already exists. Please use a different email.';
    } else {
         $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Create a SQL query to insert data into the schools table
        $sql = "INSERT INTO students (school_id, admission_no, fullname, sex,dob,password,parent_email,parent_phone,previous_school) VALUES (?, ?,?,?,?, ?, ?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssss", $school_id, $admission_no, $name, $sex,$dob,$hashedPassword,$email,$phone,$previous_school);

        if ($stmt->execute()) {
            //send notification via email
          
$message = "
<html>
<head>
<title>Complete Your Registration | Verify Your Email with OTP | $app_name</title>
</head>
<body>

<p>Dear <strong> $name ,</strong></p>

<p>Thank you for registering with <strong> $school_name, $school_district .</strong> To complete your registration, please verify your email address using the One-Time Password (OTP) provided below:</p>

<p>Your OTP Code: <strong>$otp </strong></p>

<p>Please enter this code on the verification page to confirm your registration. This OTP is valid for the next 15 minutes.</p>

<p>If you did not initiate this registration, kindly ignore this email.</p>

<p>For any assistance, feel free to reach out to us at $app_email.</p>

<p>We look forward to welcoming you to our academic community!</p>

<p>Warm regards,</p>
<p>$app_name Team</p>
</body>
</html>
";
          // Send email
          $subject = "Student Registration | $app_name";
          if (sendEmail($email, $subject, $message)) {

        //save otp
        $sql = "INSERT INTO otps (code, email) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $otp, $email);
        $stmt->execute();

        //refresh 
        header("Location: student_otp");
        } else {
            $_SESSION['error'] = 'Problem Sending OTP';
        }
    }}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo $app_name; ?>Student Registration</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="16x16" href="../uploadImage/Logo/gradeplus.jpeg">
    <link rel="stylesheet" href="../Admin/dist/css/popup_style.css">

  <style>
    body {
      background: #f5f7fa;
    }

    .form-container {
      max-width: 600px;
      margin: 50px auto;
      background: #ffffff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    .form-title {
      margin-bottom: 25px;
      text-align: center;
      font-weight: bold;
      color: #2c3e50;
    }

    .form-control:focus {
      border-color: #007bff;
      box-shadow: none;
    }

    @media (max-width: 576px) {
      .form-container {
        padding: 20px;
      }
    }
  </style>
</head>
<body>
<div align="center">
  <p>&nbsp;</p>
  <p><img src="../uploadImage/Logo/gradeplus.jpeg" alt="gradepulse" width="186" height="95"></p>
</div>
<div class="container">
  <div class="form-container">
      <h4 class="form-title">Student Registration</h4>
      <form  action="" method="POST" >
      <div class="mb-3">
          <label for="password" class="form-label">School</label>
          <select name="cmdschool" class="form-control" id="exampleInputEmail1" required>
       <?php 
    // Assuming you have a database connection established
    $query = "SELECT * FROM schools ORDER BY name desc";
    echo '<option value=""> select school </option>';

    $result = mysqli_query($conn, $query);
     while($row = mysqli_fetch_assoc($result)) {
        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
    }
    ?>
     </select>            
    </div>
        <div class="mb-3">
          <label for="fullname" class="form-label">fullName</label>
          <input type="text" class="form-control" name="txtname" value="<?php echo $_POST['txtname'] ?? ''; ?>" required>
        </div>
        
        <div class="mb-3">
          <label class="form-label">Sex</label>
          <div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="cmdsex" id="male" value="male">
              <label class="form-check-label" for="male">Male</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="cmdsex" id="female" value="female">
              <label class="form-check-label" for="female">Female</label>
            </div>
          </div>
        </div>
        <div class="mb-3">
          <label for="phone" class="form-label">Date of Birth</label>
          <input type="date" class="form-control" name="txtdob"  required>
        </div>
        <div class="mb-3">
          <label for="phone" class="form-label">Password</label>
          <input type="password" class="form-control" name="txtpassword"  value="<?php echo $_POST['txtpassword'] ?? ''; ?>"required>
        </div>

          <div class="mb-3">
          <label for="email" class="form-label">Parent Email Address</label>
          <input type="email" class="form-control" name="txtemail" value="<?php echo $_POST['txtemail'] ?? ''; ?>" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Parent Phone</label>
          <input type="tel" class="form-control" name="txtphone" value="<?php echo $_POST['txtphone'] ?? ''; ?>"required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Previous School</label>
          <input type="text" class="form-control" name="txtprevious_school" value="<?php echo $_POST['txtprevious_school'] ?? ''; ?>" required>
        </div>
        <div class="d-grid">
          <button type="submit" name="btnsave" class="btn btn-primary">Register</button>
        </div>
      </form>
    Already a student ?<a href="student_login"> login Here</a> </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
