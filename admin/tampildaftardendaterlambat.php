<table id="table" class="table table-striped table-bordered" style="width:100%">
    <thead style="font-size: 16px;">
        <tr style="text-align: center;">
            <th>#</th>
            <th>Durasi Terlambat</th>
            <th>Nominal Denda</th>
            <th>Pencatat</th>
            <th>Tanggal Input</th>
            <th>Ubah</th>
            <th>Hapus</th>
        </tr>
    </thead>
    <tbody style="font-size: 12px;">
        <?php
        $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
        $dendaterlambat = mysqli_query($con, "SELECT * FROM denda_terlambat");
        if (mysqli_num_rows($dendaterlambat) > 0) {
            $row = 1;
            function rupiah($angka)
            {
                $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
                return $hasil_rupiah;
            }
            while ($data = $dendaterlambat->fetch_assoc()) {
                $id = $data['id'];
                $durasi = $data['durasi'];
                $denda = $data['denda'];
                $id_pencatat = $data['id_pencatat'];
                $tanggal_input = strtotime($data['tanggal_input']);
                $fixtanggal_input = date('d F Y', $tanggal_input);

                $pencatat = mysqli_query($con, "SELECT * FROM users WHERE id = '$id_pencatat'");
                if (mysqli_num_rows($pencatat) > 0) {
                    while ($datas = $pencatat->fetch_assoc()) {
                        $nama = $datas['nama'];
                    }
                }
        ?>
                <tr style="<?php echo $color ?>">
                    <td style="text-align: center;"><b><?php echo $row++ ?></b></td>
                    <td>Lebih dari <?php echo $durasi ?> Menit</td>
                    <td><?php echo rupiah($denda) ?></td>
                    <td><?php echo $nama ?></td>
                    <td><?php echo $fixtanggal_input ?></td>
                    <td style="text-align: center;"><button class="btn btn-primary edit" id="<?php echo $id ?>" value="<?php echo $id ?>" name="edit"><img style="width: 25px; height: 30px;" src="../images/icon-edit.png"></button></td>
                    <td style="text-align: center;"><button class="btn btn-danger delete" id="<?php echo $id ?>" value="<?php echo $id ?>" name="delete"><img style="width: 25px; height: 30px;" src="../images/icon-delete2.png"></button></td>
                </tr>
        <?php
            }
        }
        ?>
    </tbody>
</table>

<input class="notelp" hidden value="<?php echo $_COOKIE['notelp'] ?>">
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
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Denda Terlambat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="edit_datadendaterlambat">

            </div>
        </div>
    </div>
</div>
<script>
    $('.edit').click(function() {
        var id_dendaterlambat = $(this).attr('id');
        var notelp = $('.notelp').val();
        $.ajax({
            url: 'editdatadendaterlambat.php',
            method: 'post',
            data: {
                id_dendaterlambat: id_dendaterlambat,
                notelp: notelp
            },
            success: function(data) {
                $('#edit_datadendaterlambat').html(data);
                $("#modalForm2").modal('show');
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
                    var idpencatat = $('#idpencatat').val();
                    var id_denda_terlambat = $('#id_denda_terlambat').val();
                    var durasi = $('#durasi').val();
                    var nominal = $('#nominal').val();
                    if (durasi == "" || nominal == "") {
                        Swal.fire({
                            title: 'Ups...',
                            html: 'Semua Data Harus di Isi !!!',
                            type: 'error'
                        })
                    } else {
                        $.ajax({
                            url: 'ajaxeditdatadendaterlambat.php',
                            method: 'post',
                            data: {
                                idpencatat: idpencatat,
                                durasi: durasi,
                                nominal: nominal,
                                id_denda_terlambat: id_denda_terlambat
                            },
                            success: function(data) {
                                if (data == "Data denda terlambat berhasil diubah") {
                                    $("#modalForm2").modal('hide');
                                    Swal.fire({
                                        title: 'Berhasil',
                                        html: 'Data denda terlambat berhasil diubah',
                                        type: 'success'
                                    }).then((result) => {
                                        if (result.value) {
                                            $('.tabledaftardendaterlambat').load("tampildaftardendaterlambat.php");
                                        }
                                    })
                                } else if (data == "Durasi denda terlambat sudah ada") {
                                    Swal.fire({
                                        title: 'Ups...',
                                        html: 'Durasi denda terlambat sudah ada',
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
        var id_dendaterlambat = $(this).attr('id');
        Swal.fire({
            title: 'Hapus Data Denda Terlambat',
            text: "Yakin ingin Menghapus Data Denda Terlambat?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yakin',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: 'ajaxdeletedatadendaterlambat.php',
                    method: 'post',
                    data: {
                        id_dendaterlambat: id_dendaterlambat
                    },
                    success: function(data) {
                        if (data == "Data Denda Terlambat Berhasil Dihapus") {
                            Swal.fire({
                                title: 'Berhasil',
                                html: 'Data Denda Terlambat Berhasil Dihapus',
                                type: 'success'
                            }).then((result) => {
                                if (result.value) {
                                    $('.tabledaftardendaterlambat').load("tampildaftardendaterlambat.php");
                                }
                            })
                        } else if (data == "Data Denda Terlambat Tidak Ditemukan") {
                            Swal.fire({
                                title: 'Ups...',
                                html: 'Data Denda Terlambat Tidak Ditemukan',
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