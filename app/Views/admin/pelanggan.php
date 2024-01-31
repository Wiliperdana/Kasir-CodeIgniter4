<?=
    $this->extend('layout/template');
    $this->section('content')
?>

<div class="main-panel">
    <div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Daftar Pelanggan </h3>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
            <a href="" class="card-title btn btn-primary btn-icon-text" data-toggle="modal" data-target="#store">
                <i class="mdi mdi-plus btn-icon-prepend"> Tambah Pelanggan</i>
            </a>
            <div class="table-responsive">
                <table class="table">
                <thead>
                    <tr class="text-center">
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No. Telp</th>
                        <th>Update/Delete</th>
                    </tr>
                </thead>
                <tbody id="member-table">
                    
                </tbody>
                </table>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="store">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail</h4>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" id="store_data">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" name="nama" placeholder="Nama" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" name="alamat" placeholder="alamat" required>
                        </div>
                        <div class="form-group">
                            <label for="telp">No. Telp</label>
                            <input type="number" class="form-control" name="telp" required>
                        </div>
                        <button class="btn btn-primary me-2" id="btn-store">Submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="mdi mdi-window-close btn-icon-prepend"> Close</i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="update">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail</h4>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" id="update_data">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" name="nama" placeholder="Nama" id="nama" required>
                            <input type="hidden" name="id_pelanggan" id="id_pelanggan">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" name="alamat" placeholder="alamat" id="alamat" required>
                        </div>
                        <div class="form-group">
                            <label for="telp">No. Telp</label>
                            <input type="telp" class="form-control" name="telp" id="telp" required>
                        </div>
                        <button type="submit" class="btn btn-primary me-2" id="btn-update">Submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="mdi mdi-window-close btn-icon-prepend"> Close</i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="vendor/jquery/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        get_data();
    function get_data() {
        $.ajax({
        url: 'pelanggan/getdata',
        type: 'GET',
        dataType: 'json',
        success: function(data) {

            var html = "";
            var a;

            for(a = 0; a < data.length; a++) {
                html += '<tr class="text-center">' +
                            '<td>' + (a + 1) + '</td>' +
                            '<td>' + data[a].NamaPelanggan + '</td>' +
                            '<td>' + data[a].Alamat + '</td>' +
                            '<td><a href="https://wa.me/' + data[a].NomorTelepon + '" target="_blank" class="text-success">' + 
                            '<i class="mdi mdi-whatsapp"></i> ' + data[a].NomorTelepon + '</a></td>' +
                            '<td>' +
                                '<button id="edit" class="btn btn-warning btn-icon-text" data-id="' + data[a].PelangganID + '">' +
                                    '<i class="mdi mdi-content-save-edit btn-icon-prepend"> Update</i>' +
                                '</button>' +
                                '<button id="delete" class="btn btn-danger btn-icon-text ml-1" data-id="' + data[a].PelangganID + '">' +
                                    '<i class="mdi mdi-delete-empty btn-icon-prepend"> Delete</i>' +
                                '</button>' +
                            '</td>' +
                        '</tr>';
            }

                $("#member-table").html(html);
            }
            });
        };

        $('#btn-store').on('click', function(e) {
            e.preventDefault();

            var nama = $('[name="nama"]').val().trim();
            var alamat = $('[name="alamat"]').val().trim();
            var telp = $('[name="telp"]').val().trim();
            

            if (nama === '' || alamat === '' || telp === '') {
                // Show SweetAlert2 error notification for empty fields
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Semua kolom harus diisi.',
                });
                return;
            }
            
            $.ajax({
                type: 'POST',
                url: 'pelanggan/store',
                data: $('#store_data').serialize(),
                success: function(data) {
                    $('#store').modal('hide');
                    $('[name="id_pelanggan"]').val('');
                    $('[name="nama"]').val('');
                    $('[name="alamat"]').val('');
                    $('[name="telp"]').val('');

                    get_data();

                    // Show SweetAlert2 success notification
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Data berhasil disimpan.',
                    });
                }
            });
        })

        $('#member-table').on('click', '#edit', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                type : 'GET',
                url : 'pelanggan/edit',
                data : {PelangganID : id},
                dataType : 'json',
                success : function(data){
                    $('#update').modal('show');
                    $('#id_pelanggan').val(data.PelangganID);
                    $('#nama').val(data.NamaPelanggan);
                    $('#alamat').val(data.Alamat);
                    $('#telp').val(data.NomorTelepon);
                }
            })
        })

        $('#btn-update').on('click', function(e) {
            e.preventDefault();
            var id = $('#id_pelanggan').val();
            var nama = $('#nama').val();
            var alamat = $('#alamat').val();
            var telp = $('#telp').val();

            $.ajax({
                type : 'POST',
                url : 'pelanggan/update',
                data : {PelangganID : id, NamaPelanggan : nama, Alamat : alamat, NomorTelepon : telp},
                success : function(data){
                    $('#update').modal('hide');
                    $('#id_pelanggan').val('');
                    $('#nama').val('');
                    $('#alamat').val('');
                    $('#telp').val('');

                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Data berhasil diupdate.',
                    });

                    get_data();
                }
            })
        })
        $('#member-table').on('click', '#delete', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            
            // Tampilkan SweetAlert2 konfirmasi
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: 'pelanggan/delete',
                        data: { PelangganID: id },
                        success: function(data) {
                            get_data();

                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses!',
                                text: 'Data berhasil dihapus.',
                            });
                        }
                    });
                }
            });
        })
    })

</script>

<?= $this->endSection() ?>