<?php
$con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
date_default_timezone_set('Asia/Jakarta');
$notelp = $_POST['notelp'];
$nik = $_POST['nik'];
$alamat = $_POST['alamat'];
$nama = $_POST['nama'];

$users = mysqli_query($con, "SELECT * FROM users WHERE nomor_telp ='$notelp'");
$cekusers = mysqli_fetch_assoc($users);
if ($cekusers > 0) {
    $id = $cekusers['id'];
    $niks = mysqli_query($con, "SELECT * FROM users WHERE id != '$id' AND nik ='$nik'");
    $ceknik = mysqli_fetch_assoc($niks);
    if ($ceknik > 0) {
        $hasil = "NIK Sudah di Gunakan";
    } else {
        $update = mysqli_query($con, "UPDATE users SET nama = '$nama', nik = '$nik', alamat_tinggal = '$alamat'     WHERE id ='$id'");
        $hasil = "Data Berhasil Diubah";
    }
} else {
    $hasil = "Gagal Mengubah Data";
}

echo $hasil;
