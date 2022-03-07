<?php
    $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
    date_default_timezone_set('Asia/Jakarta');
    $tgl_export = strtotime($_POST['tgl_export']);
    $fixtgl_export = date("m-Y", $tgl_export);
    $bulan = date("F");
    
    $filename = 'Penggajian Bulan '.$bulan.'.csv';

    if(isset($tgl_export)){
        $histori_penggajian = mysqli_query($con, "SELECT * FROM histori_penggajian WHERE tanggal_input LIKE '%$fixtgl_export%'");
        $cekhistori_penggajian = mysqli_fetch_assoc($histori_penggajian);
        if ($cekhistori_penggajian > 0) {
            $hasil = "Export Data Penggajian Berhasil";
            
        }else{
            $hasil = "Data Penggajian Bulan Ini Belum Tersedia";
        }
    }
    echo $hasil;
?>