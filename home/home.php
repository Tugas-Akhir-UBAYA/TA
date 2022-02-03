<?php
    session_start();
    $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
    $notelp = $_SESSION['notelp'];
    $user = mysqli_query($con, "SELECT * FROM users WHERE nomor_telp=$notelp");
    $cekuser = mysqli_fetch_assoc($user);
    if ($cekuser > 0) {
        $id_users = $cekuser['id'];
        $cookies = mysqli_query($con, "SELECT * FROM cookies WHERE id_users=$id_users");
        $cekcookies = mysqli_fetch_assoc($cookies);
        if($cekcookies > 0){
            $name = $cekcookies['name'];
            $time = $cekcookies['time'];
            setcookie('notelp', $name, time() + $time, '/TA');
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
        <center><h3 class="selamat">Selamat Datang <?php echo $_SESSION['nama'] ?></h3></center>
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

    <div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Pengajuan Izin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Kategori<span class="text-danger">*</span></label>
                            <select name="kategori" id="kategori" class="form-select">
                            <option value="">-- Pilih Kategori Izin --</option>
                                <option value="sakit">Sakit</option>
                                <option value="terlambat">Terlambat</option>
                                <option value="lainlain">Lain-lain</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai </label>
                            <input type="date" class="form-control" id="start_date" name="start_date" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Akhir </label>
                            <input type="date" class="form-control" id="last_date" name="last_date" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan<span class="text-danger">*</span></label>
                            <textarea class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Upload Bukti Foto </label>
                            <input class="form-control" type="file" id="formFile" accept="image/*" capture>
                        </div>
                        <div class="mb-3 foto">
                            <label class="form-label">Preview</label>
                            <div class="preview"><img src="../images//noimages.jpg" class="img-prev"></div>
                        </div>
                        <div class="modal-footer d-block">
                            <button type="submit" class="btn float-end blues">Submit</button>
                        </div>
                    </form>
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
                                QRcode::png($_SESSION['nama'], "image.png", "H", 20, 2);
                            ?>
                            <div ><img src="image.png" class="qrcode"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        $(document).ready(function(){
            
            $("#myBtn").click(function(){
                $("#modalForm").modal('show');
            });
            $("#myBtn2").click(function(){
                $("#modalForm2").modal('show');
            });
        });
    </script>
    <script>
      AOS.init();
    </script>
</body>
</html>