<?php
    $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
    date_default_timezone_set('Asia/Jakarta');
    $id_denda_terlambat = $_POST['id_denda_terlambat'];
    $nominal = $_POST['nominal'];
    $fixnominal = preg_replace("/[^0-9]/", "", $nominal);
    $idpencatat = $_POST['idpencatat'];
    $durasi = $_POST['durasi'];

    $datenow = date("d-m-Y");
    
    $datadendaterlambat = mysqli_query($con, "SELECT * FROM denda_terlambat WHERE id != '$id_denda_terlambat' AND durasi = '$durasi'");
    $cekdatadendaterlambat = mysqli_fetch_assoc($datadendaterlambat);
    if ($cekdatadendaterlambat > 0) {
        $hasil = "Durasi denda terlambat sudah ada";
    }else{
        $updatedatadendaterlambat = mysqli_query($con, "UPDATE denda_terlambat SET durasi = '$durasi', denda = '$fixnominal', id_pencatat = '$idpencatat', tanggal_input = '$datenow' WHERE id ='$id_denda_terlambat'");
        $hasil = "Data denda terlambat berhasil diubah";

    }
    
    echo $hasil;
?>