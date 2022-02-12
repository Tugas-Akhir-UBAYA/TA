<?php
    $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
    $id = $_POST['id'];
    $verifikasi = $_POST['verifikasi'];
    if($verifikasi == "setuju"){
        $fixverifikasi = "sukses";
    }else if($verifikasi == "tolak"){
        $fixverifikasi = "gagal";
    }
    
    $pengajuan = mysqli_query($con, "SELECT * FROM pengajuan WHERE id='$id'");
    $cekpengajuan = mysqli_fetch_assoc($pengajuan);
    if ($cekpengajuan > 0) {
        $updatepengajuan = mysqli_query($con, "UPDATE pengajuan SET status = '$fixverifikasi' WHERE id=$id");
        $hasil = "Proses Verifikasi Telah Berhasil";
    }else{
        $hasil = "Proses Verifikasi Gagal";
    }
    
    echo $hasil;
?>