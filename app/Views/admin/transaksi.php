<?=
    $this->extend('layout/template');
    $this->section('content')
?>

<div class="container">
    <div class="row">
        <!-- Tabel Daftar Menu -->
        <div class="col-md-6">
            <h3 class="text-center font-weight-bold">Daftar Menu</h3>

            <?php foreach ($menuProduk as $index => $produk): ?>
              <?php if ($index % 3 == 0): ?>
                  <!-- Baris baru setiap empat menu -->
                  <div class="row">
              <?php endif; ?>
              <div class="col-md-4 mb-3">
                <a href="#" style="text-decoration: none;" class="text-dark">
                  <div class="card bg-white h-100" data-menu="<?= $produk['NamaProduk'] ?>" data-harga="<?= $produk['Harga'] ?>">
                    <div class="card-body d-flex flex-column">
                      <img src="images/<?= $produk['Gambar'] ?>" alt="" class="w-100">
                      <p class="small flex-grow-1"><?= $produk['NamaProduk'] ?></p>
                      <p class="font-weight-bold mb-0 mt-auto">Rp <?= number_format($produk['Harga'], 0, ',', '.') ?></p>
                    </div>
                  </div>
                </a>
              </div>
              <?php if (($index + 1) % 3 == 0 || $index + 1 == count($menuProduk)): ?>
                    <!-- Tutup baris setiap empat menu atau pada menu terakhir -->
                    </div>
                  <?php endif; ?>
              <?php endforeach; ?>
        </div>
        
        <!-- Tabel List Menu (Pembayaran) -->
        <div class="col-md-6">
            <h3 class="text-center font-weight-bold">Pembayaran</h3>
            
            <table id="order-table" class="table table-striped mt-3">
                <thead style="background-color: darkgrey; color:white">
                    <th class="col-md-5">Item</th>
                    <th class="col-md-1"></th>
                    <th class="col-md-1">Qty</th>
                    <th class="col-md-3">Harga</th>
                    <th class="col-md-2">Total</th>
                </thead>

                <tbody class="table-striped" id="order-table-body">
                </tbody>
            </table>
 
            <label>Total Harga : <strong id="grand-total">0</strong></label>
            <a href="" class="btn btn-md btn-success px-3 py-1" id="bayar">
                <i class="fa fa-coins"></i> Bayar
            </a>
        </div>
    </div>
</div>

<div class="modal fade" id="bayar">
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

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function () {
        // Tambahkan menu ke dalam tabel
        $('.card').on('click', function () {
            var menu = $(this).data('menu');
            var harga = $(this).data('harga');
            tambahkanMenu(menu, harga);
        });

        // Fungsi untuk menambahkan menu ke dalam tabel
        function tambahkanMenu(menu, harga) {
            // Cek apakah menu sudah ada di tabel
            var existingRow = $('#order-table tbody tr:contains("' + menu + '")');

            if (existingRow.length > 0) {
                // Jika menu sudah ada, tambahkan qty
                var qtyCell = existingRow.find('.qty');
                var qty = parseInt(qtyCell.text()) + 1;
                qtyCell.text(qty);
            } else {
                // Jika menu belum ada, tambahkan baris baru
                var newRow = '<tr id="1">' +
                    '<td class="col-md-6">' + menu + '</td>' +
                    '<td class="col-md-1"><button id="btn-kurang" class="btn btn-sm btn-danger">-</button></td>' +
                    '<td class="col-md-1 qty">1</td>' +
                    '<td class="col-md-3 harga">' + harga + '</td>' +
                    '<td class="col-md-2 font-weight-bold total">' + harga + '</td>' +
                    '</tr>';
            }

            $('#order-table tbody').append(newRow);

            // Hitung total harga
            hitungTotalHarga();
        }

        // Fungsi untuk menghitung total harga per menu
        function hitungTotalHarga() {
            var total = 0;
            $('#order-table tbody tr').each(function () {
                var harga = parseInt($(this).find('.harga').text());
                var qty = parseInt($(this).find('.qty').text());
                var subtotal = harga * qty;
                total += subtotal;

                // Update nilai total pada kolom total
                $(this).find('.total').text(subtotal.toLocaleString());
            });

            // Update total harga pada elemen dengan ID "total-harga"
            $('#total-harga').text('Rp ' + total.toLocaleString());

            // Hitung dan update grand total
            hitungGrandTotal();
        }

        // Mengurangi Qty
        $('#order-table').on('click', '#btn-kurang', function(e) {
            var jumlah = $(this).closest('tr').find('.qty').html();
            var kurang = jumlah - 1;
            $(this).closest('tr').find('.qty').html(kurang);

            if(jumlah == 1) {
                var row = $(this).closest('tr');
                row.remove();
            }

            hitungTotalHarga();
        })

        // Fungsi untuk menghitung total harga keseluruhan
        function hitungGrandTotal() {
            var grandTotal = 0;
            $('#order-table tbody tr').each(function () {
                var subtotal = parseInt($(this).find('.total').text().replace('Rp ', '').replace(',', ''));
                grandTotal += subtotal;
            });

            // Update grand total pada elemen dengan ID "grand-total"
            $('#grand-total').text('Rp ' + grandTotal.toLocaleString());
        }
    })    
</script>

<?= $this->endSection() ?>