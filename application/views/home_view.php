<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Manajemen Produk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background: #343a40;
            color: white;
            height: 100vh;
            position: fixed;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 20px;
            background: #2c3136;
            text-align: center;
        }

        .sidebar-header h3 {
            margin: 0;
            font-size: 1.5rem;
        }

        .sidebar-menu {
            padding: 0;
            list-style: none;
        }

        .sidebar-menu a {
            color: white;
            text-decoration: none;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .sidebar-menu a:hover {
            background: #495057;
            padding-left: 25px;
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
        }

        /* Card Styles */
        .card {
            margin-bottom: 20px;
        }

        /* Mobile Sidebar */
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
                position: fixed;
                top: 0;
                left: -250px;
                transition: all 0.3s ease;
                z-index: 999;
            }

            .sidebar.active {
                left: 0;
            }

            .content {
                margin-left: 0;
                padding-top: 60px;
            }

            .toggle-btn {
                display: flex;
                position: absolute;
                top: 10px;
                left: 10px;
                z-index: 1001;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-header">
            <h3><i class="fas fa-tachometer-alt"></i> Dashboard</h3>
            </div>
            <ul class="sidebar-menu">
                <li><a href="home"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="product"><i class="fas fa-chart-bar"></i> Data Produk</a></li>
            </ul>
        </nav>

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

            <!-- Welcome Message -->
            <div class="container mt-5">
                <h1>Selamat datang di halaman Home!</h1>
                <p>Ini adalah halaman utama dari aplikasi manajemen produk. Berikut adalah beberapa statistik cepat dan grafik untuk memudahkan pengelolaan data produk.</p>
            </div>

            <!-- Quick Stats and Cards -->
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-white bg-primary">
                            <div class="card-body">
                                <h5 class="card-title">Total Produk</h5>
                                <p class="card-text">102 Produk Tersedia</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-success">
                            <div class="card-body">
                                <h5 class="card-title">Produk Dijual</h5>
                                <p class="card-text">75 Produk Terjual</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-danger">
                            <div class="card-body">
                                <h5 class="card-title">Produk Tidak Dijual</h5>
                                <p class="card-text">27 Produk Tidak Dijual</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart for Product Stats -->
            <div class="container mt-4">
                <h3>Grafik Penjualan Produk</h3>
                <canvas id="productChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
    <script>
        // Sidebar toggle functionality
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });

        // Chart.js for the product stats
        const ctx = document.getElementById('productChart').getContext('2d');
        const productChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Produk Dijual', 'Produk Tidak Dijual'],
                datasets: [{
                    label: 'Jumlah Produk',
                    data: [75, 27],
                    backgroundColor: ['#28a745', '#dc3545'],
                    borderColor: ['#28a745', '#dc3545'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
