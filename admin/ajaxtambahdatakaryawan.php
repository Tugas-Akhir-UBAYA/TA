<?php
    $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
    $jabatan = $_POST['jabatan'];
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $notelp = $_POST['notelp'];
    $alamat_tinggal = $_POST['alamat_tinggal'];
    $tgl_awal = strtotime($_POST['tgl_awal']);
    $fixtanggal_awal = date("d-m-Y", $tgl_awal);
    $norek = $_POST['norek'];
    $gaji = $_POST['gaji'];
    $bpjs = $_POST['bpjs'];
    $fixgaji = preg_replace("/[^0-9]/", "", $gaji);
    
    $notelps = mysqli_query($con, "SELECT * FROM users WHERE nomor_telp='$notelp'");
    $ceknotelps = mysqli_fetch_assoc($notelps);
    if ($ceknotelps > 0) {
        $hasil = "Nomor telepon sudah digunakan";
    }else{
        $niks = mysqli_query($con, "SELECT * FROM users WHERE nik='$nik'");
        $cekniks = mysqli_fetch_assoc($niks);
        if ($cekniks > 0) {
            $hasil = "NIK sudah digunakan";
        }else{
            $noreks = mysqli_query($con, "SELECT * FROM users WHERE nomor_rekening ='$norek'");
            $ceknoreks = mysqli_fetch_assoc($noreks);
            if ($ceknoreks > 0) {
                $hasil = "No. Rekening sudah digunakan";
            }else{
                $tambahuser = mysqli_query($con, "INSERT INTO users VALUES(null,'$nik','$notelp','$nama','$jabatan',0,'$fixtanggal_awal','$norek','$alamat_tinggal','$fixgaji','$bpjs',1,0)");
                $user= mysqli_query($con, "SELECT * FROM users ORDER BY id DESC");
                $cekuser = mysqli_fetch_assoc($user);
                if($cekuser > 0){
                    $id_users = $cekuser['id'];
                    $fix_idusers = $id_users;
                    $tambahcookies = mysqli_query($con, "INSERT INTO cookies VALUES(null,'$fix_idusers','',0)");
                    $hasil = "Proses tambah data karyawan telah berhasil";
                }else{
                    $fix_idusers = 1;
                    $tambahcookies = mysqli_query($con, "INSERT INTO cookies VALUES(null,'$fix_idusers','',0)");
                    $hasil = "Proses tambah data karyawan telah berhasil";

                }
            }
        }
    }
    
    echo $hasil;
?>