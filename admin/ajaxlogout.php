<?php
    $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
    $notelp = $_POST['notelp'];

    
    $user = mysqli_query($con, "SELECT * FROM users WHERE nomor_telp='$notelp'");
    $cekuser = mysqli_fetch_assoc($user);
    if ($cekuser > 0) {
        $id_users = $cekuser['id'];
        $cookies = mysqli_query($con, "UPDATE cookies SET nomor_telepon = '', time = 0 WHERE id_users=$id_users");
        $sql1 = mysqli_query($con, "UPDATE users SET status = 0 WHERE nomor_telp='$notelp'");
        $hasil = "Akun berhasil di logout";
    }else{
        $hasil = "Akun gagal logout";
    }
    
    echo $hasil;
?>