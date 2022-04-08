<?php
$con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
$notelp = $_COOKIE['notelp'];

$user = mysqli_query($con, "SELECT * FROM users WHERE nomor_telp=$notelp");
$cekuser = mysqli_fetch_assoc($user);
if ($cekuser > 0) {
    $id_users = $cekuser['id'];
} 

$monthnow = date('m-Y');
function rupiah($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}

$gajipokok = mysqli_query($con, "SELECT gaji_pokok FROM users WHERE nomor_telp = $notelp");
if (mysqli_num_rows($gajipokok) > 0) {
    while ($data = $gajipokok->fetch_assoc()) {
        $gaji_pokok = $data['gaji_pokok'];
    }
}

$dendalain = mysqli_query($con, "SELECT SUM(nominal) as totaldenda FROM datadenda_lainlain WHERE id_users = $id_users AND status = 0");
if (mysqli_num_rows($dendalain) > 0) {
    while ($datas = $dendalain->fetch_assoc()) {
        $denda_lainlain = $datas['totaldenda'];
    }
} else {
    $denda_lainlain = 0;
}

$dendaterlambat = mysqli_query($con, "SELECT SUM(denda) as totaldendaterlambat FROM detail_absensi_terlambat WHERE id_users = $id_users AND tanggal_input LIKE '%$monthnow%'");
if (mysqli_num_rows($dendaterlambat) > 0) {
    while ($row = $dendaterlambat->fetch_assoc()) {
        $denda_terlambat = $row['totaldendaterlambat'];
    }
} else {
    $denda_terlambat = 0;
}


$bpjsketenagakerjaan = 0;
$bpjskesehatan = 0;
$detail_bpjs = mysqli_query($con, "SELECT * FROM detail_bpjs as db INNER JOIN bpjs as b ON db.id_bpjs = b.id  WHERE db.id_users = '$id_users'");
if (mysqli_num_rows($detail_bpjs) > 0) {
    while ($rows = mysqli_fetch_array($detail_bpjs)) {
        $id_bpjs = $rows['id_bpjs'];
        $nama_bpjs = $rows['nama_bpjs'];
        $nominal = $rows['nominal'];
        if ($nama_bpjs == 'BPJS Ketenagakerjaan') {
            $bpjsketenagakerjaan = $nominal;
        } else if ($nama_bpjs == 'BPJS Kesehatan') {
            $bpjskesehatan = $nominal;
        }
    }
}

$totalbpjs = intval($bpjskesehatan) + intval($bpjsketenagakerjaan);


$totalgaji = intval($gaji_pokok) - intval($denda_lainlain) - intval($denda_terlambat) - $totalbpjs;


?>
<table style="font-size: 12px;">
    <tr>
        <td style="width: 120px;">Biaya BPJS</td>
        <td style="width: 10px;">:</td>
        <td><?php echo rupiah($totalbpjs) ?></td>
    </tr>
    <tr>
        <td>Denda Terlambat</td>
        <td>:</td>
        <td><?php echo rupiah($denda_terlambat) ?></td>
    </tr>
    <tr>
        <td>Denda Lain - Lain</td>
        <td>:</td>
        <td><?php echo rupiah($denda_lainlain) ?></td>
    </tr>
    <tr>
        <td>Gaji Pokok</td>
        <td>:</td>
        <td><?php echo rupiah($gaji_pokok) ?></td>
    </tr>
    <tr>
        <th>Total Gaji</th>
        <th>:</th>
        <th><?php echo rupiah($totalgaji) ?></th>
    </tr>
</table>