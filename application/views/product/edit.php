<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Produk</h2>

        <?php if ($this->session->flashdata('success')): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '<?= $this->session->flashdata('success') ?>',
                    showConfirmButton: false,
                    timer: 2000
                });
            });
        </script>
        <?php elseif ($this->session->flashdata('error')): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '<?= $this->session->flashdata('error') ?>',
                    showConfirmButton: false,
                    timer: 2000
                });
            });
        </script>
        <?php endif; ?>

        <form action="<?= site_url('product/update/'.$product->id) ?>" method="post" id="editForm">
            <div class="mb-3">
                <label for="name" class="form-label">Nama Produk</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $product->name ?>" required>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Harga</label>
                <input type="number" class="form-control" id="price" name="price" value="<?= $product->price ?>" required>
            </div>

            <div class="mb-3">
                <label for="stock" class="form-label">Stok</label>
                <input type="number" class="form-control" id="stock" name="stock" value="<?= $product->stock ?>" required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status Produk</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="Dijual" <?= $product->is_sell == 1 ? 'selected' : '' ?>>Dijual</option>
                    <option value="Tidak Dijual" <?= $product->is_sell == 0 ? 'selected' : '' ?>>Tidak Dijual</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
            <a href="<?= site_url('product') ?>" class="btn btn-secondary">
                <i class="fas fa-times"></i> Batal
            </a>
            <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                <i class="fas fa-trash"></i> Hapus Produk
            </button>
        </form>
    </div>

    <script>
        // Konfirmasi dan submit form dengan AJAX
        document.getElementById('editForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;

            Swal.fire({
                title: 'Konfirmasi',
                text: "Apakah Anda yakin ingin menyimpan perubahan?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Menggunakan AJAX untuk submit form
                    $.ajax({
                        url: form.action,
                        method: 'POST',
                        data: $(form).serialize(),
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Perubahan berhasil disimpan',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                // Redirect ke halaman produk
                                window.location.href = '<?= site_url('product') ?>';
                            });
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Terjadi kesalahan saat menyimpan perubahan',
                                showConfirmButton: true
                            });
                        }
                    });
                }
            });
        });

        // Konfirmasi hapus produk
        function confirmDelete() {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Produk yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?= site_url('product/delete/'.$product->id) ?>';
                }
            });
        }
    </script>
</body>
</html>