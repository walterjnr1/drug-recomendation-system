<?php 
include('../inc/email.php'); 
include('../inc/config.php');

if (empty($_SESSION['user_id'])) {
  header("Location: ../Auth/user_login");

}

if (isset($_POST['btnadd'])) {
  // Sanitize inputs
  $name = mysqli_real_escape_string($conn, trim($_POST['txtname'] ?? ''));
  $type = mysqli_real_escape_string($conn, trim($_POST['cmdtype'] ?? ''));
  $usage = mysqli_real_escape_string($conn, trim($_POST['txtusage'] ?? ''));
  $sideeffect = mysqli_real_escape_string($conn, trim($_POST['txtsideeffect'] ?? ''));
  $contraindication = mysqli_real_escape_string($conn, trim($_POST['cmdcontraindication'] ?? ''));

  // Check required fields
  if (empty($name) || empty($type) || empty($usage) || empty($sideeffect) || empty($contraindication)) {
    $_SESSION['error'] = "All fields are required!";
  } else {
    // Check if drug already exists
    $query = "SELECT * FROM drugs WHERE name = '$name' AND type = '$type'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
      $_SESSION['error'] = "Drug already exists!";
    } else {
      // Insert new drug
      $query = "INSERT INTO drugs (name, type, drug_usage, side_effects, contraindications) 
            VALUES ('$name', '$type', '$usage', '$sideeffect', '$contraindication')";
      $result = mysqli_query($conn, $query);

      if ($result) {
        $_SESSION['success'] = "Drug added successfully!";
      } else {
        $_SESSION['error'] = "Failed to add drug!";
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $app_name; ?> | Add Drug</title>
  <?php include('partials/head.php') ;?>

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <?php include('partials/navbar.php') ;?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
  <?php include('partials/sidebar.php') ;?>
  </aside>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>New Drug</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">New Drug</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">New Drug</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="" method="POST">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" name="txtname" class="form-control" id="exampleInputEmail1" value="<?php echo $_POST['txtname'] ?? ''; ?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Type</label>
                    <select name="cmdtype" class="form-control" id="exampleInputEmail1">
                      <option value="" <?php echo (empty($_POST['cmdtype'])) ? 'selected' : ''; ?>>-- Select Drug Type --</option>
                      <option value="Tablet" <?php echo (isset($_POST['cmdtype']) && $_POST['cmdtype'] == 'Tablet') ? 'selected' : ''; ?>>Tablet</option>
                      <option value="Capsule" <?php echo (isset($_POST['cmdtype']) && $_POST['cmdtype'] == 'Capsule') ? 'selected' : ''; ?>>Capsule</option>
                      <option value="Syrup" <?php echo (isset($_POST['cmdtype']) && $_POST['cmdtype'] == 'Syrup') ? 'selected' : ''; ?>>Syrup</option>
                      <option value="Injection" <?php echo (isset($_POST['cmdtype']) && $_POST['cmdtype'] == 'Injection') ? 'selected' : ''; ?>>Injection</option>
                      <option value="Ointment" <?php echo (isset($_POST['cmdtype']) && $_POST['cmdtype'] == 'Ointment') ? 'selected' : ''; ?>>Ointment</option>
                      <option value="Cream" <?php echo (isset($_POST['cmdtype']) && $_POST['cmdtype'] == 'Cream') ? 'selected' : ''; ?>>Cream</option>
                      <option value="Other" <?php echo (isset($_POST['cmdtype']) && $_POST['cmdtype'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>
                
         
                <div class="form-group">
                    <label for="exampleInputEmail1">Drug Usage</label>
                  <input type="text" name="txtusage" class="form-control" id="exampleInputEmail1" value="<?php echo $_POST['txtusage'] ?? ''; ?>">

                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Side Effect</label>
                  <input type="text" name="txtsideeffect" class="form-control" id="exampleInputEmail1" value="<?php echo $_POST['txtsideeffect'] ?? ''; ?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">contraindications</label>
                  <select name="cmdcontraindication" class="form-control" id="exampleInputContraindication">
                    <option value="" <?php echo (empty($_POST['cmdcontraindication'])) ? 'selected' : ''; ?>>-- Select Contraindication --</option>
                    <option value="Pregnancy" <?php echo (isset($_POST['cmdcontraindication']) && $_POST['cmdcontraindication'] == 'Pregnancy') ? 'selected' : ''; ?>>Pregnancy</option>
                    <option value="Liver Disease" <?php echo (isset($_POST['cmdcontraindication']) && $_POST['cmdcontraindication'] == 'Liver Disease') ? 'selected' : ''; ?>>Liver Disease</option>
                    <option value="Kidney Disease" <?php echo (isset($_POST['cmdcontraindication']) && $_POST['cmdcontraindication'] == 'Kidney Disease') ? 'selected' : ''; ?>>Kidney Disease</option>
                    <option value="Allergy" <?php echo (isset($_POST['cmdcontraindication']) && $_POST['cmdcontraindication'] == 'Allergy') ? 'selected' : ''; ?>>Allergy</option>
                    <option value="Children" <?php echo (isset($_POST['cmdcontraindication']) && $_POST['cmdcontraindication'] == 'Children') ? 'selected' : ''; ?>>Children</option>
                    <option value="Elderly" <?php echo (isset($_POST['cmdcontraindication']) && $_POST['cmdcontraindication'] == 'Elderly') ? 'selected' : ''; ?>>Elderly</option>
                    <option value="Hypertension" <?php echo (isset($_POST['cmdcontraindication']) && $_POST['cmdcontraindication'] == 'Hypertension') ? 'selected' : ''; ?>>Hypertension</option>
                    <option value="Other" <?php echo (isset($_POST['cmdcontraindication']) && $_POST['cmdcontraindication'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                  </select>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <button type="submit" name="btnadd" class="btn btn-primary">Save</button>
    </div>
</form>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>

         
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>  <?php include('partials/footer.php') ;?></strong>
    <div class="float-right d-none d-sm-inline-block">
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<?php include('partials/bottom-script.php') ;?>

</body>
</html>
