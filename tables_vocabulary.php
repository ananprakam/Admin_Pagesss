<?php
require_once("connection.php");

// เริ่มเซสชัน
session_start();

if (isset($_REQUEST["delete_id"])) {
    $id = $_REQUEST["delete_id"];

    // เลือกบันทึกที่จะลบ
    $select_stmt = $conn->prepare("SELECT * FROM vocabularydata WHERE id = :id");
    $select_stmt->bindParam(":id", $id);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

    // ตรวจสอบว่ามีบันทึกหรือไม่ก่อนที่จะลบ
    if ($row) {
        // ลบบันทึกออกจากฐานข้อมูล
        $delete_stmt = $conn->prepare("DELETE FROM vocabularydata WHERE id = :id");
        $delete_stmt->bindParam(":id", $id);
        if ($delete_stmt->execute()) {
            // ตั้งค่าตัวแปรเซสชันสำหรับข้อความสำเร็จ
            $_SESSION['delete_success'] = true;
        } else {
            // ตั้งค่าตัวแปรเซสชันสำหรับข้อความข้อผิดพลาดหากการลบล้มเหลว
            $_SESSION['delete_error'] = true;
        }
    } else {
        // ตั้งค่าตัวแปรเซสชันสำหรับข้อความข้อผิดพลาดหากไม่พบบันทึก
        $_SESSION['delete_error'] = true;
    }

    // ส่งกลับไปที่ tables_vocabulary.php
    header("Location: tables_vocabulary.php");
    exit(); // รับรองว่าการสคริปต์จะหยุดทำงานหลังจากการเปลี่ยนเส้นทาง
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Vocabulary - Tables</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-wind"></i>
                </div>
                <div class="sidebar-brand-text mx-3">CW Admin </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">



            <!-- Heading -->
            <div class="sidebar-heading">
                Addons
            </div>




            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="tables_users.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables - Users</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="tables_vocabulary.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables - Vocabulary</span></a>
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

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>

                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Tables Vocabulary</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">

                            <a href="add_vocabulary.php" class="btn btn-success">Add New</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>English_word</th>
                                            <th>thai_word</th>
                                            <th>Edit Name</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $select_stmt = $conn->prepare("SELECT * FROM vocabularydata");
                                        $select_stmt->execute();

                                        while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                                        ?>

                                            <tr>
                                                <td><?php echo $row["english_word"] ?></td>
                                                <td><?php echo $row["thai_word"] ?></td>
                                                <td><a href="edit_vocabulary.php?update_id=<?php echo $row["id"]; ?>" class="btn btn-warning">Edit</a></td>
                                                <td><a data-id="<?php echo $row["id"]; ?>" href="?delete_id=<?php echo $row["id"]; ?>" class="btn btn-danger delete-btn">Delete</a></td>

                                            </tr>

                                        <?php } ?>
                                    </tbody>


                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
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

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
       $('.delete-btn').click(function(e) {
    e.preventDefault();
    var delete_id = $(this).data('id');
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        
    }).then((result) => {
    if (result.isConfirmed) {
        // แสดงข้อความ deleted successfully! ก่อนที่จะทำการ redirect
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Deleted successfully!',
            timer: 5000 // 5000 มิลลิวินาที (หรือ 5 วินาที)
        });

        // รอ 5 วินาทีก่อนที่จะทำการ redirect
        setTimeout(() => {
            window.location = "?delete_id=" + delete_id;
        }, 1000);
    }
})

});

    </script>




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
    <script src="js/demo/datatables-demo.js"></script>

</body>

</html>