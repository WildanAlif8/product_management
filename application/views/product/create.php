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
        <?php echo validation_errors(); ?>
        <?php echo form_open('product/store', ['onsubmit' => 'return confirmSubmit()']); ?>
            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Harga</label>
                <input type="text" name="price" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Jumlah Stok</label>
                <input type="number" name="stock" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="is_sell" class="form-control">
                    <option value="1">Dijual</option>
                    <option value="0">Tidak Dijual</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="<?php echo site_url('product'); ?>" class="btn btn-secondary">Batal</a>
        <?php echo form_close(); ?>
    </div>
</body>
</html>
