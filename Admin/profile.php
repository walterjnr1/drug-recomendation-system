<?php 
include('../inc/config.php');
if (empty($_SESSION['user_id'])) {
  header("Location: ../Auth/user_login");

}
if (isset($_POST['btnedit'])) {
    // Retrieve form data
    $name  = $_POST['txtname'];
    $email = $_POST['txtemail'];

    // Check if email already exists for another user
    $checkEmail = $dbh->prepare("SELECT * FROM users WHERE email = :email AND id != :user_id");
    $checkEmail->bindParam(':email', $email);
    $checkEmail->bindParam(':user_id', $user_id);
    $checkEmail->execute();

    if ($checkEmail->rowCount() > 0) {
        // Email already taken
        $_SESSION['error']='The email address is already in use by another account. Please use a different one.';
    } else {
        $stmt = $dbh->prepare("UPDATE users SET name = :name, email = :email WHERE id = :user_id");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':user_id', $user_id);

        if ($stmt->execute()) {
          header("refresh:2; url=profile");

            $_SESSION['success']='Profile updated successfully.';
           
        } else {
            $_SESSION['error']='Error updating profile.';
        }
    }

}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $app_name; ?> | My Profile</title>
  <?php include('partials/head.php'); ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <?php include('partials/navbar.php'); ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <?php include('partials/sidebar.php'); ?>
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>My Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">My Profile</li>
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
            <!-- Profile Card -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">User Profile</h3>
              </div>
              <!-- /.card-header -->
              <!-- Profile details -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="txtname">Full Name</label>
                      <input type="text" class="form-control" id="txtname" value="<?php echo htmlspecialchars($row_user['name']); ?>" disabled>
                    </div>
                    <div class="form-group">
                      <label for="txtrole">Role</label>
                      <input type="text" class="form-control" id="txtrole" value="<?php echo htmlspecialchars($row_user['role']); ?>" disabled>
                    </div>
                   
                    <div class="form-group">
                      <label for="txtemail">Email</label>
                      <input type="email" class="form-control" id="txtemail" value="<?php echo htmlspecialchars($row_user['email']); ?>" disabled>
                    </div>
                </div>
              </div>
              <!-- /.card-body -->

              <!-- Profile Edit Button -->
              <div class="card-footer">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit Profile</button>
              </div>
            </div>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->

  <!-- Modal for Editing Profile -->
  <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form method="POST" action="">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="txtname">Full Name</label>
              <input type="text" name="txtname" class="form-control" id="txtname" value="<?php echo htmlspecialchars($row_user['name']); ?>" required>
            </div>
            
            <div class="form-group">
              <label for="txtemail">Email</label>
              <input type="email" name="txtemail" class="form-control" id="txtemail" value="<?php echo htmlspecialchars($row_user['email']); ?>" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="btnedit" class="btn btn-primary">Save Changes</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Footer -->
  <footer class="main-footer">
    <strong><?php include('partials/footer.php'); ?></strong>
  </footer>

</div>
<!-- ./wrapper -->

<!-- Scripts -->
<?php include('partials/bottom-script.php'); ?>

</body>
</html>
