<table id="table" class="table table-striped table-bordered" style="width:100%">
    <thead style="font-size: 14px;">
        <tr style="text-align: center;">
            <th>#</th>
            <th>Tanggal Input</th>
            <th>Nama BPJS</th>
            <th>Biaya</th>
            <th>Ubah</th>
        </tr>
    </thead>
    <tbody style="font-size: 12px;">
        <?php
        $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
        $bpjs = mysqli_query($con, "SELECT * FROM bpjs");
        if (mysqli_num_rows($bpjs) > 0) {
            $row = 1;
            function rupiah($angka)
            {
                $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
                return $hasil_rupiah;
            }
            while ($data = $bpjs->fetch_assoc()) {
                $id_bpjs = $data['id'];
                $nama = $data['nama_bpjs'];
                $tanggal_input = strtotime($data['tanggal_input']);
                $fixtanggal_input = date("d F Y", $tanggal_input);
                $nominal = $data['nominal'];
        ?>
                <tr style="<?php echo $color ?>">
                    <td style="text-align: center;"><b><?php echo $row++ ?></b></td>
                    <td><?php echo $nama ?></td>
                    <td><?php echo $fixtanggal_input ?></td>
                    <td><?php echo rupiah($nominal) ?></td>
                    <td style="text-align: center;"><button class="btn btn-primary edit" id="<?php echo $id_bpjs ?>" value="<?php echo $no_telp ?>" name="ubah"><img style="width: 25px; height: 30px;" src="../images/icon-edit.png"></button></td>
                </tr>
        <?php
            }
        }
        ?>
    </tbody>
</table>
<input hidden class="notelp" value="<?php echo $_COOKIE['notelp'] ?>">
<div class="modal fade" id="modalForm1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data BPJS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="edit_bpjs">

            </div>
        </div>
    </div>
</div>

<script>
    $('.edit').click(function() {
        var id_bpjs = $(this).attr('id');
        var notelp = $('.notelp').val();
        $.ajax({
            url: 'editbpjs.php',
            method: 'post',
            data: {
                id_bpjs: id_bpjs,
                notelp: notelp,
            },
            success: function(data) {
                $('#edit_bpjs').html(data);
                $("#modalForm1").modal('show');
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
                    var id_users = $('.id_users').val();
                    var tgl_input = $('.tgl_input').val();
                    var id_bpjs = $('.id_bpjs').val();
                    var nama_bpjs = $('.nama_bpjs').val();
                    var nominal = $('.nominal').val();
                    if (nama_bpjs == "" || nominal == "") {
                        Swal.fire({
                            title: 'Ups...',
                            html: 'Semua Data Harus di Isi !!!',
                            type: 'error'
                        })
                    } else {
                        $.ajax({
                            url: 'ajaxeditbpjs.php',
                            method: 'post',
                            data: {
                                id_users: id_users,
                                id_bpjs: id_bpjs,
                                tgl_input: tgl_input,
                                nama_bpjs: nama_bpjs,
                                nominal: nominal,
                            },
                            success: function(data) {
                                $("#modalForm1").modal('hide');
                                if (data == "Berhasil Merubah Data BPJS") {
                                    Swal.fire({
                                        title: 'Berhasil',
                                        html: 'Data BPJS Berhasil di Ubah',
                                        type: 'success'
                                    }).then((result) => {
                                        if (result.value) {
                                            $('.tablebpjs').load("tampildaftarbpjs.php");
                                        }
                                    })
                                } else if (data == "Nama BPJS Telah di Gunakan") {
                                    Swal.fire({
                                        title: 'Ups...',
                                        html: 'Nama BPJS Telah di Gunakan',
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