<?php 
    $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
    $id_dendalainlain = $_POST['id_dendalainlain'];
    $datadendalainlain = mysqli_query($con, "SELECT * FROM datadenda_lainlain WHERE id = '$id_dendalainlain' AND status = 0");
    $cekdatadendalainlain = mysqli_fetch_assoc($datadendalainlain);
    if ($cekdatadendalainlain > 0) {
        $id_datadendalainlain = $cekdatadendalainlain['id'];
        $sql1 = mysqli_query($con, "DELETE FROM datadenda_lainlain WHERE id = $id_dendalainlain");
        $hasil = "Data Denda Lain - Lain Berhasil Dihapus";
    }else{
        $hasil = "Data Denda Lain - Lain Tidak Ditemukan";
    }
    
    echo $hasil;
?>