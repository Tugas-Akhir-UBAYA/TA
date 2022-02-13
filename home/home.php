<?php
    session_start();
    $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
    // $notelp = $_SESSION['notelp'];
    if (isset($_COOKIE['notelp'])) {
        $notelp = $_COOKIE['notelp'];
    }
    $user = mysqli_query($con, "SELECT * FROM users WHERE nomor_telp=$notelp AND status_kerja = 1 AND jabatan = 0");
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
    }else{
        setcookie('notelp', '', time() + $time, '/');
        header("location:../index.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="home.css">
    <title>Karyawan PT. Aman Samudera Lines</title>

</head>
<body >
    <nav class="navbar navbar-expand-sm blue">
        <div class="container-fluid">
            <a class="navbar-brand white" href="index.php">PT. AMAN SAMUDERA LINES</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mynavbar">
            <!-- <ul class="navbar-nav me-auto">
                
            </ul>
            <form class="d-flex">
                <button class="btn red" type="button" onclick="window.location.href='../index.php'">Logout</button>
            </form> -->
            </div>
        </div>
    </nav>
    <div >
        <center><h3 class="selamat">Selamat Datang <?php echo $nama ?></h3></center>
    </div>
    <div class="absen" id="myBtn2" data-aos="zoom-in">
        <div class="pengajuan">
            <div class="form-img">
                <img src="../images/icon-qrcode.png"  class="icon-form">
            </div>
            <div class="form-text">
                <div class="text">QR Codes</div>
            </div>
        </div>
    </div>
    <div class="historiabsensi" id="myBtn3" data-aos="zoom-in">
        <div class="pengajuan">
            <div class="form-img">
                <img src="../images/icon-histori.png"  class="icon-form">
            </div>
            <div class="form-text">
                <div class="text">Histori Absensi</div>
            </div>
        </div>
    </div>
    <div class="izin" id="myBtn" data-aos="zoom-in">
        <div class="pengajuan">
            <div class="form-img">
                <img src="../images/icon-form.png"  class="icon-form">
            </div>
            <div class="form-text">
                <div class="text">Form Pengajuan Izin</div>
            </div>
        </div>
    </div>
    <div class="historipengajuan" id="myBtn4" data-aos="zoom-in">
        <div class="pengajuan">
            <div class="form-img">
                <img src="../images/icon-historiizin.png"  class="icon-form">
            </div>
            <div class="form-text">
                <div class="text">Histori Pengajuan Izin</div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="font-size: 16px;">Form Pengajuan Izin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size: 12px;"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="mb-3">
                            <label class="form-label" style="font-size: 14px;">Kategori<span class="text-danger">*</span></label>
                            <select name="kategori" id="kategori" class="form-select kategori" style="font-size: 12px;" onchange="izin()">
                                <option value="">-- Pilih Kategori Izin --</option>
                                <option value="sakit">Sakit</option>
                                <?php
                                    date_default_timezone_set('Asia/Jakarta');
                                    $menit = date("i") * 60;
                                    $jam = date("H") * 3600;
                                    $totalnow = $jam + $menit;
                                
                                    $maxmenit = 30 * 60;
                                    $maxjam = 8 * 3600;
                                    $totalmax = $maxjam + $maxmenit;
                                    if($totalnow <= $totalmax){
                                        ?>
                                        <option value="terlambat">Terlambat</option>
                                        <?php
                                    }
                                ?>
                                <option value="cuti">Cuti</option>
                                <option value="lainlain">Lain-lain</option>
                            </select>
                        </div>
                        <div class="mb-3 tgl_start">
                            <label class="form-label" style="font-size: 14px;">Tanggal Mulai </label>
                            <input type="date" class="form-control start_date" id="start_date" onchange="mulai()" name="start_date" data-min="" style="font-size: 12px;" />
                        </div>
                        <div class="mb-3 tgl_end">
                            <label class="form-label" style="font-size: 14px;">Tanggal Akhir </label>
                            <input type="date" class="form-control last_date" id="last_date" name="last_date" style="font-size: 12px;" />
                        </div>
                        <div class="mb-3 ket">
                            <label class="form-label" style="font-size: 14px;">Keterangan<span class="text-danger" style="font-size: 14px;">*</span></label>
                            <textarea class="form-control keterangan" style="font-size: 12px;" id="ket"></textarea>
                        </div>
                        <div class="mb-3 foto">
                            <!-- <label class="form-label" style="font-size: 14px;">Upload Bukti Foto </label>
                            <div id="my_camera"></div>
                            <div id="results"></div>
                            <input type=button id="take" class="btn btn-primary" value="Take Snapshot" onClick="take_snapshot()">
                            <input type=button class="btn btn-primary" id="Refresh" value="Refresh">
                            <input type="hidden" name="image" class="image-tag"> -->
                            <input class="form-control" type="file" id="formFile" accept="image/*" capture="camera" onchange="loadFile(event)" style="font-size: 12px;">
                        </div>
                        <div class="mb-3 preview">
                            <label class="form-label" style="font-size: 14px;">Preview</label>
                            <div class="preview1"><img src="../images//noimages.jpg" class="img-prev" id="img-prev" style="font-size: 12px;"></div>
                        </div>
                        <div class="modal-footer d-block">
                            <button type="submit" class="btn float-end blues submit" style="font-size: 14px;">Submit</button>
                        </div>
                        <input class="notelp" hidden value="<?php echo $notelp ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalForm2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">QR Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <?php
                                include "../phpqrcode/qrlib.php";
                                QRcode::png($notelp . ' - ' . $nama, "image.png", "H", 20, 2);
                            ?>
                            <div ><img src="image.png" class="qrcode"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalForm3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Histori Absensi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3 tampilabsensi">
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalForm4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Histori Pengajuan Izin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3 tampilpengajuan">
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <!-- <script language="JavaScript">
        Webcam.set({
            width: 250,
            height: 200,
            image_format: 'jpeg',
            jpeg_quality:1080,
            facingMode: 'environment'
        });
    
        Webcam.attach( '#my_camera' );
    
        function take_snapshot() {
            Webcam.snap( function(data_uri) {
                $(".image-tag").val(data_uri);
                document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';

                $("#results").show();
                $("#Refresh").show();
                $("#my_camera").hide();
                $("#take").hide();
            } );
        }
    </script> -->

    <!-- <script>
        $(document).ready(function(){
            $("#results").hide();
            $("#Refresh").hide();
        })

        $("#Refresh").click(function(){
            $("#results").hide();
            $("#Refresh").hide();
            $("#my_camera").show();
            $("#take").show();
        });
    </script> -->
    
    <script>
        var loadFile = function(event) {
            var images = document.getElementById('img-prev');
	        images.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
    
    <script>
        $(document).ready(function(){
            
            $("#myBtn").click(function(){
                $("#modalForm").modal('show');
            });
            $("#myBtn2").click(function(){
                $("#modalForm2").modal('show');
            });
            $("#myBtn3").click(function(){
                $("#modalForm3").modal('show');
                $('.tampilabsensi').load("tampilhistoriabsensi.php");
            });
            $("#myBtn4").click(function(){
                $("#modalForm4").modal('show');
                $('.tampilpengajuan').load("tampilhistoripengajuan.php");
            });
            
            $(".submit").click(function(){
                var kategori = $('.kategori').val();
                var start_date = $('.start_date').val();
                var last_date = $('.last_date').val();
                var keterangan = $('.keterangan').val();
                
                var images = $('#formFile').prop('files')[0];
                var notelp = $('.notelp').val();
                let formData = new FormData();
                formData.append('images', images);
	            formData.append('kategori', kategori);
	            formData.append('start_date', start_date);
	            formData.append('last_date', last_date);
	            formData.append('keterangan', keterangan);
	            formData.append('notelp', notelp);
                if(kategori == "cuti"){
                    var images = "";
                }
                
                if(kategori == "terlambat"){
                    document.getElementById('last_date').value = '';
                    last_date = "";
                    document.getElementById('start_date').value = '';
                    start_date = "";
                }
                if(kategori == ""){
                    Swal.fire({
						title: 'Ups !!!',
						html: 'Kategori harus dipilih',
						type: 'error'
					})
                }else if(kategori != "cuti" &&  images == undefined){
                    Swal.fire({
						title: 'Ups !!!',
						html: 'Foto harus disertakan',
						type: 'error'
					})
                }else if(keterangan == ""){
                    Swal.fire({
						title: 'Ups !!!',
						html: 'Keterangan wajib diisi',
						type: 'error'
					})
                }else{
                    $.ajax({
                        url: "ajaxpengajuan.php",
                        type: "post",
                        data: formData,
	                    cache: false,
                        processData: false,
                        contentType: false,
                    success: function(data) {
                        if(data == "Proses pengajuan telah berhasil")
                            {
                                Swal.fire({
                                    title: 'Yeah',
                                    html: 'Proses pengajuan telah berhasil',
                                    type: 'success'
                                }).then((result) => {
                                    if (result.value) {
                                        location.reload();
                                    }
                                })
                            }else if(data == "Proses pengajuan gagal"){
                                Swal.fire({
                                    title: 'Ups !!!',
                                    html: 'Proses pengajuan gagal',
                                    type: 'error'
                                })
                            }else if(data == "Tanggal yang diinputkan tidak valid"){
                                Swal.fire({
                                    title: 'Ups !!!',
                                    html: 'Tanggal yang diinputkan tidak valid !!!',
                                    type: 'error'
                                })
                            }
                        }
                    })
                }

                
            });
            
        });
    </script>

    <script>
      AOS.init();
    </script>

    <script type="text/javascript">
        function mulai() {
            var kategori = document.getElementById("kategori").value;
            var start_date = document.getElementById("start_date").value;
            if(start_date != ""){
                $(".tgl_end").show();
                document.getElementById("last_date").min = start_date;
            }
        }
    </script>
    
    <script type="text/javascript">
        
        function izin() {
                document.getElementById('start_date').value = '';
                document.getElementById('last_date').value = '';
                var kategori = document.getElementById("kategori").value;
                var today = new Date();
                var bulan = today.getMonth();
                var hari = today.getDate();
                var fixhari = today.getDate() + 3;
                if(bulan < 10){
                    var kosongbulan = 0;
                }
                if(fixhari < 10){
                    var kosonghari = 0;
                }else{
                    var kosonghari = "";
                }
                if(kategori == "terlambat"){
                    $(".tgl_end").hide();
                    $(".foto").show();
                    $(".tgl_start").hide();
                    $(".preview").show();
                }else  if(kategori == "cuti"){
                    var date = today.getFullYear()+'-'+ kosongbulan +(today.getMonth()+1)+'-'+ kosonghari +(today.getDate() + 3);
                    document.getElementById("start_date").min = date;
                    document.getElementById("last_date").min = date;
                    $(".foto").hide();
                    $(".tgl_end").hide();
                    $(".tgl_start").show();
                    $(".preview").hide();
                }else{
                    $(".tgl_end").hide();
                    $(".foto").show();
                    $(".tgl_start").show();
                    $(".preview").show();
                    document.getElementById("start_date").min = "";
                    document.getElementById("last_date").min = "";

                } 
            }
    </script>
</body>
</html>