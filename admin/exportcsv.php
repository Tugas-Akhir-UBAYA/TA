<?php 
    $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
    $tgl_export = strtotime($_GET['tgl_export']);
    $judul_file = $_GET['judul_file'];
    $rekenings = $_GET['rekenings'];
    $fixtgl_export = date("m-Y", $tgl_export);
    date_default_timezone_set('Asia/Jakarta');
    $bulan = date("F Y");
    $datenow = date("Y/m/d_h:i:s");
    $tanggalsekarang = date("Ymd");
    
    $filename = 'Penggajian Bulan '.$bulan.'.csv';
    
    $penggajian = array();
    $file = fopen($filename,"w");
    $jumlahuser = mysqli_query($con, "SELECT COUNT(id) AS jumlah FROM users WHERE jabatan != 1");
    $cekjumlahuser = mysqli_fetch_assoc($jumlahuser);
    if($cekjumlahuser > 0){
        $jumlahorang = $cekjumlahuser['jumlah'];
    }else{
        $jumlahorang = 0;
    }

    $rekening = mysqli_query($con, "SELECT * FROM rekening WHERE id = '$rekenings'");
    $cekrekening = mysqli_fetch_assoc($rekening);
    if($cekrekening > 0){
        $no_rekening = $cekrekening['no_rekening'];
    }else{
        $no_rekening = 0;
    }

    $jumlahgaji = mysqli_query($con, "SELECT SUM(total_gaji) AS Total FROM histori_penggajian WHERE tanggal_input LIKE '%$fixtgl_export%'");
    $cekjumlahgaji = mysqli_fetch_assoc($jumlahgaji);
    if($cekjumlahgaji > 0){
        $total = $cekjumlahgaji['Total'];
    }else{
        $total = 0;
    }
    $totaljumlahbaris = 2 + $jumlahorang;
    $penggajian = array($datenow.','.$totaljumlahbaris.','.$judul_file.',,,,,,,,,,,,,,,,,');
    fputcsv($file,$penggajian);
    $penggajian = array('P,'.$tanggalsekarang.','.$no_rekening.','.$jumlahorang.','.$total.',,,,,,,,,,,,,,,,');
    fputcsv($file,$penggajian);
    
    $histori_penggajian = mysqli_query($con, "SELECT * FROM histori_penggajian AS h INNER JOIN users AS u ON h.id_users = u.id WHERE h.tanggal_input LIKE '%$fixtgl_export%'");
    if (mysqli_num_rows($histori_penggajian) > 0) {
        while ($data = $histori_penggajian->fetch_assoc()) {
            $norek = $data['nomor_rekening'];
            $nama = $data['nama'];
            $totalgaji = $data['total_gaji'];

            $penggajian = array($norek.','.$nama.','.$totalgaji.',,,,,,,,,,,,,,N,,,N');
            fputcsv($file,$penggajian);
        }
    }else{

    }
    
    fclose($file);
    // download
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=$filename");
    header("Content-Type: application/csv; ");
    
    readfile($filename);
    
    // deleting file
    unlink($filename);
    exit();
?>