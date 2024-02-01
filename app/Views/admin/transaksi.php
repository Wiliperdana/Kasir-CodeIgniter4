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

            <div class="row d-flex">
                <input type="text" id="grand-total" value="0" readonly class="form-control col-md-3 ml-3 mr-3" name="total">
                <button class="btn btn-md btn-success px-3 py-1" id="bayar" data-toggle="modal" data-target="#modal-bayar">
                    <i class="fa fa-coins"></i> Bayar
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-bayar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pembayaran</h4>
            </div>
            <div class="modal-body">
                <!-- Isi modal pembayaran disini -->
                <form id="form-pembayaran">
                    <!-- Form pembayaran -->
                    <div class="form-group">
                        <label for="tgl">Tanggal</label>
                        <input type="date" name="tglpenjualan" id="tglpenjualan" class="form-control" value="<?= date('Y-m-d') ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="pelanggan">Pelanggan:</label>
                        <select class="form-control" id="pelanggan" name="pelanggan">
                            <?php foreach($pelanggan as $p) : ?>
                                <option value="<?= $p['PelangganID'] ?>"><?= $p['NamaPelanggan'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="produkTable">Produk yang Dipilih:</label>
                        <table class="table" id="produkTable">
                            <thead>
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="produkTableBody">
                                <!-- Data produk akan ditampilkan di sini -->
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group d-flex">
                        <label for="modal-total-harga">Total Harga:</label>
                        <input type="text" class="form-control col-md-4 ml-4" id="modal-total-harga" name="total" readonly>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="prosesPembayaran">
                    <i class="fa fa-money-check"></i> Proses Pembayaran
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <i class="mdi mdi-close"></i> Batal
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
                    '<td class="col-md-6" name="nama_produk">' + menu + '</td>' +
                    '<td class="col-md-1"><button id="btn-kurang" class="btn btn-sm btn-danger">-</button></td>' +
                    '<td class="col-md-1 qty" name="qty">1</td>' +
                    '<td class="col-md-3 harga" name="harga">' + harga + '</td>' +
                    '<td class="col-md-2 font-weight-bold total" name="subtotal">' + harga + '</td>' +
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
            $('#grand-total').val('Rp ' + grandTotal.toLocaleString());
        }

        // open modal pembayaran
        $('#bayar').on('click', function () {
            hitungGrandTotal(); // Pastikan total harga terbaru
            var grandTotal = $('#grand-total').val();

            // Update nilai total pada modal pembayaran
            $('#modal-total-harga').val(grandTotal.toLocaleString('id-ID'));

            // Ambil data produk dari tabel pembayaran
            var produkData = [];
            $('#order-table tbody tr').each(function () {
                var namaProduk = $(this).find('[name="nama_produk"]').text();
                var qty = $(this).find('[name="qty"]').text();
                var harga = $(this).find('[name="harga"]').text();
                var subtotal = $(this).find('[name="subtotal"]').text();

                produkData.push({
                    namaProduk: namaProduk,
                    qty: qty,
                    harga: harga,
                    subtotal: subtotal
                });
            });

            // Kosongkan tabel produk pada modal
            $('#produkTableBody').empty();

            // Isi tabel produk pada modal dengan data produk
            $.each(produkData, function (index, produk) {
                var newRow = '<tr>' +
                    '<td>' + produk.namaProduk + '</td>' +
                    '<td>' + produk.qty + '</td>' +
                    '<td>' + 'Rp ' + produk.harga.toLocaleString('id-ID') + '</td>' +
                    '<td>' + 'Rp ' + produk.subtotal.toLocaleString('id-ID') + '</td>' +
                    '</tr>';
                $('#produkTableBody').append(newRow);
            });

            // Tampilkan modal pembayaran
            $('#modal-bayar').modal('show');
        });
    })    
</script>

<?= $this->endSection() ?>