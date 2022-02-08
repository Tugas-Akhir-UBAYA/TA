<?php
    session_start();
    $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
    // $notelp = $_SESSION['notelp'];
    if (isset($_COOKIE['notelp'])) {
        $notelp = $_COOKIE['notelp'];
    }
    $user = mysqli_query($con, "SELECT * FROM users WHERE nomor_telp=$notelp");
    $cekuser = mysqli_fetch_assoc($user);
    if ($cekuser > 0) {
        $id_users = $cekuser['id'];
        $nama = $cekuser['nama'];
    }

?>

<table class="table">
    <thead style="font-size: 10px;">
        <tr>
        <th scope="col">#</th>
        <th scope="col">Tanggal Awal</th>
        <th scope="col">Tanggal Akhir</th>
        <th scope="col">Kategori</th>
        <th scope="col">Status</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $bulan = date("m");
        $tahun = date("Y");
        $awalbulan = '01'  . '-' . $bulan . '-' . $tahun; 
        $akhirbulan = '31' . '-' . $bulan . '-' . $tahun; 
        $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
        $pengajuan = mysqli_query($con, "SELECT * FROM pengajuan WHERE (tanggal_input BETWEEN '$awalbulan' AND '$akhirbulan') AND id_users = $id_users");
        if (mysqli_num_rows($pengajuan) > 0) {
            $row = 1;
            while ($data = $pengajuan->fetch_assoc()) {
                $tanggal_awal = $data['tanggal_awal'];
                $tanggal_akhir = $data['tanggal_akhir'];
                $kategori = $data['kategori'];
                $status = $data['status'];
                if($tanggal_akhir == ""){
                    $tanggal_akhir = "-";
                }
                if($status == 'proses'){
                    $warna = 'kuning';
                    $status = 'Proses';
                }else if($status == ''){
                    $warna = '';
                    $status = '-';
                }else if($status == 'gagal'){
                    $warna = 'merah';
                    $status = 'Gagal';
                }else if($status == 'sukses'){
                    $warna = 'hijau';
                    $status = 'Sukses';
                }
                $keterangan = $data['keterangan'];
    ?>
        <tr style="font-size: 10px;" class="<?php echo $warna ?>">
            <th scope="row"><?php echo $row++ ?></th>
            <td><?php echo $tanggal_awal ?></td>
            <td><?php echo $tanggal_akhir ?></td>
            <td><?php echo $kategori ?></td>
            <td><b><?php echo $status ?></b></td>
        </tr>
        <?php } }else{
            ?>
                <tr style="font-size: 12px;" class="<?php echo $warna ?>">
                    <th scope="row" colspan="5" style="text-align: center;">Data Belum Tersedia</th>
                </tr>
            <?php
        }?>
    </tbody>
</table>