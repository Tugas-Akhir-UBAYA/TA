<?php 
    $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
    $id_dendaterlambat = $_POST['id_dendaterlambat'];
    $datadendaterlambat = mysqli_query($con, "SELECT * FROM denda_terlambat WHERE id = '$id_dendaterlambat'");
    $cekdatadendaterlambat = mysqli_fetch_assoc($datadendaterlambat);
    if ($cekdatadendaterlambat > 0) {
        $id_datadendaterlambat = $cekdatadendaterlambat['id'];
        $sql1 = mysqli_query($con, "DELETE FROM denda_terlambat WHERE id = $id_datadendaterlambat");
        $hasil = "Data Denda Terlambat Berhasil Dihapus";
    }else{
        $hasil = "Data Denda Terlambat Tidak Ditemukan";
    }
    
    echo $hasil;
?>