<?php
    $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
    date_default_timezone_set('Asia/Jakarta');
    $nominal = $_POST['nominal'];
    $fixnominal = preg_replace("/[^0-9]/", "", $nominal);
    $durasi = $_POST['durasi'];
    $notelp = $_POST['notelp'];
    $datenow = date('d-m-Y');
    
    $notelps = mysqli_query($con, "SELECT * FROM users WHERE nomor_telp='$notelp'");
    $ceknotelps = mysqli_fetch_assoc($notelps);
    if ($ceknotelps > 0) {
        $id = $ceknotelps['id'];
        $dendaterlambat = mysqli_query($con, "SELECT * FROM denda_terlambat WHERE durasi='$durasi'");
        $cekdendaterlambat = mysqli_fetch_assoc($dendaterlambat);
        if ($cekdendaterlambat > 0) {
            $hasil = "Durasi terlambat sudah ada";
        }else{
            $tambahdendaterlambat = mysqli_query($con, "INSERT INTO denda_terlambat VALUES(null,'$durasi','$fixnominal','$id','$datenow')");
            $hasil = "Data denda terlambat berhasil di simpan";
        }

    }else{
        $hasil = "Data pencatat tidak ditemukan";
    }
    
    echo $hasil;
?>