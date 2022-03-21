<?php
    $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
    $id_users = $_POST['id_users'];
    $tgl_input = $_POST['tgl_input'];
    $id_bpjs = $_POST['id_bpjs'];
    $nama_bpjs = $_POST['nama_bpjs'];
    $nominal = $_POST['nominal'];
    date_default_timezone_set('Asia/Jakarta');
    $datenow = date("d-m-Y");
    $fixnominal= preg_replace("/[^0-9]/", "", $nominal);
    $bpjs = mysqli_query($con, "SELECT * FROM bpjs WHERE nama_bpjs ='$nama_bpjs'");
    $cekbpjs = mysqli_fetch_assoc($bpjs);
    if ($cekbpjs > 0) {
        $id = $cekbpjs['id'];
        if($id_bpjs != $id){
            $hasil = "Nama BPJS Telah di Gunakan";
        }else{
            $updatebpjs = mysqli_query($con, "UPDATE bpjs SET nama_bpjs = '$nama_bpjs', nominal = '$fixnominal', tanggal_input = '$datenow' WHERE id ='$id_bpjs'");
            $hasil = "Berhasil Merubah Data BPJS";
        }
    }
    
    echo $hasil;
?>