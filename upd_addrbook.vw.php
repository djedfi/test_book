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
      <li class="nav-item">
        <a class="nav-link" href="index_group.php">
          <i class="fas fa-fw fa-people-carry"></i>
          <span>Groups</span>
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
          <h1 class="h3 mb-2 text-gray-800">Update Contact</h1>
          <p class="mb-4">Fill up the next form to update a  Contact.</p>
          <br>
          <div class="card shadow mb-4">
              <div class="card-body">
                <form class="needs-validation" id="id_form_addrbook" novalidate>
                <input type="hidden" name='opt' id='opt' value='5'>
                <input type="hidden" name='id' id='id' value=<?php echo isset($_REQUEST['id'])?$_REQUEST['id'] : 0?>>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="id_txt_lname">Last Name</label>
                            <input type="text" class="form-control text-uppercase" name="id_txt_lname" id="id_txt_lname" pattern="[a-zA-Z\s]+" minlength="1" maxlength="150" required>
                            <div class="valid-feedback">
                                
                            </div>
                            <div class="invalid-feedback">
                                Please provide a Lasta Name.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="id_txt_fname">First Name</label>
                            <input type="text" class="form-control text-uppercase" name="id_txt_fname" id="id_txt_fname" pattern="[a-zA-Z\s]+" minlength="1" maxlength="150" required>
                            <div class="valid-feedback">
                                
                            </div>
                            <div class="invalid-feedback">
                                Please provide a First Name.
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="id_sel_country">Choose City</label>
                            <select class="custom-select" name="id_sel_city" id="id_sel_city" required>
                                <option selected disabled value="">Choose...</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a valid City.
                            </div>
                            <div class="valid-feedback">
                                
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="id_txt_zip">Zip Code</label>
                            <input type="text" class="form-control text-uppercase" name="id_txt_zip" id="id_txt_zip" maxlength="10" required>
                            
                            <div class="valid-feedback">
                                
                            </div>
                            <div class="invalid-feedback">
                                Check possible errors:<br>
                                - This input is required<br>
                                - Your value does not match with the format.
                            </div>
                        </div>

                        



                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="id_txta_street">Street</label>
                            <textarea class="form-control text-uppercase" name="id_txta_street" id="id_txta_street" rows="3" maxlength="350"></textarea>
                            <div class="valid-feedback">
                                
                            </div>
                            <div class="invalid-feedback">
                                Please provide a valid Street.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="id_txt_email">Email</label>
                            <input type="email" class="form-control" name="id_txt_email" id="id_txt_email"  maxlength="250" required>
                            <div class="valid-feedback">
                                
                            </div>
                            <div class="invalid-feedback">
                                Please provide a valid EMail.
                            </div>
                        </div>
                    </div>

                    <div class="form-row">

                        <div class="col-md-12 mb-3">
                            <label for="id_txt_email">Tags (separated by comma)</label>
                            <input type="text" class="form-control" name="id_txt_tags" id="id_txt_tags" pattern="[a-zA-Z\s,]+" required>
                            <div class="valid-feedback">
                                
                            </div>
                            <div class="invalid-feedback">
                                Please input some tags, separated by comma
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-primary" id="id_btn_save" type="button">Save</button>
                </form>
              </div>
            </div>
          </div>
        <!-- /.container-fluid -->



        <div class="modal fade" id="modal_save_info" tabindex="-1" role="dialog" aria-labelledby="modal_save_infoTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modal_save_infoLongTitle">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                The data was updated successfully.
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-info" id="id_btn_save_info">Close</button>
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="modal_save_error" tabindex="-1" role="dialog" aria-labelledby="modal_save_errorTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modal_save_errorLongTitle">Error</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                The data was not updated.
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="id_btn_save_error">Close</button>
              </div>
            </div>
          </div>
        </div>        

      </div>
      <!-- End of Main Content -->

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

  <!-- Page level custom scripts -->
  <script src="js/form_upd_addrbook.js"></script>
</body>

</html>
