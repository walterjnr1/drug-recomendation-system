   
     
    <!-- Brand Logo -->
    <a href="index" class="brand-link">
    <img src="../<?php echo $app_logo; ?>" alt="app Logo" class="brand-image img-circle elevation-3" style="opacity: .8; width: 100px; height: 200px;">
      <span class="brand-text font-weight-light"><?php echo $app_name; ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                       <li class="nav-item">
         <a href="index" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>Dashboard</p>
               </a>
             </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Account Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="add_user" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>New User</p>
                </a>
              </li>
             
              <li class="nav-item">
                <a href="user_record" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>User Record</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="change_password" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Change Password</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="profile" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Profile</p>
                </a>
              </li>

            </ul>
          </li>
               
            
              <li class="nav-item">
            <a href="#" class="nav-link">
          <i class="nav-icon fas fa-vial"></i>
              <p>Drug Recommendation Management<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="recommend" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Drug Recommendation</p>
                </a>
              </li>
                 <li class="nav-item">
                <a href="recommendation_record" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Recommendation Record</p>
                </a>
              </li>
              </ul>
          </li>
           
          <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
              <p>Patient Management<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="student_record" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Student Record</p>
                </a>
              </li>
   
              </ul>
          </li>


            <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
              <p>Symptom Management<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="add_symptom" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add symptoms</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="symptom_record" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>symptoms Record</p>
                </a>
              </li>
              </ul>
          </li>


          <li class="nav-item">
            <a href="logout" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Logout
              </p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
