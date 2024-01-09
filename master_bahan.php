<?php
$serverName = "localhost";
$userName = "root";
$password = "";
$dbName = "databaseinventory";

$conn = new mysqli($serverName, $userName, $password, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stockQuantity = ""; // Default value, replace it with the actual stock quantity based on the selected item from the database

if (isset($_POST['quantity'])) {
    $selectedItemId = $_POST['selectedItem'];
    // Fetch the stock quantity from the database based on the selected item
    $query = "SELECT quantity FROM stokbahan WHERE stok_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $selectedItemId);
    $stmt->execute();
    $stmt->bind_result($stockQuantity);
    $stmt->fetch();
    $stmt->close();

    // Check if the submitted quantity is greater than the available stock
    $submittedQuantity = $_POST['quantity'];
    if ($submittedQuantity > $stockQuantity) {
        // Quantity exceeds available stock, handle accordingly (e.g., show an error message)
        echo "Stok bahan tidak mencukupi.";
        exit();
    } elseif ($submittedQuantity == "") {
        echo "$stockQuantity";
        exit();
    } elseif ($submittedQuantity <= 0) {
        echo "Kuantitas yang dimasukkan harus lebih besar dari";
        exit();
    }

    // Return the updated stock quantity
    echo $stockQuantity;
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Master Bahan</title>

    <link rel="icon" href="assets/adminlte/dist/img/OWLlogo.png" type="image/x-icon">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/adminlte/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/adminlte/dist/css/adminlte.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Sweetalert2 -->
    <link rel="stylesheet" href="assets/adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

    <style>
        .input-group-append label {
            margin-right: 24px;
        }
    </style>


</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="homepage.php" class="brand-link">
                <img src="assets/adminlte/dist/img/OWLlogo.png" alt="OWL Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-heavy">OWL RnD</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="./homepage.php" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Home</p>
                            </a>
                        </li>
                        </li>
                        <li class="nav-header">TRANSAKSI</li>
                        <li class="nav-item">
                            <a href="produksi.php" class="nav-link">
                                <i class="nav-icon fas fa-toolbox"></i>
                                <p>
                                    Produksi
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="maintenance.php" class="nav-link">
                                <i class="nav-icon fas fa-wrench"></i>
                                <p>
                                    Maintenance
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="restock.php" class="nav-link">
                                <i class="nav-icon fas fa-shopping-cart"></i>
                                <p>
                                    Restock
                                </p>
                            </a>
                        </li>
                        <li class="nav-header">TAMBAH DATA</li>
                        <li class="nav-item">
                            <a href="master_bahan.php" class="nav-link active">
                                <i class="nav-icon fa fa-pen"></i>
                                <p>
                                    Master Bahan
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="master_device.php" class="nav-link">
                                <i class="nav-icon fas fa-cube"></i>
                                <p>
                                    Master Device
                                </p>
                            </a>
                        </li>
                        <li class="nav-header">PELAPORAN</li>
                        <li class="nav-item">
                            <a href="laporan_stok.php" class="nav-link">
                                <i class="nav-icon ion ion-pie-graph"></i>
                                <p>
                                    Laporan Stok
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Master Bahan</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="homepage.php">Home</a></li>
                                <li class="breadcrumb-item active">Master Bahan</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Menambah Jenis Master Bahan</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="masterBahanForm">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label for="pilihNamaKelompok">Pilih Kelompok : <span style="color: red;">*</span></label>
                                        </div>
                                        <div class="col-auto">
                                            <button class="btn btn-xs btn-success" type="button" onclick="tambahKelompok()">Tambah Kelompok Baru</button>
                                        </div>
                                    </div>
                                    <select class="custom-select form-control-border border-width-2" id="pilihNamaKelompok" name="selectedItem" searchable="Search here...">
                                        <option value="" selected disabled>Pilih Kelompok</option>
                                        <option value="1">Resistor</option>
                                        <option value="10">Kapasitor</option>
                                        <option value="11">Sensor</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="namaBahan">Nama Bahan : <span style="color: red;">*</span></label>
                                    <input type="text" class="form-control form-control-border border-width-2" id="namaBahan" placeholder="Masukkan nama bahan">
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Kuantitas : <span style="color: red;">*</span></label>
                                    <div class="input-group">
                                        <!-- Input untuk kuantitas -->
                                        <input type="number" class="form-control" id="quantity" name="quantity" min="0" value="" placeholder="Masukkan jumlah stok bahan">

                                    </div>
                                </div>
                                <p id="stockMessage">Stok Bahan Tersisa: <?php echo $stockQuantity; ?></p>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea class="form-control" rows="3" placeholder="Masukkan keterangan bahan ..."></textarea>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </form>
                        <div class="card-footer d-flex justify-content-end">
                            <button type="button" class="btn btn-primary" onclick="if(validateForm()) {validateAndFetchStock(); resetForm()}">Submit</button>
                        </div>
                    </div>
                    <!-- general form elements -->
                    <!-- /.card -->

                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->


        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="assets/adminlte/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- bs-custom-file-input -->
    <script src="assets/adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- AdminLTE App -->
    <script src="assets/adminlte/dist/js/adminlte.min.js"></script>
    <!-- SweetAlert2 Toast -->
    <script src="assets/adminlte/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Page specific script -->
    <script>
        $(function() {
            bsCustomFileInput.init();

            // Add an event listener to the select element
            $("#pilihBahanMaintenance").change(function() {
                validateAndFetchStock();
            });
        });

        function validateForm() {
            var pilihNamaKelompok = document.getElementById("pilihNamaKelompok").value;
            var namaBahan = document.getElementById("namaBahan").value;
            var quantity = document.getElementById("quantity").value;

            if (pilihNamaKelompok === "" || namaBahan === "" || quantity === "" || quantity <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Harap lengkapi semua form!',
                });
                return false;
            }

            return true;
        }

        function updateStockMessage() {
            var stockMessage = document.getElementById("stockMessage");
            var selectedQuantity = parseInt(document.getElementById("quantity").value, 10);

            // Update stock message dynamically based on the selected item's stock quantity
            stockMessage.innerText = "Stok Bahan Tersisa: " + (<?php echo $stockQuantity; ?> - selectedQuantity);
        }

        function validateAndFetchStock() {
            // Get the form data
            var formData = $("#maintenanceForm").serialize();

            // Use AJAX to submit the form data and fetch the updated stock quantity
            $.ajax({
                type: "POST",
                url: "maintenance.php",
                data: formData,
                success: function(response) {
                    // Update the stock message with the fetched quantity
                    document.getElementById("stockMessage").innerText = "Stok Bahan Tersisa: " + response;
                },
                error: function(error) {
                    alert("Error fetching stock quantity.");
                }
            });
        }

        function resetForm() {
            document.getElementById("masterBahanForm").reset();
        }
    </script>
</body>

</html>