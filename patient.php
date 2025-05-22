<?php
include('database/connect2.php');

if (isset($_POST['btnadd'])) {

  $name = trim($_POST['txtname']);
  $email = trim($_POST['txtemail']);
  $phone = trim($_POST['txtphone']);
    $sex = trim($_POST['cmdsex']);

  //convert date of birth to age
  $dob = $_POST['txtdob'];
  $birthDate = new DateTime($dob);
  $today = new DateTime();
  $age = $today->diff($birthDate)->y;


  // Check if patient already exists using prepared statement
  $stmt = $conn->prepare("SELECT id FROM patients WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if (mysqli_num_rows($result) == 0) {
    // Insert new patient using prepared statement
    $insert_stmt = $conn->prepare("INSERT INTO patients (name, age, email, phone,sex) VALUES (?, ?, ?, ?,?)");
    $insert_stmt->bind_param("sisss", $name, $age, $email, $phone,$sex);
    if ($insert_stmt->execute()) {
      $success = "Patient registered successfully!";
    } else {
      $error = "Error registering patient";
    }
    $insert_stmt->close();
  } else {
    $error = "Patient with this email already exists!";
  }
  $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Patient Registration</title>
  <link rel="stylesheet" href="css/styles.css"/>
     <link rel="icon" type="image/x-icon" href="uploadImage/Logo/logo.png">

</head>
<body>
  <header class="navbar">
    <h1>Patient Registration</h1>
    <nav>
      <a href="index.php">Home</a>
      <a href="recommendation.php">Get Recommendation</a>
      <a href="#">Register Patient</a>
    </nav>
  </header>

  <section class="form-section">
      <div align="center">
        <?php if (isset($success)): ?>
      </div>
      <div class="success-message" style="color: green; font-weight: bold;">
        <div align="center"><?php echo $success; ?></div>
      </div>
      <div align="center">
        <?php elseif (isset($error)): ?>
      </div>
      <div class="error-message" style="color: red; font-weight: bold;">
        <div align="center"><?php echo $error; ?></div>
      </div>
      <div align="center">
        <?php endif; ?>
        
        </div>
      <h2>Patient Registration</h2>

    <form action="" method="POST">
      <label>Name:</label>
      <input type="text" name="txtname" required/>

      <label>Email:</label>
      <input type="email" name="txtemail" required/>

      <label>Phone:</label>
      <input type="tel" name="txtphone" required/>

      <label>Date of Birth:</label>
      <input type="date" name="txtdob" required/>
      
      <label for="cmdsex" style="display:block; margin-top:15px; font-weight:bold;">Sex:</label>
      <select name="cmdsex" id="cmdsex" class="form-select" required
        style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px; margin-bottom:15px; font-size:16px;">
        <option value="">Select Sex</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
      </select>

      <button type="submit" name="btnadd"> Save </button>
    </form>
</section>

  <footer>
<?php include('Admin/partials/footer.php') ?>  
</footer>
</body>
</html>
