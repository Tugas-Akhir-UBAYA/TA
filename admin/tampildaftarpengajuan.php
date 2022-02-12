<table id="table" class="table table-striped table-bordered" style="width:100%">
    <thead style="font-size: 16px;">
        <tr style="text-align: center;">
            <th>#</th>
            <th>Nama</th>
            <th>Keterangan</th>
            <th>Kategori</th>
            <th>Status</th>
            <th>Detail</th>
            <th>Verifikasi</th>
        </tr>
    </thead>
    <tbody style="font-size: 12px;">
        <?php
            $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
            $pengajuan = mysqli_query($con, "SELECT * FROM pengajuan ORDER BY id DESC");
            if (mysqli_num_rows($pengajuan) > 0) {
                $row = 1;
                while ($data = $pengajuan->fetch_assoc()) {
                    $id = $data['id'];
                    $id_users = $data['id_users'];
                    $users = mysqli_query($con, "SELECT * FROM users WHERE id = '$id_users'");
                    $cekusers = mysqli_fetch_assoc($users);
                    if ($cekusers > 0) {
                        $nama = $cekusers['nama'];
                        $notelp = $cekusers['nomor_telp'];
                    }
                    $keterangan = $data['keterangan'];
                    $kategori = ucwords($data['kategori']);
                    $status = ucwords($data['status']);
                    if($kategori == "Lainlain"){
                        $kategori = "Lain - Lain";
                    }
                    $tanggal_awal = $data['tanggal_awal'];
                    if($status == ""){
                        $status = "-";
                    }

                    if($kategori == "Cuti"){
                        date_default_timezone_set('Asia/Jakarta');
                        $start_date = strtotime($tanggal_awal);
                        $haristart_date = date("d", $start_date) * 1;
                        $bulanstart_date = date("m", $start_date) * 30.4167;
                        $tahunstart_date = date("Y", $start_date) * 365.25;
                        $totalstart_date = $haristart_date + $bulanstart_date + $tahunstart_date;
                        
        
                        $harinow_date = date("d") * 1;
                        $bulannow_date = date("m") * 30.4167;
                        $tahunnow_date = date("Y") * 365.25;
                        $totalnow_date = $harinow_date + $bulannow_date + $tahunnow_date;
                        if($totalnow_date >= $totalstart_date && $status == "Proses"){
                            $status = "Gagal";
                            $updatestatus = mysqli_query($con, "UPDATE pengajuan SET status = 'gagal' WHERE id = '$id'");
                        }
                    }
        ?>
        <tr>
            <td style="text-align: center;"><b><?php echo $row++ ?></b></td>
            <td><?php echo $nama ?></td>
            <td><?php echo $keterangan ?></td>
            <td><?php echo $kategori ?></td>
            <td><?php echo $status ?></td>
            <td style="text-align: center;">
                <button class="btn btn-info detail" id="<?php echo $id ?>" value="<?php echo $id ?>" name="detail">
                    <img style="width: 25px; height: 30px;" src="../images/icon-deatail.png">
                </button>
            </td>
            <?php if($kategori == "Cuti"){
                date_default_timezone_set('Asia/Jakarta');
                $start_date = strtotime($tanggal_awal);
                $haristart_date = date("d", $start_date) * 1;
                $bulanstart_date = date("m", $start_date) * 30.4167;
                $tahunstart_date = date("Y", $start_date) * 365.25;
                $totalstart_date = $haristart_date + $bulanstart_date + $tahunstart_date;
                

                $harinow_date = date("d") * 1;
                $bulannow_date = date("m") * 30.4167;
                $tahunnow_date = date("Y") * 365.25;
                $totalnow_date = $harinow_date + $bulannow_date + $tahunnow_date;
                if($totalnow_date < $totalstart_date && $status == "Proses"){
                    ?>
                        <td style="text-align: center;">
                            <button class="btn btn-success setuju" id="<?php echo $id ?>" verifikasi="setuju" value="<?php echo $id ?>" name="setuju">
                                <img style="width: 25px; height: 30px;" src="../images/icon-centang.png">
                            </button>
                            <button class="btn btn-danger tolak" id="<?php echo $id ?>" verifikasi="tolak" value="<?php echo $id ?>" style="margin-left: 20px;" name="tolak">
                                <img style="width: 25px; height: 30px;" src="../images/icon-cross.png">
                            </button>
                        </td>
                    <?php
                }else{
                    ?>
                        <td style="text-align: center;">-</td>
                    <?php
                }
                ?> 
                    
                <?php
            }else{
                ?>
                    <td style="text-align: center;">-</td>
                <?php
            } ?>
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

        $('.detail').click(function(){
            var id = $(this).attr('id');
            
            $.ajax({
                url: 'detailpengajuan.php',
                method: 'post',
                data: {
                    id: id
                },
                success: function(data) {

                    $('#detail_pengajuan').html(data);
                    $("#modalForm1").modal('show');
                    $('.close').click(function(){
                        $("#modalForm1").modal('hide');
                    });
                },
            })
        });

        $('.setuju').click(function(){
            var id = $(this).attr('id');
            var verifikasi = $(this).attr('verifikasi');
            Swal.fire({
                title: 'Verifikasi Pengajuan Cuti',
                text: "Apakah anda yakin ingin memberikan izin cuti?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: 'ajaxverifikasi.php',
                        method: 'post',
                        data: {
                            id: id,
                            verifikasi: verifikasi
                        },
                        success: function(data) {
                            if(data == "Proses Verifikasi Telah Berhasil"){
                                Swal.fire({
                                    title: 'Sukses',
                                    html: 'Proses Verifikasi Telah Berhasil',
                                    type: 'success'
                                }).then((result) => {
                                    if (result.value) {
                                        $('.tabledaftarpengajuanizin').load("tampildaftarpengajuan.php");
                                    }
                                })
                            }else if(data == "Proses Verifikasi Gagal"){
                                Swal.fire({
                                    title: 'Ups...',
                                    html: 'Proses Verifikasi Gagal',
                                    type: 'error'
                                })
                            }
                        },
                    })
                }
            })
        });

        $('.tolak').click(function(){
            var id = $(this).attr('id');
            var verifikasi = $(this).attr('verifikasi');
            Swal.fire({
                title: 'Verifikasi Pengajuan Cuti',
                text: "Apakah anda yakin tidak memberikan izin cuti?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: 'ajaxverifikasi.php',
                        method: 'post',
                        data: {
                            id: id,
                            verifikasi: verifikasi
                        },
                        success: function(data) {
                            if(data == "Proses Verifikasi Telah Berhasil"){
                                Swal.fire({
                                    title: 'Sukses',
                                    html: 'Proses Verifikasi Telah Berhasil',
                                    type: 'success'
                                }).then((result) => {
                                    if (result.value) {
                                        $('.tabledaftarpengajuanizin').load("tampildaftarpengajuan.php");
                                    }
                                })
                            }else if(data == "Proses Verifikasi Gagal"){
                                Swal.fire({
                                    title: 'Ups...',
                                    html: 'Proses Verifikasi Gagal',
                                    type: 'error'
                                })
                            }
                        },
                    })
                }
            })
        });
    });
</script>