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
                <li class="active">
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
                <li>
                    <a href="#presensiSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" style="font-size: 16px;"><i class="fa fa-bars" aria-hidden="true"></i> &nbsp; Presensi Karyawan</a>
                    <ul class="collapse list-unstyled" id="presensiSubmenu">
                        <li>
                            <a href="presensimasukpagi.php">Presensi Datang dan Pulang</a>
                        </li>
                        <li>
                            <a href="presensikeluaristirahat.php">Presensi Keluar Masuk Istirahat</a>
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
            <input hidden class="id_users" value="<?php echo $id_users  ?>">


            <div class="isi">
                <div class="preloader">
                    <div class="loading">
                        <img src="../images/loading2.gif" width="100%">
                    </div>
                </div>
                <div>
                    <center>
                        <h1>Daftar Data Karyawan</h1>
                    </center>
                </div>
                <button class="btn tambah tambahkaryawan" style="margin-top: 50px; margin-bottom: 10px;"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Tambah Data Karyawan</button>
                <div class="wadahtampil">
                    <div class="tabledaftarkaryawan tampiltabel">

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Karyawan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"> <label class="form-label" style="font-size: 14px;">NIK<span class="text-danger">*</span> </label> <input type="text" class="form-control nik" id="nik" onkeypress="return hanyaAngka(event)" name="nik" style="font-size: 12px;" /> </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"> <label class="form-label" style="font-size: 14px;">Nama<span class="text-danger">*</span> </label> <input type="text" class="form-control nama" id="nama" name="nama" style="font-size: 12px;" /> </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"> <label class="form-label" style="font-size: 14px;">Tanggal Awal Mulai Kerja<span class="text-danger">*</span> </label> <input type="date" class="form-control tgl_awal" id="tgl_awal" name="tgl_awal" style="font-size: 12px;" /> </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"> <label class="form-label" style="font-size: 14px;">Nomor Rekening<span class="text-danger">*</span> </label> <input type="text" class="form-control no_rekening" id="no_rekening" name="no_rekening" onkeypress="return hanyaAngka(event)" style="font-size: 12px;" /> </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"> <label class="form-label" style="font-size: 14px;">Gaji Pokok<span class="text-danger">*</span> </label> <input type="text" class="form-control gaji" id="gaji" name="gaji" onkeypress="return hanyaAngka(event)" style="font-size: 12px;" /> </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"> <label class="form-label" style="font-size: 14px;">Nomor Telepon<span class="text-danger">*</span> </label> <input type="text" class="form-control no_telp" id="no_telp" name="no_telp" onkeypress="return hanyaAngka(event)" style="font-size: 12px;" /> </div>
                                </div>
                            </div>
                            <div class="mb-3 jabatans">
                                <label class="form-label" style="font-size: 14px;">Jabatan<span class="text-danger">*</span></label>
                                <select name="jabatan" id="jabatan" class="form-control jabatan" style="font-size: 12px;">
                                    <option value="">-- Pilih Jabatan --</option>
                                    <option value="1">Admin</option>
                                    <option value="0">Karyawan</option>
                                </select>
                            </div>
                            <div class="mb-3 alamat">
                                <label class="form-label" style="font-size: 14px;">Alamat Tinggal<span class="text-danger">*</span></label>
                                <textarea class="form-control alamat_tinggal" id="alamat_tinggal" style="font-size: 12px;"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" style="font-size: 14px;">BPJS Ketenagakerjaan</label>
                                        <div class="toggle">
                                            <input type="checkbox" class="bpjsketenagakerjaan" id="bpjsketenagakerjaan">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" style="font-size: 14px;">BPJS Kesehatan</label>
                                        <div class="toggle">
                                            <input type="checkbox" class="bpjskesehatan" id="bpjskesehatan">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer d-block">
                                <button type="submit" class="btn float-right blues submit" style="font-size: 14px;">Submit</button>
                            </div>
                            <input class="notelp" hidden value="<?php echo $notelp ?>">
                        </div>
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
            $('.tabledaftarkaryawan').load("tampildaftarkaryawan.php");

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

            $('.tambah').click(function() {
                $("#modalForm").modal('show');
            });

            var rupiah = document.getElementById('gaji');
            rupiah.addEventListener('keyup', function(e) {
                rupiah.value = formatRupiah(this.value, 'Rp. ');
            });

            /* Fungsi formatRupiah */
            function formatRupiah(angka, prefix) {
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
            }

            

            $('.submit').click(function() {
                var jabatan = $('.jabatan').val();
                var nik = $('.nik').val();
                var nama = $('.nama').val();
                var notelp = $('.no_telp').val();
                var alamat_tinggal = $('.alamat_tinggal').val();
                var tgl_awal = $('.tgl_awal').val();
                var norek = $('.no_rekening').val();
                var gaji = $('.gaji').val();
                var id_users = $('.id_users').val();
                var bpjsketenagakerjaan = document.getElementById("bpjsketenagakerjaan").checked;
                if (bpjsketenagakerjaan == true) {
                    bpjsketenagakerjaan = 1;
                } else if (bpjsketenagakerjaan == false) {
                    bpjsketenagakerjaan = 0;
                }
                var bpjskesehatan = document.getElementById("bpjskesehatan").checked;
                if (bpjskesehatan == true) {
                    bpjskesehatan = 1;
                } else if (bpjskesehatan == false) {
                    bpjskesehatan = 0;
                }
                var date = Date.now();
                if (jabatan == "" || nik == "" || nama == "" || notelp == "" || alamat_tinggal == "" || tgl_awal == "" || norek == "" || gaji == "") {
                    Swal.fire({
                        title: 'Ups !!!',
                        html: 'Data harus di isi semua !!!',
                        type: 'error'
                    })
                } else {
                    $.ajax({
                        url: "ajaxtambahdatakaryawan.php",
                        method: "post",
                        data: {
                            jabatan: jabatan,
                            nik: nik,
                            nama: nama,
                            notelp: notelp,
                            alamat_tinggal: alamat_tinggal,
                            tgl_awal: tgl_awal,
                            norek: norek,
                            gaji: gaji,
                            bpjsketenagakerjaan: bpjsketenagakerjaan,
                            bpjskesehatan: bpjskesehatan,
                            id_users: id_users
                        },
                        success: function(data) {
                            if (data == "Proses tambah data karyawan telah berhasil") {
                                Swal.fire({
                                    title: 'Yeah',
                                    html: 'Proses tambah data karyawan telah berhasil',
                                    type: 'success'
                                }).then((result) => {
                                    if (result.value) {
                                        $('.tabledaftarkaryawan').load("tampildaftarkaryawan.php");
                                        $('#modalForm').modal('hide');
                                        document.getElementById('jabatan').value = '';
                                        document.getElementById('nik').value = '';
                                        document.getElementById('nama').value = '';
                                        document.getElementById('no_telp').value = '';
                                        document.getElementById('alamat_tinggal').value = '';
                                        document.getElementById('tgl_awal').value = '';
                                        document.getElementById('no_rekening').value = '';
                                        document.getElementById('gaji').value = '';
                                        document.getElementById('bpjsketenagakerjaan').value = '';
                                        document.getElementById('bpjsketenagakesehatan').value = '';

                                    }
                                })
                            } else if (data == "Nomor telepon sudah digunakan") {
                                Swal.fire({
                                    title: 'Ups...',
                                    html: 'Nomor telepon sudah digunakan',
                                    type: 'error'
                                })
                            } else if (data == "NIK sudah digunakan") {
                                Swal.fire({
                                    title: 'Ups...',
                                    html: 'NIK sudah digunakan',
                                    type: 'error'
                                })
                            } else if (data == "No. Rekening sudah digunakan") {
                                Swal.fire({
                                    title: 'Ups...',
                                    html: 'No. Rekening sudah digunakan',
                                    type: 'error'
                                })
                            }
                        }
                    })
                }
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