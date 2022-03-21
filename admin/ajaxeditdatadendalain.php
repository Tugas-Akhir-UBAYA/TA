<?php
    $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
    date_default_timezone_set('Asia/Jakarta');
    $id_dendalain = $_POST['id_dendalain'];
    $nominal = $_POST['nominal'];
    $fixnominal = preg_replace("/[^0-9]/", "", $nominal);
    $karyawan = $_POST['karyawan'];
    $keterangan = $_POST['keterangans'];

    $datenow = date("d-m-Y");
    
    $datadendalain = mysqli_query($con, "SELECT * FROM datadenda_lainlain WHERE id ='$id_dendalain'");
    $cekdatadendalain = mysqli_fetch_assoc($datadendalain);
    if ($cekdatadendalain > 0) {
        $status = $cekdatadendalain['status'];
        if($status == 0){
            $updatedatadendalain = mysqli_query($con, "UPDATE datadenda_lainlain SET id_users = '$karyawan', tanggal_input = '$datenow', nominal = '$fixnominal', keterangan = '$keterangan'  WHERE id ='$id_dendalain'");
            $hasil = "Data denda lain - lain berhasil diubah";
        }else if($status == 1){
            $updatedatadendalain = mysqli_query($con, "UPDATE datadenda_lainlain SET keterangan = '$keterangan'  WHERE id ='$id_dendalain'");
            $hasil = "Data denda lain - lain berhasil diubah";
        }
    }else{
        $hasil = "Gagal Mengubah Data denda lain - lain";
    }
    
    echo $hasil;
?>