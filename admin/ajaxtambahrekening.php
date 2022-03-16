<?php
    $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
    date_default_timezone_set('Asia/Jakarta');
    $id_users = $_POST['id_users'];
    $nama_bank = $_POST['nama_bank'];
    $atas_nama = $_POST['atas_nama'];
    $no_rekening = $_POST['no_rekening'];
    $datenow = date('d-m-Y');
    
    $rekening = mysqli_query($con, "SELECT * FROM rekening WHERE no_rekening='$no_rekening'");
    $cekrekening = mysqli_fetch_assoc($rekening);
    if ($cekrekening > 0) {
        $hasil = "Rekening sudah ditambahkan sebelumnya";
    }else{
        $tambahrekening = mysqli_query($con, "INSERT INTO rekening VALUES(null,'$nama_bank','$atas_nama','$no_rekening','$datenow','$id_users')");
        $hasil = "Data Rekening Berhasil Di Simpan";
    }
    
    echo $hasil;
?>