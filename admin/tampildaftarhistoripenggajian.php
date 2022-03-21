<table id="table" class="table table-striped table-bordered" style="width:100%">
    <thead style="font-size: 16px;">
        <tr style="text-align: center;">
            <th>#</th>
            <th>Nama</th>
            <th>Nomor Telepon</th>
            <th>Total Gaji</th>
            <th>Total Denda</th>
            <th>Total Biaya BPJS</th>
            <th>Tanggal Input</th>
            <th>Pencatat</th>
        </tr>
    </thead>
    <tbody style="font-size: 12px;">
        <?php
            $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
            $histori_penggajian = mysqli_query($con, "SELECT * FROM histori_penggajian");
            if (mysqli_num_rows($histori_penggajian) > 0) {
                $row = 1;
                function rupiah($angka)
                {
                    $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
                    return $hasil_rupiah;
                }
                while ($data = $histori_penggajian->fetch_assoc()) {
                    $id_users = $data['id_users'];
                    $pencatat = $data['id_pencatat'];
                    $total_gaji = $data['total_gaji'];
                    $total_denda = $data['total_denda'];
                    $jumlah_terlambat = $data['jumlah_terlambat'];
                    $totalbiaya_bpjs = $data['totalbiaya_bpjs'];
                    $tanggal_input = strtotime($data['tanggal_input']);
                    $fixtanggal_input = date("d M Y", $tanggal_input);
                    $users = mysqli_query($con, "SELECT * FROM users WHERE id = '$id_users'");
                    $cekusers = mysqli_fetch_assoc($users);
                    if ($cekusers > 0) {
                        $nama = $cekusers['nama'];
                        $notelp = $cekusers['nomor_telp'];
                    }

                    $pencatat = mysqli_query($con, "SELECT * FROM users WHERE id = '$pencatat'");
                    $cekpencatat = mysqli_fetch_assoc($pencatat);
                    if ($cekpencatat > 0) {
                        $namapencatat = $cekpencatat['nama'];
                    }

                    // $bpjsketenagakerjaan = 0;
                    // $bpjskesehatan = 0;
                    // $detail_bpjs = mysqli_query($con, "SELECT * FROM detail_bpjs as db INNER JOIN bpjs as b ON db.id_bpjs = b.id  WHERE db.id_users = '$id_users'");
                    // if (mysqli_num_rows($detail_bpjs) > 0) {
                    //     while ($datas = mysqli_fetch_array($detail_bpjs)) {
                    //         $id_bpjs = $datas['id_bpjs'];
                    //         $nama_bpjs = $datas['nama_bpjs'];
                    //         $nominal = $datas['nominal'];
                    //         if($nama_bpjs == 'BPJS Ketenagakerjaan'){
                    //             $bpjsketenagakerjaan = $nominal;
                    //         }else if($nama_bpjs == 'BPJS Kesehatan'){
                    //             $bpjskesehatan = $nominal;
                    //         }
                    //     }
                    // }

                    // $totalbpjs = intval($bpjskesehatan) + intval($bpjsketenagakerjaan);
        ?>
        <tr>
            <td style="text-align: center;"><b><?php echo $row++ ?></b></td>
            <td><?php echo $nama ?></td>
            <td><?php echo $notelp ?></td>
            <td><?php echo rupiah($total_gaji) ?></td>
            <td><?php echo rupiah($total_denda) ?></td>
            <td><?php echo rupiah($totalbiaya_bpjs) ?></td>
            <td><?php echo $fixtanggal_input ?></td>
            <td><?php echo $namapencatat ?></td>
        </tr>
        <?php 
            }} 
        ?>
    </tbody>
</table>
<div class="modal fade" id="modalForm1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Pengajuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detail_pengajuan">
                
            </div>
        </div>
    </div>
</div>

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