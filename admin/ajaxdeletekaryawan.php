<?php 
    $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
    $notelp = $_POST['notelp'];
    $users = mysqli_query($con, "SELECT * FROM users WHERE nomor_telp = '$notelp'");
    $cekuser = mysqli_fetch_assoc($users);
    if ($cekuser > 0) {
        $id_users = $cekuser['id'];
        $deletecookies = mysqli_query($con, "DELETE FROM cookies WHERE id_users = $id_users");
        $sql1 = mysqli_query($con, "DELETE FROM users WHERE id = $id_users");
        $hasil = "Data Karyawan Berhasil di Hapus";
    }else{
        $hasil = "Data Karyawan Gagal di Hapus";
    }
    
    echo $hasil;
?>