<?php
    $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
    $kategori = $_POST['kategori'];
    $start_date = date_create($_POST['start_date']);
    $fixstart_date = date_format($start_date, "d-m-Y");
    $last_date = date_create($_POST['last_date']);
    $fixlast_date = date_format($last_date, "d-m-Y");
    $keterangan = $_POST['keterangan'];
    $notelp = $_POST['notelp'];
    date_default_timezone_set('Asia/Jakarta');
    $date = date("d-m-Y H:i:s");

    
    $user = mysqli_query($con, "SELECT * FROM users WHERE nomor_telp='$notelp'");
    $cekuser = mysqli_fetch_assoc($user);
    if ($cekuser > 0) {
        $id_users = $cekuser['id'];
        $pengajuan = mysqli_query($con, "INSERT INTO pengajuan VALUES(null,'$id_users','$keterangan','','$fixstart_date','$fixlast_date','$date','$kategori')");
        $hasil = "Proses pengajuan telah berhasil";
    }else{
        $hasil = "Proses pengajuan gagal";
    }
    
    echo $hasil;
?>