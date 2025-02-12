<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Produk</h2>

        <?php if (validation_errors()): ?>
            <div class="alert alert-danger">
                <?= validation_errors() ?>
            </div>
        <?php endif; ?>

        <form id="editProductForm" action="<?= site_url('product/update/'.$product->id) ?>" method="post">
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
                    <option value="Dijual" <?= $product->is_sell == 'Dijual' ? 'selected' : '' ?>>Dijual</option>
                    <option value="Tidak Dijual" <?= $product->is_sell == 'Tidak Dijual' ? 'selected' : '' ?>>Tidak Dijual</option>
                </select>
            </div>

            <button type="button" class="btn btn-success" id="saveButton">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
            <a href="<?= site_url('product') ?>" class="btn btn-secondary">
                <i class="fas fa-times"></i> Batal
            </a>
            <button type="button" class="btn btn-danger float-end" id="deleteButton">
                <i class="fas fa-trash"></i> Hapus Produk
            </button>
        </form>
    </div>

    <!-- Modal Konfirmasi Simpan -->
    <div class="modal fade" id="saveConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Simpan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menyimpan perubahan?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" id="confirmSave">Ya, Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Sukses -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sukses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Perubahan berhasil disimpan!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Error -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Error</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Terjadi kesalahan saat menyimpan perubahan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    $(document).ready(function() {
        const saveConfirmModal = new bootstrap.Modal(document.getElementById('saveConfirmModal'));
        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
        const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));

        // Handle save button click
        $('#saveButton').click(function() {
            saveConfirmModal.show();
        });

        // Handle confirm save
        $('#confirmSave').click(function() {
            const formData = $('#editProductForm').serialize();
            
            $.ajax({
                url: $('#editProductForm').attr('action'),
                method: 'POST',
                data: formData,
                success: function(response) {
                    saveConfirmModal.hide();
                    successModal.show();
                    
                    // Redirect after clicking OK on success modal
                    $('#successModal').on('hidden.bs.modal', function () {
                        window.location.href = '<?= site_url('product') ?>';
                    });
                },
                error: function(xhr, status, error) {
                    saveConfirmModal.hide();
                    errorModal.show();
                }
            });
        });

        // Handle delete button
        $('#deleteButton').click(function() {
            if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
                $.ajax({
                    url: '<?= site_url('product/delete/'.$product->id) ?>',
                    method: 'POST',
                    success: function(response) {
                        alert('Produk berhasil dihapus');
                        window.location.href = '<?= site_url('product') ?>';
                    },
                    error: function(xhr, status, error) {
                        alert('Terjadi kesalahan saat menghapus produk');
                    }
                });
            }
        });
    });
    </script>
</body>
</html>