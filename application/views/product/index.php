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
            min-height: 100vh;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

/* Sidebar */
.sidebar {
    width: 250px;
    background: #343a40; /* Warna abu-abu gelap untuk sidebar */
    color: white;
    height: 100vh;
    position: fixed;
    transition: all 0.3s ease;
}

.sidebar-header {
    padding: 20px;
    background: #23272b; /* Warna hitam sedikit lebih terang untuk header */
    text-align: center;
    font-size: 1.5rem;
    font-weight: bold;
}

.sidebar-menu {
    list-style: none;
    padding: 0;
}

.sidebar-menu a {
    color: white;
    text-decoration: none;
    padding: 15px 20px;
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
    font-size: 1.1rem;
}

.sidebar-menu a:hover {
    background: #495057; /* Warna abu-abu lebih terang saat hover */
    padding-left: 25px;
}

.sidebar-menu a.active {
    background: #212529; /* Warna hitam sangat gelap untuk item aktif */
    color: #ffcc00; /* Warna kuning untuk teks aktif */
}

/* Navbar */
.navbar {
    padding: 15px 20px;
    background: #ffffff;
    border-bottom: 2px solid #dee2e6;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
}



        .content {
            flex: 1;
            padding: 20px;
            margin-left: 250px;
            transition: all 0.3s ease;
        }

        .navbar {
            padding: 15px 20px;
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.25rem;
            font-weight: 500;
            color: #333;
            padding: 0;
        }

        .navbar-brand i {
            font-size: 1.4rem;
            color: #333;
        }

        .toggle-btn {
            background: transparent;
            border: none;
            font-size: 1.5rem;
            color: #343a40;
            cursor: pointer;
            display: none;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                left: -250px;
                position: fixed;
                height: 100vh;
            }

            .sidebar.active {
                left: 0;
            }

            .toggle-btn {
                width: 40px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
                position: fixed;
                top: 12px;
                left: 10px;
                z-index: 1001;
            }

            .toggle-btn:focus {
                outline: none;
            }

            .toggle-btn i {
                font-size: 1.5rem;
            }

            .content {
                margin-left: 0;
                width: 100%;
                padding-top: 60px;
            }

            .navbar {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                z-index: 999;
                padding: 15px;
                background: #f8f9fa;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }

            .navbar-brand {
                margin-left: 45px;
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
            }

            .sidebar-overlay.active {
                display: block;
            }

            /* Handle DataTables responsiveness */
            .dataTables_wrapper {
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-tachometer-alt"></i> Dashboard</h3>
            </div>
            <ul class="sidebar-menu">
                <li><a href="home"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="product"><i class="fas fa-chart-bar"></i> Data Produk</a></li>
            </ul>
        </nav>

        <!-- Overlay for mobile -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Page Content -->
        <div class="content">
            <button class="toggle-btn" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>

            <nav class="navbar">
                <div class="container-fluid">
                    <span class="navbar-brand">
                        <i class="fas fa-store"></i>
                        <span>Manajemen Produk</span>
                    </span>
                </div>
            </nav>

            <h2>Daftar Produk</h2>
            <button class="btn btn-primary mb-3" onclick="showAddProductModal()">
                <i class="fas fa-plus"></i> Tambah Produk
            </button>
            
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
                                <button class="btn btn-warning btn-sm" onclick="editProduct(<?= $product->id ?>)">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <a href="#" class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $product->id ?>)">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Edit Produk -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
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

    <!-- Modal Add Produk -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
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
        // DataTables Initialization
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
                },
                responsive: true
            });
        });

        // Sidebar Toggle
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('sidebarOverlay').classList.toggle('active');
        });

        document.getElementById('sidebarOverlay').addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('active');
            document.getElementById('sidebarOverlay').classList.remove('active');
        });

        // Show Add Product Modal
        function showAddProductModal() {
            $('#addProductModal').modal('show');
        }

        // Edit Product with AJAX
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

        // Confirm Delete Product
        function confirmDelete(productId) {
            if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
                window.location.href = '<?= site_url('product/delete/') ?>' + productId;
            }
        }

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                document.getElementById('sidebar').classList.remove('active');
                document.getElementById('sidebarOverlay').classList.remove('active');
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>