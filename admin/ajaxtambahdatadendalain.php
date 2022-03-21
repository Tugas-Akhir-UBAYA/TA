<?php
    $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
    date_default_timezone_set('Asia/Jakarta');
    $nominal = $_POST['nominal'];
    $fixnominal = preg_replace("/[^0-9]/", "", $nominal);
    $id_karyawan = $_POST['id_karyawan'];
    $keterangan = $_POST['keterangan'];
    $datenow = date('d-m-Y');

    $users = mysqli_query($con, "SELECT * FROM users WHERE id = '$id_karyawan'");
    $cekusers = mysqli_fetch_assoc($users);
    if($cekusers > 0){
        $buatdatadendalain = mysqli_query($con, "INSERT INTO datadenda_lainlain VALUES(null,'$id_karyawan','$datenow','$keterangan','$fixnominal',0)");
        $hasil = "Data denda lain berhasil dibuat";
    }else{
        $hasil = "Data karyawan tidak ditemukan";
    }
    
    echo $hasil;
?>