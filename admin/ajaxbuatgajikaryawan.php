<?php
    $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
    date_default_timezone_set('Asia/Jakarta');
    $pencatat = $_POST['pencatat'];
    $bulansekarang = date('m-Y');
    $datenow = date('d-m-Y');
    
    $historigaji = mysqli_query($con, "SELECT * FROM histori_penggajian WHERE tanggal_input LIKE '%$bulansekarang%'");
    $cekhistorigaji = mysqli_fetch_assoc($historigaji);
    if ($cekhistorigaji > 0) {
        $hasil = "Data gaji bulan ini telah dibuat";
    }else{
        $users = mysqli_query($con, "SELECT * FROM users WHERE jabatan != 1");
        if (mysqli_num_rows($users) > 0) {
            while ($data = $users->fetch_assoc()) {
                $id_users = $data['id'];

                $absensi = mysqli_query($con, "SELECT COUNT(*) AS jumlah FROM absensi WHERE id_users = $id_users AND status = 'Terlambat' AND keterangan = 'Masuk Pagi' AND tanggal LIKE '%$bulansekarang%'");
                $cekabsensi = mysqli_fetch_assoc($absensi);
                if($cekabsensi > 0){
                    $jumlah = $cekabsensi['jumlah'];
                }else{
                    $jumlah = 0;
                }
                $absensi_detail = mysqli_query($con, "SELECT SUM(denda) AS denda FROM detail_absensi_terlambat WHERE id_users = $id_users AND tanggal_input LIKE '%$bulansekarang%'");
                $cekabsensi_detail = mysqli_fetch_assoc($absensi_detail);
                if($cekabsensi_detail > 0){
                    $denda = $cekabsensi_detail['denda'];
                    if($denda == ""){
                        $denda = 0;
                    }
                }else{
                    $denda = 0;
                }

                $gaji_pokok = $data['gaji_pokok'];
                $totalgaji = intval($gaji_pokok) - intval($denda);

                $buatgaji = mysqli_query($con, "INSERT INTO histori_penggajian VALUES(null,'$id_users','$pencatat','$jumlah','$datenow','$totalgaji','$denda')");
                $hasil = "Data gaji berhasil dibuat";

            }
        }
    }
    
    echo $hasil;
?>