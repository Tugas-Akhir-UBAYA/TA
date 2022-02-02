<?php 
    $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
    $notelp = $_POST['notelp'];

    $user = mysqli_query($con, "SELECT * FROM users WHERE nomor_telp='$notelp'");
    $cekuser = mysqli_fetch_assoc($user);
    if ($cekuser > 0) { 
        
        $sql1 = mysqli_query($con, "UPDATE users SET status = 1 WHERE nomor_telp='$notelp'");
        if($cekuser['jabatan'] == 1)
        {
            session_start();
            $_SESSION['nama'] = $cekuser['nama'];
            $hasil = "Login berhasil admin";
        }else if($cekuser['jabatan'] == 0){
            session_start();
            $_SESSION['nama'] = $cekuser['nama'];
            $hasil = "Login berhasil karyawan";
        }

    }else{
        $hasil = "Nomor telepon tidak terdaftar";
    }
    echo $hasil;
?>