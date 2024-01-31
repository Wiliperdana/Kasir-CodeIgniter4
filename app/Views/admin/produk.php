<?=
    $this->extend('layout/template');
    $this->section('content')
?>

<div class="main-panel">
    <div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Daftar Produk </h3>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
            <a href="" class="card-title btn btn-primary btn-icon-text" data-toggle="modal" data-target="#store">
                <i class="mdi mdi-plus btn-icon-prepend"> Tambah Produk</i>
            </a>
            <br>
            <label class="mr-4"><strong  class="badge badge-success px-2 py-2">Stok Aman</strong> = Lebih Dari 24 pcs </label>
            <label class="mr-4"><strong  class="badge badge-warning px-2 py-2">Mulai Menipis</strong> = Lebih Dari 12 pcs </label>
            <label class="mr-4"><strong  class="badge badge-danger px-2 py-2">Hampir Habis</strong> = Kurang Dari 12 pcs </label>
            <div class="table-responsive">
                <table class="table">
                <thead>
                    <tr class="text-center">
                        <th>No.</th>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Harga (pcs)</th>
                        <th>Stok</th>
                        <th>Update/Delete</th>
                    </tr>
                </thead>
                <tbody id="product-table">
                    
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
                    <form class="forms-sample" id="store_data" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="NamaProduk">Nama Produk</label>
                            <input type="text" class="form-control" name="NamaProduk" placeholder="Nama Produk" required>
                        </div>
                        <div class="form-group">
                            <label for="Harga">Harga</label>
                            <input type="text" class="form-control" name="Harga" placeholder="Harga" required>
                        </div>
                        <div class="form-group">
                            <label for="Stok">Stok</label>
                            <input type="text" class="form-control" name="Stok" placeholder="Stok" required>
                        </div>
                        <div class="form-group">
                            <label for="Gambar">Gambar</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="Gambar" id="Gambar">
                                <label class="custom-file-label" for="Gambar">Choose file</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary me-2" id="btn-store">Submit</button>
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
                            <label for="NamaProduk">Nama Produk</label>
                            <input type="text" class="form-control" name="NamaProduk" placeholder="Nama Produk" required id="NamaProduk">
                            <input type="hidden" name="ProdukID" id="ProdukID">
                        </div>
                        <div class="form-group">
                            <label for="Harga">Harga</label>
                            <input type="text" class="form-control" name="Harga" placeholder="Harga" required id="Harga">
                        </div>
                        <div class="form-group">
                            <label for="Stok">Stok</label>
                            <input type="text" class="form-control" name="Stok" placeholder="Stok" required id="Stok">
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
        url: 'produk/getdata',
        type: 'GET',
        dataType: 'json',
        success: function(data) {

            var html = "";
            var a;

            for(a = 0; a < data.length; a++) {
                var badgeStok = data[a].Stok > 24 ? 'badge-success px-3 py-2' : (data[a].Stok > 12 ? 'badge-warning px-3 py-2' : 'badge-danger px-3 py-2');
                var formattedHarga = number_format(data[a].Harga,2,',','.');

                html += '<tr class="text-center">' +
                            '<td class="col-md-1">' + (a + 1) + '</td>' +
                            '<td class="col-md-2"><img src="<?= base_url() . 'images/' ?>' + data[a].Gambar + '" class="img-thumbnail" style="width: 100px; height: 100px;"></td>' +
                            '<td class="col-md-3">' + data[a].NamaProduk + '</td>' +
                            '<td class="col-md-2">Rp ' + formattedHarga + '</td>' +
                            '<td class="col-md-1"><span class="badge ' + badgeStok + '">' + data[a].Stok + ' Pcs</span></td>' +
                            '<td class="col-md-3">' +
                                '<button id="edit" class="btn btn-warning btn-icon-text" data-id="' + data[a].ProdukID + '">' +
                                    '<i class="mdi mdi-content-save-edit btn-icon-prepend"> Update</i>' +
                                '</button>' +
                                '<button id="delete" class="btn btn-danger btn-icon-text ml-1" data-id="' + data[a].ProdukID + '">' +
                                    '<i class="mdi mdi-delete-empty btn-icon-prepend"> Delete</i>' +
                                '</button>' +
                            '</td>' +
                        '</tr>';
            }

                $("#product-table").html(html);
            }
            });
        };

        // Tambah Produk
        $('#btn-store').on('click', function(e) {
            e.preventDefault();

            var namaProduk = $('[name="NamaProduk"]').val().trim();
            var harga = $('[name="Harga"]').val().trim();
            var stok = $('[name="Stok"]').val().trim();
            var gambar = $('#Gambar')[0].files[0];

            if (namaProduk === '' || harga === '' || stok === '') {
                // Notifikasi Required
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Semua kolom harus diisi.',
                });
                return;
            }

            var formData = new FormData($('#store_data')[0]);
            formData.append('Gambar', gambar);

            $.ajax({
                type: 'POST',
                url: 'produk/store',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    $('#store').modal('hide');
                    $('[name="ProdukID"]').val('');
                    $('[name="NamaProduk"]').val('');
                    $('[name="Harga"]').val('');
                    $('[name="Stok"]').val('');
                    // $('[name="Gambar"]').val('');

                    get_data();

                    // Notifikasi Sukses
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Data berhasil disimpan.',
                    });
                }
            });
        });

        // Edit produk
        $('#product-table').on('click', '#edit', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                type : 'GET',
                url : 'produk/edit',
                data : {ProdukID : id},
                dataType : 'json',
                success : function(data){
                    // console.log(data);
                    $('#update').modal('show');
                    $('#ProdukID').val(data.ProdukID);
                    $('#NamaProduk').val(data.NamaProduk);
                    $('#Harga').val(data.Harga);
                    $('#Stok').val(data.Stok);
                }
            })
        })

        // Update produk
        $('#btn-update').on('click', function(e) {
            e.preventDefault();
            var id = $('#ProdukID').val();
            var namaProduk = $('#NamaProduk').val();
            var harga = $('#Harga').val();
            var stok = $('#Stok').val();

            $.ajax({
                type : 'POST',
                url : 'produk/update',
                data : {ProdukID : id, NamaProduk : namaProduk, Harga : harga, Stok : stok},
                success : function(data){
                    $('#update').modal('hide');
                    $('#ProdukID').val('');
                    $('#NamaProduk').val('');
                    $('#Harga').val('');
                    $('#Stok').val('');

                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Data berhasil diupdate.',
                    });

                    get_data();
                }
            })
        })
        $('#product-table').on('click', '#delete', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            
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
                        url: 'produk/delete',
                        data: { ProdukID: id },
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