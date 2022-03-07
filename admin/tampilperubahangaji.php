<table id="table" class="table table-striped table-bordered" style="width:100%">
    <thead style="font-size: 14px;">
        <tr style="text-align: center;">
            <th>#</th>
            <th>Nama</th>
            <th>Nomor Telepon</th>
            <th>Tanggal Input</th>
            <th>Gaji Sebelumnya</th>
            <th>Gaji Sekarang</th>
            <th>Selisih</th>
            <th>Pencatat</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody style="font-size: 12px;">
        <?php
            $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
            $gajipokokdetail = mysqli_query($con, "SELECT * FROM gaji_pokok_detail ORDER BY id DESC");
            if (mysqli_num_rows($gajipokokdetail) > 0) {
                $row = 1;
                function rupiah($angka)
                {
                    $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
                    return $hasil_rupiah;
                }
                while ($data = $gajipokokdetail->fetch_assoc()) {
                    $id_users = $data['id_users'];
                    $tanggal_input = strtotime($data['tanggal_input']);
                    $fixtanggal_input = date("d M Y", $tanggal_input);
                    $gaji_sebelumnya = $data['gaji_sebelumnya'];
                    $gaji_sekarang = $data['gaji_sekarang'];
                    $selisih = preg_replace("/[^0-9]/", "", $data['selisih']);
                    $pencatat = $data['id_pengedit'];
                    if($gaji_sekarang > $gaji_sebelumnya){
                        $keterangan = "Naik";
                        $color = "green";
                    }else if($gaji_sekarang < $gaji_sebelumnya){
                        $keterangan = "Turun";
                        $color = "red";
                    }else{
                        $color = "grey";
                        $keterangan = "Tetap";
                    }
                    $user = mysqli_query($con, "SELECT * FROM users WHERE id = $id_users");
                    if (mysqli_num_rows($user) > 0) {
                        while ($datas = $user->fetch_assoc()) {
                            $no_telp = $datas['nomor_telp'];
                            $nama = $datas['nama'];
                        }
                    }

                    $user_pencatat = mysqli_query($con, "SELECT * FROM users WHERE id = $pencatat");
                    if (mysqli_num_rows($user_pencatat) > 0) {
                        while ($rows = $user_pencatat->fetch_assoc()) {
                            $name = $rows['nama'];
                        }
                    }
        ?>
        <tr style="<?php echo $color ?>" >
            <td style="text-align: center;"><b><?php echo $row++ ?></b></td>
            <td><?php echo $nama ?></td>
            <td><?php echo $no_telp ?></td>
            <td><?php echo $fixtanggal_input ?></td>
            <td><?php echo rupiah($gaji_sebelumnya) ?></td>
            <td><?php echo rupiah($gaji_sekarang) ?></td>
            <td><?php echo rupiah($selisih) ?></td>
            <td><?php echo $name ?></td>
            <td style="text-align: center; color: <?php echo $color ?>;"><b><?php echo $keterangan ?></b></td>
        </tr>
        <?php 
            }} 
        ?>
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $('.table').DataTable({
            "order": [],
            "language": {
                "lengthMenu": "Tampilkan  _MENU_ Baris per Halaman",
                "zeroRecords": "Tidak ada data ditemukan",
                "info": "Menampilkan Halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "",
                "infoFiltered": "",
                "search": "Pencarian:",
                "paginate": {
                    "previous": "Halaman Sebelumnya",
                    "next": "Halaman Berikutnya"
                }
            },
        });
    });
</script>