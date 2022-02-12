<?php
    $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
    $id_users = $_POST['id_users'];
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
    
    $users = mysqli_query($con, "SELECT * FROM users WHERE id ='$id_users'");
    $cekusers = mysqli_fetch_assoc($users);
    if ($cekusers > 0) {
        $notelps = mysqli_query($con, "SELECT * FROM users WHERE id != '$id_users' AND  nomor_telp ='$notelp'");
        $ceknotelp = mysqli_fetch_assoc($notelps);
        if($ceknotelp > 0){
            $hasil = "Nomor Telepon Sudah di Gunakan";
        }else{
            $niks = mysqli_query($con, "SELECT * FROM users WHERE id != '$id_users' AND nik ='$nik'");
            $ceknik = mysqli_fetch_assoc($niks);
            if($ceknik > 0){
                $hasil = "NIK Sudah di Gunakan";
            }else{
                $nomor_rekenings = mysqli_query($con, "SELECT * FROM users WHERE id != '$id_users' AND nomor_rekening ='$norek'");
                $ceknorek = mysqli_fetch_assoc($nomor_rekenings);
                if($ceknorek > 0){
                    $hasil = "No. Rekening Sudah di Gunakan";
                }else{
                    $cookies = mysqli_query($con, "SELECT * FROM cookies WHERE id_users = '$id_users' AND nomor_telepon != ''");
                    $cekcookies = mysqli_fetch_assoc($cookies);
                    if($cekcookies > 0){
                        $nomor_telepons = $cekcookies['nomor_telepon'];
                        if($nomor_telepons != $notelp){
                            $updatecookies = mysqli_query($con, "UPDATE cookies SET nomor_telepon = '', time = 0 WHERE id_users ='$id_users'");
                            $updatestatus = mysqli_query($con, "UPDATE users SET status = 0 WHERE id ='$id_users'");

                        }
                    }
                    $update = mysqli_query($con, "UPDATE users SET nama = '$nama', nomor_telp = '$notelp', nik = '$nik', jabatan = $jabatan, tgl_awalkerja = $fixtanggal_awal, nomor_rekening = '$norek', alamat_tinggal = '$alamat_tinggal', status_bpjs = $bpjs WHERE id ='$id_users'");
                    $hasil = "Data Karyawan Berhasil di Ubah";
                }
            }
        }
    }else{
        $hasil = "Gagal Mengubah Data Karyawan";
    }
    
    echo $hasil;
?>