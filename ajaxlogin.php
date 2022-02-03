<?php 
    $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
    $hasil = "Nomor telepon tidak terdaftar";
    if (isset($_POST['notelps'])) {
        // echo '<script>alert("Welcome to Geeks for Geeks")</script>';
        $notelps = $_POST['notelps'];
        $users = mysqli_query($con, "SELECT * FROM users WHERE nomor_telp='$notelps'");
        $cekusers = mysqli_fetch_assoc($users);
        if ($cekusers > 0) { 
            
            $sql1s = mysqli_query($con, "UPDATE users SET status = 1 WHERE nomor_telp='$notelps'");
            if($cekusers['jabatan'] == 1)
            {
                // setcookie('notelp', '', time() + 0, '/TA');
                $hasil = "Login berhasil admin";
            }else if($cekusers['jabatan'] == 0){
                // setcookie('notelp', '', time() + 0, '/TA');
                $hasil = "Login berhasil karyawan";
            }
            
        }
    }
    else{
        $notelp = $_POST['notelp'];
        $user = mysqli_query($con, "SELECT * FROM users WHERE nomor_telp='$notelp'");
        $cekuser = mysqli_fetch_assoc($user);
        if ($cekuser > 0) { 
            if($cekuser['status'] == 1){
                $hasil = "Akun sedang login di perangkat lain";
            }else{
                $sql1 = mysqli_query($con, "UPDATE users SET status = 1 WHERE nomor_telp='$notelp'");
                if($cekuser['jabatan'] == 1)
                {
                    session_start();
                    $_SESSION['nama'] = $cekuser['nama'];
                    setcookie('notelp', $notelp, time() + 2147483647, '/TA');
                    $hasil = "Login berhasil admin";
                }else if($cekuser['jabatan'] == 0){
                    session_start();
                    $_SESSION['nama'] = $cekuser['nama'];
                    setcookie('notelp', $notelp, time() + 2147483647, '/TA');
                    $hasil = "Login berhasil karyawan";
                }
            }
        }else{
            $hasil = "Nomor telepon tidak terdaftar";
        }
    }
    
    
    echo $hasil;
?>