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

    <title>Karyawan PT. Aman Samudera Lines</title>

    <link href="assets/css/bootstrap 4.5.2.css" rel="stylesheet" crossorigin="anonymous">
    <link href="assets/css/dataTables bootstrap 4 min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="assets/css/all v5.7.2.css" rel="stylesheet" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="dashboard.css">
    <script defer src="assets/js/solid v5.0.13.js" crossorigin="anonymous"></script>
    <script defer src="assets/js/fontawesome v5.0.13.js" crossorigin="anonymous"></script>
    <script src="assets/js/jquery 3.5.1.js" crossorigin="anonymous"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="assets/js/jquery dataTables 1.11.4 .min.js" crossorigin="anonymous"></script>
    <script src="assets/js/chart 3.7.1.js" crossorigin="anonymous"></script>
    <script src="assets/js/dataTables 1.11.4 bootstrap 4 min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/sweetalert2 7.33.1 min.css">
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <img src="../images/Logo PT. ASL.png" width="180px">
            </div>

            <ul class="list-unstyled components">
                <li class="active">
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
                            <a href="presensimasukpagi.php">Presensi Masuk Pagi</a>
                        </li>
                        <li>
                            <a href="presensikeluaristirahat.php">Presensi Keluar Masuk Istirahat</a>
                        </li>
                        <!-- <li>
                            <a href="presensimasuksetelahistirahat.php">Presensi Masuk Setelah Istirahat</a>
                        </li> -->
                    </ul>
                </li>
                <!-- <li>
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Home</a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li>
                            <a href="#">Home 1</a>
                        </li>
                        <li>
                            <a href="#">Home 2</a>
                        </li>
                        <li>
                            <a href="#">Home 3</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Pages</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li>
                            <a href="#">Page 1</a>
                        </li>
                        <li>
                            <a href="#">Page 2</a>
                        </li>
                        <li>
                            <a href="#">Page 3</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">Contact</a>
                </li> -->
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
            

            <div>
              <div style="margin-bottom: 50px;"><center><h1>Dashboard</h1></center></div>
              <div class="chartku" id="chartku" data-aos="flip-up">
                <canvas id="myChart"></canvas>
                <center style="margin-top: 20px;"><h5>Total Karyawan Aktif : <?php 
                $user = mysqli_query($con, "SELECT * FROM users WHERE status_kerja = 1");
                $total_users = mysqli_num_rows($user); 
                echo $total_users ?></h5>
                </center>
              </div>
            </div>
        </div>

    </div>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script src="assets/js/bootstrap 4.1.0 min.js" crossorigin="anonymous"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> -->
    <script src="assets/js/popper 1.14.0 min.js" crossorigin="anonymous"></script>
	<script src="assets/js/sweetalert2 7.33.1 min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
		var ctx = document.getElementById("myChart").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'pie',
			data: {
				labels: ["Tepat Waktu", "Terlambat","Tidak Masuk"],
				datasets: [{
					label: '',
					data: [
					<?php
					$date = date("d-m-Y");
					$tepat_waktu = mysqli_query($con,"select * from absensi where status='Tepat Waktu' AND keterangan = 'Masuk Pagi' AND tanggal = '$date'");
					$total_tepatwaktu =  mysqli_num_rows($tepat_waktu);
					echo $total_tepatwaktu;
					?>, 
					<?php 
					$date = date("d-m-Y");
					$terlambat = mysqli_query($con,"select * from absensi where status='Terlambat' AND keterangan = 'Masuk Pagi' AND tanggal = '$date'");
					$total_terlambat = mysqli_num_rows($terlambat);
					echo $total_terlambat;
					?>,
					<?php
						$jumlah_user = mysqli_query($con,"select * from users where status_kerja = 1");
						$fixjumlah_user = mysqli_num_rows($jumlah_user);
						$total_tidakmasuk = $fixjumlah_user - ($total_terlambat + $total_tepatwaktu);
						echo $total_tidakmasuk;
					?>
					],
					backgroundColor: [
					'rgba(0, 255, 42, 0.2)',
					'rgba(255, 136, 0, 0.2)',
					'rgba(255, 0, 0, 0.2)'
					],
					borderColor: [
					'rgba(0, 255, 42, 1)',
					'rgba(255, 136, 0, 1)',
					'rgba(255, 0, 0, 1)'
					],
					borderWidth: 1
				}]
			},
			options:{
                animation: {
                    rotation: true
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Daftar Presensi Masuk Pagi Karyawan Hari Ini',
                        font: {
                            size: 20
                        },
                        padding:{
                            top: 20
                        },
                    }
                }
            }
		});
	</script>
    <script>
      AOS.init();
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });

            $('.submit').click(function(){
                var jabatan = $('.jabatan').val();
                var nik = $('.nik').val();
                var nama = $('.nama').val();
                var notelp = $('.no_telp').val();
                var alamat_tinggal = $('.alamat_tinggal').val();
                var tgl_awal = $('.tgl_awal').val();
                var norek = $('.no_rekening').val();
                var gaji = $('.gaji').val();
                var bpjs = $('.bpjs').val();
                var date = Date.now();
                if(jabatan == "" || nik == "" || nama == "" || notelp == "" || alamat_tinggal == "" || tgl_awal == "" || norek == "" || gaji == "" || bpjs == ""){
                    Swal.fire({
						title: 'Ups !!!',
						html: 'Data harus di isi semua !!!',
						type: 'error'
					})
                }else{
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
                            bpjs: bpjs
                        },
                    success: function(data) {
                        if(data == "Proses tambah data karyawan telah berhasil")
                        {
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
                                    document.getElementById('bpjs').value = '';
                                    
                                }
                            })
                        }else if(data == "Nomor telepon sudah digunakan"){
                            Swal.fire({
                                title: 'Ups...',
                                html: 'Nomor telepon sudah digunakan',
                                type: 'error'
                            })
                        }else if(data == "NIK sudah digunakan"){
                            Swal.fire({
                                title: 'Ups...',
                                html: 'NIK sudah digunakan',
                                type: 'error'
                            })
                        }else if(data == "No. Rekening sudah digunakan"){
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
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            var rupiah = document.getElementById('gaji');
            rupiah.addEventListener('keyup', function(e){
                rupiah.value = formatRupiah(this.value, 'Rp. ');
            });
    
            /* Fungsi formatRupiah */
            function formatRupiah(angka, prefix){
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split   		= number_string.split(','),
                sisa     		= split[0].length % 3,
                rupiah     		= split[0].substr(0, sisa),
                ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

                if(ribuan){
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }
    
                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
            }
        });
    </script>

    <script>
        // onclick="window.location.href='../index.php'"
        $(document).ready(function() {

            $('.tambah').click(function(){
                $("#modalForm").modal('show');
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