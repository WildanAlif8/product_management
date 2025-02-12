<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Manajemen Produk</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
    <style>
        body {
            display: flex;
            flex-direction: column;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background: #343a40;
            padding: 20px;
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            transition: transform 0.3s ease-in-out;
        }
        .sidebar.hidden {
            transform: translateX(-100%);
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
        }
        .sidebar a:hover {
            background: #495057;
            border-radius: 5px;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
            margin-left: 250px;
            transition: margin-left 0.3s;
        }
        .sidebar.hidden + .content {
            margin-left: 0;
        }
        .toggle-btn {
            position: fixed;
            top: 15px;
            left: 15px;
            background: #343a40;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            z-index: 1000;
            border-radius: 5px;
        }
        .toggle-btn i {
            font-size: 1.2rem;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.hidden {
                transform: translateX(0);
            }
            .content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <button class="toggle-btn" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
    
    <!-- Sidebar -->
    <div class="sidebar hidden" id="sidebar">
        <h3><i class="fas fa-tachometer-alt"></i> Dashboard</h3>
        <a href="#"><i class="fas fa-home"></i> Home</a>
        <a href="#"><i class="fas fa-chart-bar"></i> Data Produk</a>
        <a href="#"><i class="fas fa-cogs"></i> Manajemen Produk</a>
    </div>
    
    <!-- Content -->
    <div class="content" id="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
            <div class="container-fluid">
                <span class="navbar-brand"><i class="fas fa-store"></i> Manajemen Produk</span>
            </div>
        </nav>
        
        <h2>Daftar Produk</h2>
        <a href="<?= site_url('product/create') ?>" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Tambah Produk</a>
        
        <table id="productTable" class="table table-bordered display">
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
                        <td><?= $product->name ?></td>
                        <td>Rp<?= number_format($product->price, 0, ',', '.') ?></td>
                        <td><?= $product->stock ?></td>
                        <td>
                            <?php if ($product->is_sell): ?>
                                <span class="badge bg-success">Dijual</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Tidak Dijual</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editProduct(<?= $product->id ?>)"><i class="fas fa-edit"></i> Edit</button>
                            <a href="<?= site_url('product/delete/'.$product->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus produk ini?')"><i class="fas fa-trash"></i> Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Modal Edit Produk -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Edit Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="editProductForm">
                    <!-- Form will be loaded here via AJAX -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Notifikasi Sukses -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Perubahan Tersimpan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Produk telah berhasil disimpan!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#productTable').DataTable({
                "language": {
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ data",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Berikutnya",
                        "previous": "Sebelumnya"
                    }
                }
            });
        });

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('hidden');
        }

        // Function to handle editing product using AJAX
        function editProduct(productId) {
            $.ajax({
                url: '<?= site_url('product/edit/') ?>' + productId, // Assuming edit endpoint
                method: 'GET',
                success: function(response) {
                    $('#editProductForm').html(response); // Load form inside modal
                    $('#editProductModal').modal('show'); // Show modal
                },
                error: function() {
                    alert('Terjadi kesalahan saat memuat data produk.');
                }
            });
        }

        // Function to handle saving the edited product
        function saveProductChanges() {
            const formData = $('#editProductForm').find('form').serialize(); // Collect form data
            $.ajax({
                url: '<?= site_url('product/update/') ?>', // URL to update the product
                method: 'POST',
                data: formData,
                success: function(response) {
                    // Show success modal after successful save
                    $('#editProductModal').modal('hide'); // Hide edit modal
                    $('#successModal').modal('show'); // Show success modal
                    setTimeout(function() {
                        location.reload(); // Reload the page after 2 seconds
                    }, 2000);
                },
                error: function() {
                    alert('Terjadi kesalahan saat menyimpan produk.');
                }
            });
        }

        // Function to confirm delete
        function confirmDelete(productId) {
            $('#confirmDeleteLink').attr('href', '<?= site_url('product/delete/') ?>' + productId);
            $('#confirmDeleteModal').modal('show');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>