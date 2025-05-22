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
  <title><?php echo $app_name; ?> | Recommendation Record</title>
  <?php include('partials/head.php') ;?>
  
<script type="text/javascript">
function deldata(){
if(confirm("ARE YOU SURE YOU WISH TO DELETE THIS RECOMMENDATION ?" ))
{
return  true;
}
else {return false;
}
	 
}
</script>
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
            <h1></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index">Home</a></li>
              <li class="breadcrumb-item active">Recommendation Record</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- /.card -->
       <div class="card">
              <div class="card-header">
                <div>
                  <h5>This Table contains data about Recommendation</h5>
                  <a href="recommend"><button type="submit" name="btnadd" class="btn btn-primary">New Drug Recommendation</button></a>
                  </div>
                <h3 class="card-title">&nbsp;</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>s/n</th>
                    <th>Patient</th>
                    <th>Symptoms</th>
                    <th>Recommended Drug</th>
                    <th>Date recommended</th>
                    <th>Outcome</th>
                    <th>Action</th>

                  </tr>
                  </thead>
                  <tbody>
<?php
        $sql = "SELECT r.id, r.symptoms, r.recommended_drug, r.date_recommended, r.outcome, p.name AS patient_name, p.email AS patient_email
                FROM recommendations r JOIN patients p ON r.patient_id = p.id ORDER BY r.id DESC";
        $result = $conn->query($sql);
        $cnt=1;
        while($row = $result->fetch_assoc()) {

        ?>
<tr>
  <td><?php echo $cnt ?></td>
  <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
  <td><?php echo htmlspecialchars($row['symptoms']); ?></td>
  <td><?php echo htmlspecialchars($row['recommended_drug']); ?></td>
  <td><?php echo htmlspecialchars($row['date_recommended']); ?></td>
  <td>
    <?php
      if (($row['outcome']) === 'Effective') {
        echo "<strong style='color: green;'>" . htmlspecialchars($row['outcome']) . "</strong>";
      } else {
        echo "<span style='color: red;'>" . htmlspecialchars($row['outcome']) . "</span>";
      }
    ?>
  </td>
  <td>
    <a href="delete_recommendation.php?id=<?php echo $row['id'];?>" onClick="return deldata();">
      <i class="fa fa-trash" aria-hidden="true" title="Delete Record"></i>
    </a>
    
  </td>
</tr>
<?php $cnt=$cnt+1;} ?>

                  </tbody>
                  <tfoot>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
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

<!-- jQuery -->
<?php include('partials/bottom-script.php') ;?>

</body>
</html>
