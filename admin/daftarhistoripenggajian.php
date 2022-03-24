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
        if($cekcookies > 0){
            $nomor_telepon = $cekcookies['nomor_telepon'];
            $time = $cekcookies['time'];
            setcookie('notelp', $nomor_telepon, time() + $time, '/');
            if($nomor_telepon == ""){
                header("location:../index.php");
            }
        }
    }
    else{
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
    <link href="assets/css/select2 4.1.0 min.css" rel="stylesheet" />
    <script src="assets/js/select2 4.1.0 min.js"></script>
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
                        if($cekpengajuan > 0){
                            ?>
                                <a href="daftarpengajuanizin.php" style="font-size: 16px;"><span style="width: 5px; height: 5px; margin-right: 10px; border-radius: 10px;" class="notif" id="notif">&nbsp;&nbsp;</span>Daftar Pengajuan Izin</a>
                            <?php
                        }else{
                            ?>
                                <a href="daftarpengajuanizin.php" style="font-size: 16px;">Daftar Pengajuan Izin</a>
                            <?php
                        }
                    ?>
                </li>
                <li>
                    <a href="#presensiSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" style="font-size: 16px;">Daftar Presensi Karyawan</a>
                    <ul class="collapse list-unstyled" id="presensiSubmenu">
                        <li>
                            <a href="presensimasukpagi.php">Presensi Datang dan Pulang</a>
                        </li>
                        <li>
                            <a href="presensikeluaristirahat.php">Presensi Keluar Masuk Istirahat</a>
                        </li>
                    </ul>
                </li>
                <li class="active">
                    <a href="#penggajianSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" style="font-size: 16px;">Daftar Penggajian</a>
                    <ul class="collapse list-unstyled" id="penggajianSubmenu">
                        <li>
                            <a href="historidendalain.php">Histori Denda Lain - Lain</a>
                        </li>
                        <li style="color: white;">
                            <a href="historiperubahangaji.php">Histori Perubahan Gaji Pokok</a>
                        </li>
                        <li style="color: white;">
                            <a href="gajikaryawan.php">Gaji Karyawan</a>
                        </li>
                        <li style="color: #02b0bd;">
                            <a href="daftarhistoripenggajian.php">Histori Penggajian Karyawan</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#pengaturanSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" style="font-size: 16px;">Pengaturan Perusahaan</a>
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

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
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
            <input hidden class="id_users" value="<?php echo $id_users  ?>">
            

            <div>
                <div class="preloader">
                    <div class="loading">
                        <img src="../images/loading2.gif" width="100%">
                    </div>
                </div>
                <div><center><h1>Histori Penggajian Karyawan</h1></center></div>
                <button class="btn btn-primary pilih" style="margin-top: 50px; margin-bottom: 10px;">Export Data Penggajian Dalam Bentuk CSV</button>
                <div class="tablehistoripenggajian">
                    
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Export Data Penggajian</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method='get' action='exportcsv.php' id="pilihbulan">
                            <div class="mb-3 judulfile">
                                <div class="form-group"> 
                                    <label class="form-label" style="font-size: 14px;">Judul File<span class="text-danger">*</span> </label> 
                                    <input type="text" class="form-control judul_file" id="judul_file" name="judul_file" style="font-size: 12px;" /> 
                                </div>
                            </div>
                            <div class="mb-3 tglexport">
                                <label class="form-label" style="font-size: 14px;">Bulan Input Penggajian<span class="text-danger">*</span> </label> 
                                <input type="month" class="form-control tgl_export" id="tgl_export" name="tgl_export" style="font-size: 12px;" />
                            </div>
                            <div class="mb-3 rekening">
                                <div class="form-group"> 
                                    <label class="form-label" style="font-size: 14px; width: 100%;">Pilih Rekening<span class="text-danger">*</span> </label>
                                    <select class="form-control rekenings" name="rekenings" id="rekenings" style="width: 100%; font-size: 12px;">
                                    <option value="">-- Pilih Rekening --</option>
                                        <?php
                                            $rekening = mysqli_query($con, "SELECT * FROM rekening");
                                            if (mysqli_num_rows($rekening) > 0) {
                                                while ($data = mysqli_fetch_array($rekening)) {
                                                    $nama_bank = $data['nama_bank'];
                                                    $atas_nama = $data['atas_nama'];
                                                    $no_rekening = $data['no_rekening'];
                                                    $id_rekening = $data['id'];
                                        ?>
                                        <option value="<?php echo $id_rekening; ?>"><?php echo $nama_bank; ?> - <?php echo $atas_nama; ?> - <?php echo $no_rekening; ?></option>
                                        <?php 
                                            }}
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer d-block">
                                <button type="button" class="btn float-right blues export" onclick="download()" style="font-size: 14px;">Export</button>
                            </div>
                        </form>
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
        $(document).ready(function () {
            $('.tablehistoripenggajian').load("tampildaftarhistoripenggajian.php");
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>

    <script>
        
        function download(){
            var tgl_export = $('.tgl_export').val();
            var judul_file = $('.judul_file').val();
            var rekenings = $('.rekenings').val();
            if(tgl_export == "" || judul_file == "" || rekenings == ""){
                Swal.fire({
					title: 'Gagal Export Data Penggajian',
					html: 'Data Harus Terisi Semua',
					type: 'error'
				})
            }else{
                $.ajax({
                    url: "ajaxexportcsv.php",
                    method: "post",
                    data: {
                        tgl_export: tgl_export
                    },
                    success: function(data) {
                        if(data == "Export Data Penggajian Berhasil"){
                            $('#pilihbulan').submit();
                            document.getElementById('tgl_export').value = '';
                            document.getElementById('judul_file').value = '';
                            document.getElementById('rekenings').value = '';
                            $("#modalForm").modal('hide');
                            
                        }else if(data == "Data Penggajian Bulan Ini Belum Tersedia"){
                            Swal.fire({
                                title: 'Gagal Export Data Penggajian',
                                html: 'Data Penggajian Bulan yang Anda Pilih Belum Tersedia',
                                type: 'error'
                            })
                        }
                    }
                })
            }
        }

        $(document).ready(function() {
            $(".preloader").fadeOut();
            $('.pilih').click(function(){
                $("#modalForm").modal('show');
            });

            $('.rekenings').select2();

            $('.logout').click(function() {
                var notelp = $('.notelp').val();
                $.ajax({
                    url: "ajaxlogout.php",
                    method: "post",
                    data: {
                        notelp: notelp
                    },
                success: function(data) {
                    if(data == "Akun berhasil di logout")
                    {
                        Swal.fire({
                            title: 'Yeah',
                            html: 'Akun berhasil di logout',
                            type: 'success'
                        }).then((result) => {
                            if (result.value) {
								document.cookie = "notelp=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                                document.location.href='../index.php';
							}
						})
					}else if(data == "Akun gagal logout"){
							Swal.fire({
								title: 'Login Gagal',
								html: 'Akun gagal logout',
								type: 'error'
							})
						}
					}
				})
            })
        });
    </script>
    <script>
		function hanyaAngka(evt) {
		  var charCode = (evt.which) ? evt.which : event.keyCode
		   if (charCode > 31 && (charCode < 48 || charCode > 57))
 
		    return false;
		  return true;
		}
	</script>
</body>

</html>