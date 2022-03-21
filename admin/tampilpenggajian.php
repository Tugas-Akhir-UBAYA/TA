<table id="table" class="table table-striped table-bordered" style="width:100%">
    <thead style="font-size: 14px;">
        <tr style="text-align: center;">
            <th>#</th>
            <th>Nama</th>
            <th>Gaji Pokok</th>
            <th>Total Denda</th>
            <th>Total Gaji</th>
            <th>Total Terlambat</th>
            <th>Status BPJS</th>
            <th>Detail</th>
        </tr>
    </thead>
    <tbody style="font-size: 12px;">
        <?php
            $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
            $users = mysqli_query($con, "SELECT * FROM users WHERE jabatan != 1");
            if (mysqli_num_rows($users) > 0) {
                $row = 1;
                function rupiah($angka)
                {
                    $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
                    return $hasil_rupiah;
                }
                while ($data = $users->fetch_assoc()) {
                    $id_users = $data['id'];
                    date_default_timezone_set('Asia/Jakarta');
                    $datenow = date("m-Y");
                    $absensi = mysqli_query($con, "SELECT COUNT(*) AS jumlah FROM absensi WHERE id_users = $id_users AND status = 'Terlambat' AND keterangan = 'Presensi Datang' AND tanggal LIKE '%$datenow%'");
                    $cekabsensi = mysqli_fetch_assoc($absensi);

                    if($cekabsensi > 0){
                        $jumlah = $cekabsensi['jumlah'];
                    }else{
                        $jumlah = 0;
                    }

                    $status_bpjs = $data['status_bpjs'];
                    if($status_bpjs == 1){
                        $fixbpjs = "Aktif";
                    }else if($status_bpjs == 0){
                        $fixbpjs = "Tidak Aktif";
                    }

                    $absensi_detail = mysqli_query($con, "SELECT SUM(denda) AS denda FROM detail_absensi_terlambat WHERE id_users = $id_users AND tanggal_input LIKE '%$datenow%'");
                    $cekabsensi_detail = mysqli_fetch_assoc($absensi_detail);

                    if($cekabsensi_detail > 0){
                        $denda = $cekabsensi_detail['denda'];
                    }else{
                        $denda = 0;
                    }
                    $bpjsketenagakerjaan = 0;
                    $bpjskesehatan = 0;
                    $detail_bpjs = mysqli_query($con, "SELECT * FROM detail_bpjs as db INNER JOIN bpjs as b ON db.id_bpjs = b.id  WHERE db.id_users = '$id_users'");
                    if (mysqli_num_rows($detail_bpjs) > 0) {
                        while ($datas = mysqli_fetch_array($detail_bpjs)) {
                            $id_bpjs = $datas['id_bpjs'];
                            $nama_bpjs = $datas['nama_bpjs'];
                            $nominal = $datas['nominal'];
                            if($nama_bpjs == 'BPJS Ketenagakerjaan'){
                                $bpjsketenagakerjaan = $nominal;
                            }else if($nama_bpjs == 'BPJS Kesehatan'){
                                $bpjskesehatan = $nominal;
                            }
                        }
                    }

                    $totalbpjs = intval($bpjskesehatan) + intval($bpjsketenagakerjaan);

                    $nama = $data['nama'];
                    $nomor_telp = $data['nomor_telp'];
                    $gaji_pokok = $data['gaji_pokok'];
                    $totalgaji = intval($gaji_pokok) - intval($denda) - $totalbpjs;
        ?>
        <tr style="<?php echo $color ?>" >
            <td style="text-align: center;"><b><?php echo $row++ ?></b></td>
            <td><?php echo $nama ?></td>
            <td><?php echo rupiah($gaji_pokok) ?></td>
            <td><?php echo rupiah($denda) ?></td>
            <td><?php echo rupiah($totalgaji) ?></td>
            <td style="text-align: center;"><?php echo $jumlah ?> hari</td>
            <td ><?php echo $fixbpjs ?></td>
            <td style="text-align: center;"><button class="btn btn-info detail" id="<?php echo $nomor_telp ?>" pencatat="<?php echo $_COOKIE['notelp'] ?>" value="<?php echo $no_telp ?>" name="detail"><img style="width: 25px; height: 30px;" src="../images/icon-deatail.png"></button></td>
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
                <h5 class="modal-title" id="exampleModalLabel">Detail Penggajian Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detail_penggajian">
                
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

        $('.detail').click(function(){
            var notelp = $(this).attr('id');
            var pencatat = $(this).attr('pencatat');
            $.ajax({
                url: 'detailpenggajian.php',
                method: 'post',
                data: {
                    notelp: notelp,
                    pencatat: pencatat
                },
                success: function(data) {

                    $('#detail_penggajian').html(data);
                    $("#modalForm1").modal('show');
                    $('.close').click(function(){
                        $("#modalForm1").modal('hide');
                    });
                },
            })
        });
    });
</script>