<?php
session_start();
$con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
// $notelp = $_SESSION['notelp'];
if (isset($_COOKIE['notelp'])) {
    $notelp = $_COOKIE['notelp'];
}
$user = mysqli_query($con, "SELECT * FROM users WHERE nomor_telp=$notelp AND status_kerja = 1 AND jabatan = 1");
$cekuser = mysqli_fetch_assoc($user);
if ($cekuser > 0) {
    $id_users = $cekuser['id'];
    $nama = $cekuser['nama'];
    $cookies = mysqli_query($con, "SELECT * FROM cookies WHERE id_users=$id_users");
    $cekcookies = mysqli_fetch_assoc($cookies);
    if ($cekcookies > 0) {
        $nomor_telepon = $cekcookies['nomor_telepon'];
        $time = $cekcookies['time'];
        setcookie('notelp', $nomor_telepon, time() + $time, '/');
        if ($nomor_telepon == "") {
            header("location:../index.php");
        }
    }
} else {
    setcookie('notelp', '', time() + $time, '/');
    header("location:../index.php");
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Kelola Karyawan</title>

    <link href="assets/css/bootstrap 4.5.2.css" rel="stylesheet" crossorigin="anonymous">
    <link href="assets/css/dataTables bootstrap 4 min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="assets/css/all v5.7.2.css" rel="stylesheet" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="dashboard.css">
    <script defer src="assets/js/solid v5.0.13.js" crossorigin="anonymous"></script>
    <script defer src="assets/js/fontawesome v5.0.13.js" crossorigin="anonymous"></script>
    <script src="assets/js/jquery 3.5.1.js" crossorigin="anonymous"></script>
    <script src="assets/js/jquery dataTables 1.11.4 .min.js" crossorigin="anonymous"></script>
    <script src="assets/js/dataTables 1.11.4 bootstrap 4 min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/sweetalert2 7.33.1 min.css">
    <script src="assets/js/jquery.mCustomScrollbar.concat.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/jquery.mCustomScrollbar.min.css">
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <img src="../images/Logo PT. ASL.png" width="180px">
            </div>

            <ul class="list-unstyled components">
                <li>
                    <a href="dashboard.php" style="font-size: 16px;">Dashboard</a>
                </li>
                <li>
                    <a href="daftardatakaryawan.php" style="font-size: 16px;">Daftar Data Karyawan</a>
                </li>
                <li>
                    <?php
                    $pengajuan = mysqli_query($con, "SELECT * FROM pengajuan WHERE status = 'proses'");
                    $cekpengajuan = mysqli_fetch_assoc($pengajuan);
                    if ($cekpengajuan > 0) {
                    ?>
                        <a href="daftarpengajuanizin.php" style="font-size: 16px;"><span style="width: 5px; height: 5px; margin-right: 10px; border-radius: 10px;" class="notif" id="notif">&nbsp;&nbsp;</span>Daftar Pengajuan Izin</a>
                    <?php
                    } else {
                    ?>
                        <a href="daftarpengajuanizin.php" style="font-size: 16px;">Daftar Pengajuan Izin</a>
                    <?php
                    }
                    ?>
                </li>
                <li class="active">
                    <a href="#presensiSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" style="font-size: 16px;"><i class="fa fa-bars" aria-hidden="true"></i> &nbsp; Presensi Karyawan</a>
                    <ul class="collapse list-unstyled" id="presensiSubmenu">
                        <li style="color: white;">
                            <a href="presensimasukpagi.php">Presensi Datang dan Pulang </a>
                        </li>
                        <li style="color: #02b0bd;">
                            <a href="presensikeluaristirahat.php"><b>Presensi Keluar Masuk Istirahat</b></a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#penggajianSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" style="font-size: 16px;"><i class="fa fa-bars" aria-hidden="true"></i> &nbsp; Penggajian Karyawan</a>
                    <ul class="collapse list-unstyled" id="penggajianSubmenu">
                        <li>
                            <a href="historidendalain.php">Data Denda Lain - Lain</a>
                        </li>
                        <li>
                            <a href="historiperubahangaji.php">Histori Perubahan Gaji Pokok</a>
                        </li>
                        <li>
                            <a href="gajikaryawan.php">Gaji Karyawan</a>
                        </li>
                        <li>
                            <a href="daftarhistoripenggajian.php">Histori Penggajian Karyawan</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#pengaturanSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" style="font-size: 16px;"><i class="fa fa-bars" aria-hidden="true"></i> &nbsp; Pengaturan Perusahaan</a>
                    <ul class="collapse list-unstyled" id="pengaturanSubmenu">
                        <li>
                            <a href="bpjs.php">BPJS</a>
                        </li>
                        <li>
                            <a href="rekening.php">Rekening Perusahaan</a>
                        </li>
                        <li>
                            <a href="daftardenda.php">Denda Terlambat</a>
                        </li>
                    </ul>
                </li>
            </ul>

            <ul class="list-unstyled CTAs">
                <li>
                    <a class="article logout">Logout</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light navbar1">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <!-- <i class="fas fa-align-justify"></i> -->
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <div id="tulisan_header"><a href="home.php">PT. Aman Samudera Lines</a></div>


                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item" style="margin-right: 5px; margin-top: 5px;">
                                <img src="../images/icon-people2.png" class="img-circle" style="width: 30px;" alt="User Image" />
                            </li>
                            <li class="nav-item" style="margin-top: 7px;">
                                <?php echo "$nama"; ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <input hidden class="notelp" value="<?php echo $notelp  ?>">


            <div class="isi">
                <div class="preloader">
                    <div class="loading">
                        <img src="../images/loading2.gif" width="100%">
                    </div>
                </div>
                <div style="margin-bottom: 100px;">
                    <center>
                        <h1>Daftar Presensi Keluar Masuk Istirahat</h1>
                    </center>
                </div>
                <div class="wadahtampil">
                    <div class="tablepresensikeluaristirahat tampiltabel">

                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script src="assets/js/bootstrap 4.1.0 min.js" crossorigin="anonymous"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> -->
    <script src="assets/js/popper 1.14.0 min.js" crossorigin="anonymous"></script>
    <script src="assets/js/sweetalert2 7.33.1 min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(".preloader").fadeOut();
            $('.tablepresensikeluaristirahat').load("tampildaftarpresensikeluarmasukistirahat.php");
            $("#sidebar").mCustomScrollbar({
                scrollButtons: {
                    enable: true
                },
                theme: "minimal",
                scrollInertia: 500,
                scrollEasing: "easeInOut"
            });
            $('#sidebarCollapse').on('click', function() {
                $(this).toggleClass('active');
                $('#sidebar, #content').toggleClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });

            $('.logout').click(function() {
                var notelp = $('.notelp').val();
                $.ajax({
                    url: "ajaxlogout.php",
                    method: "post",
                    data: {
                        notelp: notelp
                    },
                    success: function(data) {
                        if (data == "Akun berhasil di logout") {
                            Swal.fire({
                                title: 'Yeah',
                                html: 'Akun berhasil di logout',
                                type: 'success'
                            }).then((result) => {
                                if (result.value) {
                                    document.cookie = "notelp=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                                    document.location.href = '../index.php';
                                }
                            })
                        } else if (data == "Akun gagal logout") {
                            Swal.fire({
                                title: 'Login Gagal',
                                html: 'Akun gagal logout',
                                type: 'error'
                            })
                        }
                    }
                })
            });
        });
    </script>
</body>

</html>