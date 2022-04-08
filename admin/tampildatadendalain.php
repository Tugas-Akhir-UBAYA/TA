<table id="table" class="table table-striped table-bordered" style="width:100%">
    <thead style="font-size: 14px;">
        <tr style="text-align: center;">
            <th>#</th>
            <th>Tanggal Input</th>
            <th>Nama Karyawan</th>
            <th>Nominal Denda</th>
            <th>Keterangan</th>
            <th>Ubah</th>
            <th>Hapus</th>
        </tr>
    </thead>
    <tbody style="font-size: 12px;">
        <?php
        $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
        $dendalainlain = mysqli_query($con, "SELECT * FROM datadenda_lainlain");
        if (mysqli_num_rows($dendalainlain) > 0) {
            $row = 1;
            function rupiah($angka)
            {
                $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
                return $hasil_rupiah;
            }
            while ($data = $dendalainlain->fetch_assoc()) {
                $id = $data['id'];
                $id_users = $data['id_users'];
                $tanggal_input = strtotime($data['tanggal_input']);
                $fixtanggal_input = date('d F Y', $tanggal_input);
                $keterangan = $data['keterangan'];
                $nominal = $data['nominal'];
                $status = $data['status'];

                $users = mysqli_query($con, "SELECT * FROM users WHERE id = '$id_users'");
                if (mysqli_num_rows($users) > 0) {
                    while ($datas = $users->fetch_assoc()) {
                        $nama = $datas['nama'];
                    }
                }

        ?>
                <tr style="<?php echo $color ?>">
                    <td style="text-align: center;"><b><?php echo $row++ ?></b></td>
                    <td><?php echo $fixtanggal_input ?></td>
                    <td><?php echo $nama ?></td>
                    <td><?php echo rupiah($nominal) ?></td>
                    <td><?php echo $keterangan ?></td>
                    <td style="text-align: center;"><button class="btn btn-primary edit" id="<?php echo $id ?>" value="<?php echo $id ?>" name="edit"><img style="width: 25px; height: 30px;" src="../images/icon-edit.png"></button></td>
                    <?php if ($status != 1) {
                    ?>
                        <td style="text-align: center;"><button class="btn btn-danger delete" id="<?php echo $id ?>" value="<?php echo $id ?>" name="delete"><img style="width: 25px; height: 30px;" src="../images/icon-delete2.png"></button></td>
                    <?php
                    } else {
                    ?>
                        <td style="text-align: center;">-</td>
                    <?php
                    }
                    ?>
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
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Denda Lain - Lain</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="edit_datadendalain">

            </div>
        </div>
    </div>
</div>

<script>
    $('.edit').click(function() {
        var id = $(this).attr('id');
        $.ajax({
            url: 'editdatadendalain.php',
            method: 'post',
            data: {
                id: id
            },
            success: function(data) {
                $('#edit_datadendalain').html(data);
                $("#modalForm1").modal('show');
                $('#karyawan').select2();
                var rupiah = document.getElementById('nominal');
                rupiah.addEventListener('keyup', function(e) {
                    rupiah.value = formatRupiah(this.value, 'Rp. ');
                });

                /* Fungsi formatRupiah */
                function formatRupiah(angka, prefix) {
                    var number_string = angka.replace(/[^,\d]/g, '').toString(),
                        split = number_string.split(','),
                        sisa = split[0].length % 3,
                        rupiah = split[0].substr(0, sisa),
                        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                    if (ribuan) {
                        separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }

                    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
                }
                $('.ubah').click(function() {
                    var id_dendalain = $('.id_dendalain').val();
                    var nominal = $('#nominal').val();
                    var karyawan = $('#karyawan').val();
                    var keterangans = $('#keterangans').val();
                    if (nominal == "" || karyawan == "" || keterangans == "") {
                        Swal.fire({
                            title: 'Ups...',
                            html: 'Semua Data Harus di Isi !!!',
                            type: 'error'
                        })
                    } else {
                        $.ajax({
                            url: 'ajaxeditdatadendalain.php',
                            method: 'post',
                            data: {
                                id_dendalain: id_dendalain,
                                nominal: nominal,
                                karyawan: karyawan,
                                keterangans: keterangans,
                            },
                            success: function(data) {
                                if (data == "Data denda lain - lain berhasil diubah") {
                                    $("#modalForm1").modal('hide');
                                    Swal.fire({
                                        title: 'Berhasil',
                                        html: 'Data denda lain - lain berhasil diubah',
                                        type: 'success'
                                    }).then((result) => {
                                        if (result.value) {
                                            $('.tablehistoridendalain').load("tampildatadendalain.php");
                                        }
                                    })
                                } else if (data == "Gagal Mengubah Data denda lain - lain") {
                                    Swal.fire({
                                        title: 'Ups...',
                                        html: 'Proses ubah data denda lain - lain tidak berhasil',
                                        type: 'error'
                                    })
                                }
                            },
                        })
                    }
                });
            },
        })
    });

    $('.delete').click(function() {
        var id_dendalainlain = $(this).attr('id');
        Swal.fire({
            title: 'Hapus Data Denda Lain - Lain',
            text: "Yakin ingin Menghapus Data Denda lain - Lain?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yakin',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: 'ajaxdeletedatadendalainlain.php',
                    method: 'post',
                    data: {
                        id_dendalainlain: id_dendalainlain
                    },
                    success: function(data) {
                        if (data == "Data Denda Lain - Lain Berhasil Dihapus") {
                            Swal.fire({
                                title: 'Berhasil',
                                html: 'Data Denda Lain - Lain Berhasil Dihapus',
                                type: 'success'
                            }).then((result) => {
                                if (result.value) {
                                    $('.tablehistoridendalain').load("tampildatadendalain.php");
                                }
                            })
                        } else if (data == "Data Denda Lain - Lain Tidak Ditemukan") {
                            Swal.fire({
                                title: 'Ups...',
                                html: 'Data Denda Lain - Lain Tidak Ditemukan',
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
    });
</script>