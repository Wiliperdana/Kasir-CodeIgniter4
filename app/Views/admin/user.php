<?=
    $this->extend('layout/template');
    $this->section('content')
?>

<div class="main-panel">
    <div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Daftar User </h3>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
            <a href="" class="card-title btn btn-primary btn-icon-text" data-toggle="modal" data-target="#store">
                <i class="mdi mdi-plus btn-icon-prepend"> Tambah User</i>
            </a>
            <div class="table-responsive">
                <table class="table">
                <thead>
                    <tr class="text-center">
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Role</th>
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
                    <form class="forms-sample" id="store_data">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" name="nama" placeholder="Nama" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="toggle-password">
                                        <i class="fa fa-eye-slash"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" class="form-control">
                                <option value="admin">Administrator</option>
                                <option value="kasir" selected>Kasir</option>
                            </select>
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
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" name="nama" placeholder="Nama" id="nama" required>
                            <input type="hidden" name="id_user" id="id_user">
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" placeholder="Username" id="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password" id="password" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="toggle-password-update">
                                        <i class="fa fa-eye-slash"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="form-control">
                                <option value="admin">Administrator</option>
                                <option value="kasir">Kasir</option>
                            </select>
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
        url: 'user/getdata',
        type: 'GET',
        dataType: 'json',
        success: function(data) {

            var html = "";
            var a;

            for(a = 0; a < data.length; a++) {
                var role = data[a].role == 'admin' ? 'badge-primary px-3 py-2' : 'badge-success px-3 py-2';

                html += '<tr class="text-center">' +
                            '<td>' + (a + 1) + '</td>' +
                            '<td>' + data[a].nama + '</td>' +
                            '<td>' + data[a].username + '</td>' +
                            '<td><span class="badge ' + role + '">' + data[a].role + '</span></td>' +
                            '<td>' +
                                '<button id="edit" class="btn btn-warning btn-icon-text" data-id="' + data[a].id_user + '">' +
                                    '<i class="mdi mdi-content-save-edit btn-icon-prepend"> Update</i>' +
                                '</button>' +
                                '<button id="delete" class="btn btn-danger btn-icon-text ml-1" data-id="' + data[a].id_user + '">' +
                                    '<i class="mdi mdi-delete-empty btn-icon-prepend"> Delete</i>' +
                                '</button>' +
                            '</td>' +
                        '</tr>';
            }

                $("#product-table").html(html);
            }
            });
        };

        $('#btn-store').on('click', function(e) {
            e.preventDefault();

            var nama = $('[name="nama"]').val().trim();
            var username = $('[name="username"]').val().trim();
            var password = $('[name="password"]').val().trim();
            var role = $('[name="role"]').val().trim();
            

            if (nama === '' || username === '' || password === '' || role === '') {
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
                url: 'user/store',
                data: $('#store_data').serialize(),
                success: function(data) {
                    $('#store').modal('hide');
                    $('[name="id_user"]').val('');
                    $('[name="nama"]').val('');
                    $('[name="username"]').val('');
                    $('[name="password"]').val('');
                    $('[name="role"]').val('');

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

        $('#product-table').on('click', '#edit', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                type : 'GET',
                url : 'user/edit',
                data : {id_user : id},
                dataType : 'json',
                success : function(data){
                    $('#update').modal('show');
                    $('#id_user').val(data.id_user);
                    $('#nama').val(data.nama);
                    $('#username').val(data.username);
                    $('#password').val(data.password);
                    $('#role').val(data.role);
                }
            })
        })

        $('#btn-update').on('click', function(e) {
            e.preventDefault();
            var id = $('#id_user').val();
            var nama = $('#nama').val();
            var username = $('#username').val();
            var password = $('#password').val();
            var role = $('#role').val();

            $.ajax({
                type : 'POST',
                url : 'user/update',
                data : {id_user : id, nama : nama, username : username, password : password, role : role},
                success : function(data){
                    $('#update').modal('hide');
                    $('#id_user').val('');
                    $('#nama').val('');
                    $('#username').val('');
                    $('#password').val('');
                    $('#role').val('');

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
                        url: 'user/delete',
                        data: { id_user: id },
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
        $('#toggle-password').on('click', function () {
            var passwordField = $('[name = password]');
            var passwordFieldType = passwordField.attr('type');
            
            if (passwordFieldType === 'password') {
                passwordField.attr('type', 'text');
                $(this).html('<i class="fa fa-eye"></i>');
            } else {
                passwordField.attr('type', 'password');
                $(this).html('<i class="fa fa-eye-slash"></i>');
            }
        });

        $('#toggle-password-update').on('click', function () {
            var passwordField = $('#password');
            var passwordFieldType = passwordField.attr('type');
            
            if (passwordFieldType === 'password') {
                passwordField.attr('type', 'text');
                $(this).html('<i class="fa fa-eye"></i>');
            } else {
                passwordField.attr('type', 'password');
                $(this).html('<i class="fa fa-eye-slash"></i>');
            }
        });
    })

</script>

<?= $this->endSection() ?>