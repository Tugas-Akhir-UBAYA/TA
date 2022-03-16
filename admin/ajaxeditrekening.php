<?php
    $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
    $id_users = $_POST['id_users'];
    $tgl_input = $_POST['tgl_input'];
    $id_rekening = $_POST['id_rekening'];
    $nama_bank = $_POST['nama_bank'];
    $no_rekening = $_POST['no_rekening'];
    $atas_nama = $_POST['atas_nama'];
    $rekening = mysqli_query($con, "SELECT * FROM rekening WHERE no_rekening ='$no_rekening'");
    $cekrekening= mysqli_fetch_assoc($rekening);
    if ($cekrekening> 0) {
        $id = $cekrekening['id'];
        if($id_rekening != $id){
            $hasil = "Nomor Rekening Sudah Ada";
        }else{
            $updaterekening = mysqli_query($con, "UPDATE rekening SET no_rekening = '$no_rekening', atas_nama = '$atas_nama', nama_bank = '$nama_bank', tanggal_input = '$tgl_input', id_pencatat = '$id_users' WHERE id ='$id_rekening'");
            $hasil = "Berhasil Merubah Data Rekening";
        }
    }else{
        $updaterekening = mysqli_query($con, "UPDATE rekening SET no_rekening = '$no_rekening', atas_nama = '$atas_nama', nama_bank = '$nama_bank', tanggal_input = '$tgl_input', id_pencatat = '$id_users' WHERE id ='$id_rekening'");
        $hasil = "Berhasil Merubah Data Rekening";
    }
    
    echo $hasil;
?>