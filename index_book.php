<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>ADDBOOK - Dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index_book.php">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-layer-group"></i>
        </div>
        <div class="sidebar-brand-text mx-3">ADD-BOOK<sup>1</sup></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item ">
        <a class="nav-link" href="index_city.php">
          <i class="fas fa-fw fa-city"></i>
          <span>Cities</span>
        </a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="index_book.php">
          <i class="fas fa-fw fa-table"></i>
          <span>Contacts</span>
        </a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
        <br>
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <h1 class="h3 mb-2 text-gray-800">List of Contacts</h1>
          <p class="mb-4">This tabla has all <b>Contacs</b> added in the Address-Book. Click on any row to update.</p>
          <br>
          <div class="card shadow mb-4 text-right">
              <div class="card-header py-3">
                <a href="#" class="btn btn-sm btn-primary shadow-sm" id="id_btn_export_xml">
                  <i class="fas fa-print fa-sm text-white-50"></i> Export to XML
                </a>
                <a href="#" class="btn btn-sm btn-primary shadow-sm" id="id_btn_export_json">
                  <i class="fas fa-print fa-sm text-white-50"></i> Export to JSON
                </a>
                <a href="new_addrbook.vw.php" class="btn btn-sm btn-success shadow-sm">
                  <i class="fas fa-newspaper fa-sm text-white-50"></i> Add Contacts
                </a>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="tbl_data_addrbook" width="100%" cellspacing="0">
                    <thead class="text-center">
                      <tr>
                        <th>Last name</th>
                        <th>First name</th>
                        <th>City</th>
                        <th>Email</th>
                        <th>Zip Code</th>
                        <th>Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
      <iframe id="id_download" border="0" style="display: none"></iframe>

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; EdFi 2020</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

   <!--  -->
   <script src="js/index_addrbook.js"></script>
</body>

</html>
