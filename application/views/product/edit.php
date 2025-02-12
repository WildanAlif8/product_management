<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Produk</h2>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?= $this->session->flashdata('success') ?>
            </div>
        <?php elseif ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <?= $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('product/update/'.$product->id) ?>" method="post">
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

            <a href="<?= site_url('product/delete/'.$product->id) ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                <i class="fas fa-trash"></i> Hapus Produk
            </a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
