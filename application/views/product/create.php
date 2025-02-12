<!DOCTYPE html>
<html>
<head>
    <title>Tambah Produk</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script>
        function confirmSubmit() {
            return confirm("Apakah Anda yakin ingin menyimpan produk ini?");
        }
    </script>
</head>
<body>
    <div class="container mt-4">
        <h2>Tambah Produk</h2>
        
        <!-- Menampilkan error validasi jika ada -->
        <?php if (validation_errors()): ?>
            <div class="alert alert-danger">
                <?= validation_errors(); ?>
            </div>
        <?php endif; ?>

        <?php echo form_open('product/store', ['onsubmit' => 'return confirmSubmit()']); ?>
        
            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" name="name" class="form-control" value="<?= set_value('name'); ?>" required>
            </div>

            <div class="form-group">
                <label>Harga</label>
                <input type="text" name="price" class="form-control" value="<?= set_value('price'); ?>" required>
            </div>

            <div class="form-group">
                <label>Jumlah Stok</label>
                <input type="number" name="stock" class="form-control" value="<?= set_value('stock'); ?>" required>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="is_sell" class="form-control">
                    <option value="1" <?= set_value('is_sell') == '1' ? 'selected' : ''; ?>>Dijual</option>
                    <option value="0" <?= set_value('is_sell') == '0' ? 'selected' : ''; ?>>Tidak Dijual</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="<?= site_url('product'); ?>" class="btn btn-secondary">Batal</a>

        <?php echo form_close(); ?>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
