<?php 
include('../inc/config.php');
if (empty($_SESSION['user_id'])) {
  header("Location: ../Auth/user_login");

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $app_name; ?> | Drug Recommendation</title>
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
            <h1>Drug Recommendation</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Drug Recommendation</li>
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
                <h3 class="card-title">Create Drug Recommendation</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
                 <form action="predict.php" method="POST">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="patient_id">Patient Name</label>
                        <select name="cmdpatient_id" id="cmdpatient_id" class="form-control" required>
                          <option value="">-- Select Patient --</option>
                          <?php
                          $patients = mysqli_query($conn, "SELECT id, name FROM patients");
                          while ($row = mysqli_fetch_assoc($patients)) {
                            $selected = (isset($_POST['patient_id']) && $_POST['patient_id'] == $row['id']) ? 'selected' : '';
                            echo "<option value=\"{$row['id']}\" $selected>{$row['name']}</option>";
                          }
                          ?>
                        </select>
                      </div>
                    
                      <!-- Symptoms -->
                     <div class="form-group">
                    <label for="exampleInputEmail1">Symptom 1</label>
                        <select name="symptom1" id="symptom1" class="form-control" required>
                          <option value="">-- Select Symptom --</option>
                          <?php
                          $patients = mysqli_query($conn, "SELECT id, name FROM symptoms");
                          while ($row = mysqli_fetch_assoc($patients)) {
                            echo "<option value=\"{$row['name']}\" $selected>{$row['name']}</option>";
                          }
                          ?>
                        </select>                   
                      </div>
                    <div class="form-group">
                    <label for="exampleInputEmail1">Symptom 2</label>
                  <select name="symptom2" id="symptom2" class="form-control" required>
                          <option value="">-- Select Symptom --</option>
                          <?php
                          $patients = mysqli_query($conn, "SELECT id, name FROM symptoms");
                          while ($row = mysqli_fetch_assoc($patients)) {
                            echo "<option value=\"{$row['name']}\" $selected>{$row['name']}</option>";
                          }
                          ?>
                        </select>             
                            </div>
                    
                     <div class="form-group">
                    <label for="exampleInputEmail1">Symptom 3</label>
                    <select name="symptom3" id="symptom3" class="form-control" required>
                          <option value="">-- Select Symptom --</option>
                          <?php
                          $patients = mysqli_query($conn, "SELECT id, name FROM symptoms");
                          while ($row = mysqli_fetch_assoc($patients)) {
                            echo "<option value=\"{$row['name']}\" $selected>{$row['name']}</option>";
                          }
                          ?>
                        </select>               
                          </div>
                      
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" name="btnadd" class="btn btn-primary">Save Recommendation</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (left) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong><?php include('partials/footer.php'); ?></strong>
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

<?php include('partials/bottom-script.php'); ?>

</body>
</html>
