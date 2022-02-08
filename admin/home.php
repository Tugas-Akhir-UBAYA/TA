<?php
    session_start();
    $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
    // $notelp = $_SESSION['notelp'];
    if (isset($_COOKIE['notelp'])) {
        $notelp = $_COOKIE['notelp'];
    }
    $user = mysqli_query($con, "SELECT * FROM users WHERE nomor_telp=$notelp");
    $cekuser = mysqli_fetch_assoc($user);
    if ($cekuser > 0) {
        $id_users = $cekuser['id'];
        $nama = $cekuser['nama'];
        $cookies = mysqli_query($con, "SELECT * FROM cookies WHERE id_users=$id_users");
        $cekcookies = mysqli_fetch_assoc($cookies);
        if($cekcookies > 0){
            $name = $cekcookies['name'];
            $time = $cekcookies['time'];
            setcookie('notelp', $name, time() + $time, '/');
            if($name == ""){
                header("location:../index.php");
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js" crossorigin="anonymous"></script>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../admin/home.css">
    <title>Karyawan PT. Aman Samudera Lines</title>
</head>
<body>
    <nav class="navbar navbar-expand-sm blue">
        <div class="container-fluid">
            <a class="navbar-brand white" href="index.php">PT. AMAN SAMUDERA LINES</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mynavbar">
            <ul class="navbar-nav me-auto">
                
            </ul>
            <form class="d-flex">
                <button class="btn red logout" type="button" >Logout</button>
            </form>
            </div>
        </div>
    </nav>
    <div >
        <center><h1 class="selamat">Selamat Datang <?php echo $nama ?></h1></center>
    </div>
    <div class="izin" id="myBtn" >
        <div class="pengajuan">
            <div class="form-img">
                <img src="../images/icon-menu.png"  class="icon-form">
            </div>
            <div class="form-text">
                <div class="text">Dashboard</div>
            </div>
        </div>
    </div>
    <input hidden class="notelp" value="<?php echo $notelp  ?>">
    <div class="absen" id="myBtn2" >
        <div class="pengajuan">
            <div class="form-img">
                <img src="../images/icon-scanqr.png"  class="icon-form">
            </div>
            <div class="form-text">
                <div class="text">Scan QR Codes</div>
            </div>
        </div>
    </div>
    <div class="absen" id="myBtn3" >
        <div class="pengajuan">
            <div class="form-img">
                <img src="../images/icon-delete.png"  class="icon-form">
            </div>
            <div class="form-text">
                <div class="text">Hapus Cookies</div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Cookies dan Logout Akun Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="mb-3">
                            <label class="form-label">Pilih Nomor Telepon </label>
                            <input type="input" class="form-control pilih" id="pilih" placeholder="ex: 081234567890" name="pilih" onkeypress="return hanyaAngka(event)" />
                        </div>
                        <div class="modal-footer d-block">
                            <button type="submit" class="btn float-end red hapus">Hapus</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalForm2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Scan QR Codes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="mb-3">
                            <label class="form-label">QR Codes </label>
                            <input type="text" class="form-control text" id="text" placeholder="Scan Qrcode" name="text" />
                            <video id="preview" width="100%" style="margin-top: 20px;"></video>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <script>
        // onclick="window.location.href='../index.php'"
        $(document).ready(function() {
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
        $(document).ready(function(){
            
            $("#myBtn3").click(function(){
                $("#modalForm").modal('show');
            });
            $("#myBtn2").click(function(){
                $("#modalForm2").modal('show');
            });
        });
    </script>
    <script>
        let scanner = new Instascan.Scanner({video: document.getElementById('preview')});
        Instascan.Camera.getCameras().then(function(cameras){
            if(cameras.length > 0){
                scanner.start(cameras[0]);
            }else{
                alert("kamera tidak ditemukan");
            }
        }).catch(function(e){
            console.error(e);
        });

        scanner.addListener('scan', function(c){
            document.getElementById('text').value=c;
            var notelp = $('#text').val();
            var timenow = new Date();
            var hari = ["", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu", "Minggu"]
            var date = hari[timenow.getDay()];
            // alert(date);
            $.ajax({
				url: "ajaxscan.php",
				method: "post",
				data: {
					notelp: notelp
				},
				success: function(data) {
					if(data == "Absensi sukses")
					{
						Swal.fire({
							title: 'Yeah',
							html: 'Absensi sukses',
							type: 'success',
                            timer: 3000
                            
						}).then((result) => {
                            document.getElementById('text').value = '';
							if (result.value) {
								document.getElementById('text').value = '';
							}
						})
					}else if(data == "Absensi Melebihi Batas per Hari"){
						Swal.fire({
							title: 'Ups !!!',
							html: 'Absensi Melebihi Batas per Hari',
							type: 'error',
                            timer: 3000
						}).then((result) => {
							if (result.value) {
								document.getElementById('text').value = '';
							}
						})
					}else if(data == "Absensi gagal"){
						Swal.fire({
							title: 'Ups !!!',
							html: 'Absensi gagal',
							type: 'error'
						})
					}
				}
			})
            // Swal.fire({
			// 	title: 'Yeah',
			// 	html: 'Absensi sukses',
			// 	type: 'success'
            //     // timer: 3000
			// }).then((result) => {
			// 	if (result.value) {
					
			// 	}
			// })
        })
    </script>
    <script>
        $(document).ready(function(){
            
            $(".hapus").click(function(){
                var pilih = $('.pilih').val();
                $.ajax({
					url: "ajaxhapuscookies.php",
					method: "post",
					data: {
						pilih: pilih
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
									location.reload();
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
            });
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