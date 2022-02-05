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
    <thead style="font-size: 14px;">
        <tr>
        <th scope="col">#</th>
        <th scope="col">Tanggal</th>
        <th scope="col">Waktu</th>
        <th scope="col">Status</th>
        <th scope="col">Keterangan</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
        $absensi = mysqli_query($con, "SELECT * FROM absensi WHERE id_users = '$id_users'");
        if (mysqli_num_rows($absensi) > 0) {
            $row = 1;
            while ($data = $absensi->fetch_assoc()) {
                $tanggal = $data['tanggal'];
                $waktu = $data['waktu'];
                $status = $data['status'];
                if($status == 'Izin'){
                    $warna = 'kuning';
                }else if($status == '-'){
                    $warna = '';
                }else if($status == 'Terlambat'){
                    $warna = 'merah';
                }else if($status == 'Tepat Waktu'){
                    $warna = 'hijau';
                }
                $keterangan = $data['keterangan'];
    ?>
        <tr style="font-size: 12px;" class="<?php echo $warna ?>">
            <th scope="row"><?php echo $row++ ?></th>
            <td><?php echo $tanggal ?></td>
            <td><?php echo $waktu ?></td>
            <td><?php echo $status ?></td>
            <td><?php echo $keterangan ?></td>
        </tr>
        <?php } }?>
    </tbody>
</table>