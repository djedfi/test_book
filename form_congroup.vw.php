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
        <a class="nav-link" href="index_group.php">
          <i class="fas fa-fw fa-people-carry"></i>
          <span>Groups</span>
        </a>
      </li>
      <li class="nav-item ">
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
          <h1 class="h3 mb-2 text-gray-800">Contacts in the Group: <span id="id_div_name_group" class="text-uppercase font-weight-bold"></span></h1>
          <p class="mb-4">All <b>Contacts</b> added in the group.</p>

          <input type="hidden" name="id_hid_idgroup" id="id_hid_idgroup" value=<?php echo isset($_REQUEST['id'])?$_REQUEST['id'] : 0?>>
          <div class="row">
            <div class="col-md-6 mb-3 text-center">
                <button type="button" class="btn btn-success btn-lg btn-block" id="id_btn_add_contact_book">Add Contacts from Contacts Book</button>
            </div>
            <div class="col-md-6 mb-3 text-center">
                <button type="button" class="btn btn-success btn-lg btn-block" id="id_btn_add_contact_group">Add Contacts from Groups</button>
            </div>
          </div>

          <div class="row">

            <div class="card text-white border-primary" style="margin: 0 auto; float: none; margin-bottom: 10px;">
                <div class="card-header text-white bg-primary">
                  <i class="fas fa-user-plus"></i>&nbsp;Added Contacts
                </div>
                <div class="card-body text-primary">
                    <h5 class="card-title font-weight-bold">Contacts inserted from Book </h5>
                    <div class="table-responsive">
                        <table class="table table-hover table-warning table-bordered text-center" id="id_tbl_contact_dir" width="100%" cellspacing="0">
                            <thead class="thead-dark">
                            <tr>
                                <th>Full name</th>
                                <th>Email</th>
                                <th>City</th>
                                <th>Option</th>
                            </tr>
                            </thead>
                            <tbody id="id_tbl_body_contact_dir">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-primary">
                    <h5 class="card-title font-weight-bold">Contacts inserted from Groups</h5>
                    <div class="table-responsive">
                        <table class="table table-hover table-primary table-bordered text-center" id="id_tbl_contact_inh" width="100%" cellspacing="0">
                            <thead class="thead-dark">
                            <tr>
                                <th>Full name</th>
                                <th>Email</th>
                                <th>From</th>
                                <th>Option</th>
                            </tr>
                            </thead>
                            <tbody id="id_tbl_body_contact_inh">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


          </div>

        </div>
        <!-- /.container-fluid -->


        <!-- Modals added to page -->
        <!-- Modals will show the contacts could add in the group -->
        <div class="modal fade" id="id_modal_add_cont_book" tabindex="-1" role="dialog" aria-labelledby="id_modal_add_cont_bookTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="id_modal_add_cont_bookLongTitle"><i class="fas fa-address-book"></i>&nbsp;Add Contacts from Contacts Book</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p class="mb-4">Click on any contact to add the group</p>
                <table class="table table-hover table-active table-bordered text-center" id="id_tbl_modal_add_cont_book" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Full name</th>
                        <th>Email</th>
                    </tr>
                    </thead>
                    <tbody id="id_tbl_body_modal_add_cont_book">
                        
                    </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <!-- Modals will show the contacts could add in the group but these contacts belong to a group. -->

        <div class="modal fade" id="id_modal_add_cont_group" tabindex="-1" role="dialog" aria-labelledby="id_modal_add_cont_groupTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="id_modal_add_cont_groupLongTitle"><i class="fas fa-user-friends"></i>&nbsp;Add Contact from a Group</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                    <p class="mb-4">Choose a Group: 
                        <select class="custom-select" name="id_sel_group_ex" id="id_sel_group_ex">
                                    <option selected disabled value="">Choose...</option>
                        </select><br>
                        <small class="form-text text-muted">
                          - The rows with red background do not add, because they are already added.<br>
                          - Click on any row to add or Click on the button: Add all Contacts, to add all of them.
                        </small>
                    </p>
                    <table class="table table-hover table-active table-bordered text-center" id="id_tbl_modal_add_cont_group" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Full name</th>
                            <th>Email</th>
                        </tr>
                        </thead>
                        <tbody id="id_tbl_body_modal_add_cont_group">
                            
                        </tbody>
                    </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="id_btn_all_contacts_to_group">Add all Contacts</button>
              </div>
            </div>
          </div>
        </div>


        <div class="modal fade" id="modal_save_add_error" tabindex="-1" role="dialog" aria-labelledby="modal_save_errorTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modal_save_errorLongTitle">Error</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                The contact was not added to group.
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="id_btn_save_error_add">Close</button>
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="modal_save_del_error" tabindex="-1" role="dialog" aria-labelledby="modal_save_del_errorTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modal_save_del_errorLongTitle">Error</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                The contact was not deleted from group.
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="id_btn_save_error_del">Close</button>
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
   <!--  -->
   <script src="js/form_congroup.js"></script>
</body>

</html>
