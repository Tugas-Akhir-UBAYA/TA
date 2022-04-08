<table id="table" class="table table-striped table-bordered" style="width:100%">
    <thead style="font-size: 14px;">
        <tr style="text-align: center;">
            <th>#</th>
            <th>Nama</th>
            <th>Nomor Telepon</th>
            <th>Tanggal</th>
            <th>Waktu Datang</th>
            <th>Waktu Pulang</th>
        </tr>
    </thead>
    <tbody style="font-size: 12px;">
        <?php
        $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
        $absensi = mysqli_query($con, "SELECT id_users,  tanggal, GROUP_CONCAT(waktu SEPARATOR',') datang_pulang, GROUP_CONCAT(status SEPARATOR',') status_absensi FROM absensi WHERE keterangan != 'Keluar Istirahat' AND keterangan != 'Masuk Setelah Istirahat' GROUP BY id_users, tanggal ORDER BY tanggal");
        if (mysqli_num_rows($absensi) > 0) {
            $row = 1;
            while ($data = $absensi->fetch_assoc()) {
                $id_users = $data['id_users'];
                $tanggal = strtotime($data['tanggal']);
                $fixtanggal = date("d M Y", $tanggal);
                $waktu = $data['datang_pulang'];
                $fixwaktu = explode(",", $waktu);
                if (isset($fixwaktu[1])) {
                    $fixtime = $fixwaktu[1];
                } else {
                    $fixtime = "-";
                }
                $users = mysqli_query($con, "SELECT * FROM users WHERE id = $id_users");
                if (mysqli_num_rows($users) > 0) {
                    while ($datas = $users->fetch_assoc()) {
                        $nama = $datas['nama'];
                        $no_telp = $datas['nomor_telp'];
                    }
                }
        ?>
                <tr>
                    <td style="text-align: center;"><b><?php echo $row++ ?></b></td>
                    <td><?php echo $nama ?></td>
                    <td><?php echo $no_telp ?></td>
                    <td><?php echo $fixtanggal ?></td>
                    <td><?php echo $fixwaktu[0] ?></td>
                    <td><?php echo $fixtime ?></td>
                </tr>
        <?php
            }
        }
        ?>
    </tbody>
</table>
<script>
    $('.detail').click(function() {
        var notelp = $(this).attr('id');
        $.ajax({
            url: 'detailkaryawan.php',
            method: 'post',
            data: {
                notelp: notelp
            },
            success: function(data) {

                $('#detail_karyawan').html(data);
                $("#modalForm1").modal('show');
                $('.close').click(function() {
                    $("#modalForm1").modal('hide');
                });
            },
        })
    });

    $('.edit').click(function() {
        var notelp = $(this).attr('id');
        $.ajax({
            url: 'editkaryawan.php',
            method: 'post',
            data: {
                notelp: notelp
            },
            success: function(data) {
                $('#edit_karyawan').html(data);
                $("#modalForm2").modal('show');
                var rupiah = document.getElementById('gaji');
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
                    var id_users = $('#id_users').val();
                    var nik = $('#nik').val();
                    var nama = $('#nama').val();
                    var tgl_awal = $('#tgl_awal').val();
                    var norek = $('#no_rekening').val();
                    var gaji = $('#gaji').val();
                    var notelp = $('#no_telp').val();
                    var jabatan = $('#jabatan').val();
                    var bpjs = $('#bpjs').val();
                    var alamat_tinggal = $('#alamat_tinggal').val();
                    if (nik == "" || nama == "" || tgl_awal == "" || norek == "" || gaji == "" || notelp == "" || jabatan == "" || bpjs == "" || alamat_tinggal == "") {
                        Swal.fire({
                            title: 'Ups...',
                            html: 'Semua Data Harus di Isi !!!',
                            type: 'error'
                        })
                    } else {
                        $.ajax({
                            url: 'ajaxeditdatakaryawan.php',
                            method: 'post',
                            data: {
                                id_users: id_users,
                                nik: nik,
                                nama: nama,
                                tgl_awal: tgl_awal,
                                norek: norek,
                                gaji: gaji,
                                notelp: notelp,
                                jabatan: jabatan,
                                bpjs: bpjs,
                                alamat_tinggal: alamat_tinggal
                            },
                            success: function(data) {
                                // $("#modalForm2").modal('hide');
                                if (data == "Data Karyawan Berhasil di Ubah") {
                                    $("#modalForm2").modal('hide');
                                    Swal.fire({
                                        title: 'Berhasil',
                                        html: 'Data Karyawan Berhasil di Ubah',
                                        type: 'success'
                                    }).then((result) => {
                                        if (result.value) {
                                            $('.tabledaftarkaryawan').load("tampildaftarkaryawan.php");
                                        }
                                    })
                                } else if (data == "Nomor Telepon Sudah di Gunakan") {
                                    Swal.fire({
                                        title: 'Ups...',
                                        html: 'Nomor Telepon Sudah di Gunakan',
                                        type: 'error'
                                    })
                                } else if (data == "NIK Sudah di Gunakan") {
                                    Swal.fire({
                                        title: 'Ups...',
                                        html: 'NIK Sudah di Gunakan',
                                        type: 'error'
                                    })
                                } else if (data == "No. Rekening Sudah di Gunakan") {
                                    Swal.fire({
                                        title: 'Ups...',
                                        html: 'No. Rekening Sudah di Gunakan',
                                        type: 'error'
                                    })
                                } else if (data == "Gagal Mengubah Data Karyawan") {
                                    Swal.fire({
                                        title: 'Gagal Mengubah Data Karyawan',
                                        html: 'Data Karyawan Tidak di Temukan',
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