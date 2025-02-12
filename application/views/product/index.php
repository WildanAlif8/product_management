<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
    .sidebar {
        width: 250px;
        height: 100vh;
        background-color: #343a40;
        position: fixed;
        top: 0;
        left: 0;
        padding-top: 20px;
        color: #fff;
    }
    .sidebar-header {
        padding: 10px;
        text-align: center;
        font-size: 1.5rem;
        border-bottom: 1px solid #ccc;
    }
    .sidebar-menu {
        list-style-type: none;
        padding: 0;
    }
    .sidebar-menu li {
        padding: 10px 20px;
    }
    .sidebar-menu li a {
        color: #fff;
        text-decoration: none;
        display: block;
    }
    .sidebar-menu li a:hover {
        background-color: #495057;
    }
    .container {
        margin-left: 270px; /* Space for sidebar */
    }
</style>

di bales kie doang ku gpt
</head>
<body>
    <nav class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-tachometer-alt"></i> Dashboard</h3>
            </div>
            <ul class="sidebar-menu">
                <li><a href="home"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="product"><i class="fas fa-chart-bar"></i> Data Produk</a></li>
            </ul>
        </nav>

<div class="container">
    <h2 class="mb-4">Manajemen Produk</h2>

    <!-- Flash Message -->
    <?php if ($this->session->flashdata('message')): ?>
        <script>
            Swal.fire({
                icon: "<?= $this->session->flashdata('message')['type'] ?>",
                title: "<?= $this->session->flashdata('message')['text'] ?>",
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    <?php endif; ?>

    <!-- Tombol Tambah Produk -->
    <button class="btn btn-primary mb-3" onclick="showAddProductModal()">
        <i class="fas fa-plus"></i> Tambah Produk
    </button>

    <!-- Tabel Produk -->
    <table id="productTable" class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= htmlspecialchars($product->name) ?></td>
                    <td>Rp<?= number_format($product->price, 0, ',', '.') ?></td>
                    <td><?= htmlspecialchars($product->stock) ?></td>
                    <td>
                        <?= $product->is_sell ? '<span class="badge bg-success">Dijual</span>' : '<span class="badge bg-danger">Tidak Dijual</span>'; ?>
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm btn-action" onclick="editProduct(<?= $product->id ?>)">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-danger btn-sm btn-action" onclick="confirmDelete(<?= $product->id ?>)">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah Produk -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Tambah Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('product/store') ?>" method="POST">
                    <div class="mb-3">
                        <label for="productName" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="productName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="productPrice" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="productPrice" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="productStock" class="form-label">Jumlah Stok</label>
                        <input type="number" class="form-control" id="productStock" name="stock" required>
                    </div>
                    <div class="mb-3">
                        <label for="productStatus" class="form-label">Status</label>
                        <select class="form-control" id="productStatus" name="is_sell">
                            <option value="1">Dijual</option>
                            <option value="0">Tidak Dijual</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Produk</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Inisialisasi DataTables
    $(document).ready(function() {
        $('#productTable').DataTable({
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan MENU data",
                "info": "Menampilkan START sampai END dari TOTAL data",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Berikutnya",
                    "previous": "Sebelumnya"
                }
            }
        });
    });

    // Tampilkan Modal Tambah Produk
    function showAddProductModal() {
        $('#addProductModal').modal('show');
    }

    // Fungsi Edit Produk dengan AJAX
    function editProduct(productId) {
        $.ajax({
            url: '<?= site_url('product/edit/') ?>' + productId, 
            method: 'GET',
            success: function(response) {
                $('#editProductForm').html(response); 
                $('#editProductModal').modal('show'); 
            },
            error: function() {
                alert('Terjadi kesalahan saat memuat data produk.');
            }
        });
    }

    // Konfirmasi Hapus Produk
    function confirmDelete(productId) {
        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Data produk ini akan dihapus!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= site_url('product/delete/') ?>' + productId;
            }
        });
    }
</script>

</body>
</html>