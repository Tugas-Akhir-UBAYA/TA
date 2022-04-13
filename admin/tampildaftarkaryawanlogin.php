<table id="table" class="table table-striped table-bordered" style="width:100%;">
    <thead style="font-size: 16px;">
        <tr style="text-align: center;">
            <th>#</th>
            <th>Nama</th>
            <th>Nomor Telepon</th>
            <th>Alamat Tinggal</th>
            <th>Jabatan</th>
            <th>Terakhir Login</th>
            <th>Logout</th>
        </tr>
    </thead>
    <tbody style="font-size: 12px;">
        <?php
        $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
        $users = mysqli_query($con, "SELECT * FROM users as u INNER JOIN cookies as c on u.id = c.id_users WHERE status = 1");
        if (mysqli_num_rows($users) > 0) {
            $row = 1;
            $user_login = $_COOKIE['notelp'];
            while ($data = $users->fetch_assoc()) {
                $create_at = $data['create_at'];
                $nama = $data['nama'];
                $no_telp = $data['nomor_telp'];
                $jabatan = $data['jabatan'];
                if ($jabatan == 1) {
                    $jabatan = "Admin";
                } else if ($jabatan == 0) {
                    $jabatan = "Karyawan";
                }
                $nik = $data['nik'];
                $alamat_tinggal = $data['alamat_tinggal'];
                $tgl_awalkerja = $data['tgl_awalkerja'];
                $no_rekening = $data['nomor_rekening'];
                $gaji_pokok = $data['gaji_pokok'];
                $status_bpjs = $data['status_bpjs'];
                $status_kerja = $data['status_kerja'];
                if ($status_bpjs == 1) {
                    $status_bpjs = "Aktif";
                } else if ($status_bpjs == 0) {
                    $status_bpjs = "Tidak Aktif";
                }

                if ($status_kerja == 1) {
                    $status_kerja = "Aktif";
                    $color = "";
                } else if ($status_kerja == 0) {
                    $status_kerja = "Tidak Aktif";
                    $color = "background-color: rgb(204, 204, 204); color: rgb(126, 126, 126);";
                }
        ?>
                <tr style="<?php echo $color ?>">
                    <td style="text-align: center;"><b><?php echo $row++ ?></b></td>
                    <td><?php echo $nama ?></td>
                    <td><?php echo $no_telp ?></td>
                    <td><?php echo $alamat_tinggal ?></td>
                    <td><?php echo $jabatan ?></td>
                    <td><?php echo $create_at  ?></td>
                    <?php if ($user_login != $no_telp) {
                    ?>
                        <td style="text-align: center;"><button class="btn btn-danger keluar" id="<?php echo $no_telp ?>" value="<?php echo $no_telp ?>" name="detail"><img style="width: 25px; height: 30px;" src="../images/icon-exit.png"></button></td>
                    <?php
                    } else {
                    ?>
                        <td style="text-align: center;">-</td>
                    <?php
                    } ?>
                </tr>
        <?php
            }
        }
        ?>
    </tbody>
</table>
<div class="modal fade" id="modalForm1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detail_karyawan">

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalForm2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="edit_karyawan">

            </div>
        </div>
    </div>
</div>
<script>
    $('.keluar').click(function() {
        var pilih = $(this).attr('id');
        Swal.fire({
            title: 'Logout Akun Karyawan',
            text: "Yakin ingin Logout Akun Karyawan ini?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yakin',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: 'ajaxhapuscookies.php',
                    method: 'post',
                    data: {
                        pilih: pilih
                    },
                    success: function(data) {
                        if (data == "Akun berhasil di logout") {
                            Swal.fire({
                                title: 'Yeah',
                                html: 'Akun berhasil di logout',
                                type: 'success'
                            }).then((result) => {
                                if (result.value) {
                                    $('.tabledaftarkaryawanlogin').load("tampildaftarkaryawanlogin.php");
                                }
                            })
                        } else if (data == "Akun gagal logout") {
                            Swal.fire({
                                title: 'Login Gagal',
                                html: 'Akun gagal logout',
                                type: 'error'
                            })
                        }
                    },
                })
            }
        })
    });

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

        $('.delete').click(function() {
            var notelp = $(this).attr('id');
            Swal.fire({
                title: 'Hapus Data Karyawan',
                text: "Yakin ingin Menghapus Data Karyawan ini?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: 'ajaxdeletekaryawan.php',
                        method: 'post',
                        data: {
                            notelp: notelp
                        },
                        success: function(data) {
                            if (data == "Data Karyawan Berhasil di Hapus") {
                                Swal.fire({
                                    title: 'Berhasil',
                                    html: 'Data Karyawan Berhasil di Hapus',
                                    type: 'success'
                                }).then((result) => {
                                    if (result.value) {
                                        $('.tabledaftarkaryawan').load("tampildaftarkaryawan.php");
                                    }
                                })
                            } else if (data == "Data Karyawan Gagal di Hapus") {
                                Swal.fire({
                                    title: 'Ups...',
                                    html: 'Data Karyawan Gagal di Hapus',
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