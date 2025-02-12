<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Manajemen Produk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
    <style>
        body {
            background: #f4f6f9;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: #343a40;
            /* Warna abu-abu gelap untuk sidebar */
            color: white;
            height: 100vh;
            position: fixed;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 20px;
            background: #23272b;
            /* Warna hitam sedikit lebih terang untuk header */
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
            background: #495057;
            /* Warna abu-abu lebih terang saat hover */
            padding-left: 25px;
        }

        .sidebar-menu a.active {
            background: #212529;
            /* Warna hitam sangat gelap untuk item aktif */
            color: #ffcc00;
            /* Warna kuning untuk teks aktif */
        }

        /* Navbar */
        .navbar {
            padding: 15px 20px;
            background: #ffffff;
            border-bottom: 2px solid #dee2e6;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
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

        /* Navbar */
        .navbar {
            padding: 15px 20px;
            background: #ffffff;
            border-bottom: 2px solid #dee2e6;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Card styling */
        .card {
            display: flex;
            align-items: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            cursor: pointer;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
        }

        .card i {
            font-size: 3rem;
            margin-right: 15px;
            /* Jarak antara ikon dan teks */
            transition: transform 0.3s ease;
        }

        .card:hover i {
            transform: scale(1.2);
        }

        .toggle-btn {
            background: transparent;
            border: none;
            font-size: 1.5rem;
            color: #343a40;
            cursor: pointer;
            display: none;
        }

        /* Responsive Sidebar */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -250px;
                transition: all 0.3s ease;
                z-index: 999;
            }

            .sidebar.active {
                left: 0;
            }

            .content {
                margin-left: 0;
            }

            .toggle-btn {
                display: flex;
                position: absolute;
                top: 10px;
                left: 10px;
                z-index: 1001;
            }
        }

        /* Enhancing the card text */
        .card .card-body {
            flex-grow: 1;
        }

        .card .card-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .card .card-text {
            font-size: 1rem;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-header"><i class="fas fa-tachometer-alt" style="margin-right: 14px;"></i>Dashboard</div>
            <ul class="sidebar-menu">
                <li><a href="home"><i class="fas fa-home"></i>&nbsp; Home</a></li>
                <li><a href="product"><i class="fas fa-box"></i>&nbsp; Data Produk</a></li>
            </ul>
        </nav>

        <div class="content">
            <button class="toggle-btn" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>

            <nav class="navbar">
                <div class="container-fluid">
                    <span class="navbar-brand">
                        <i class="fas fa-store"></i> &nbsp; Manajemen Produk
                    </span>
                </div>
            </nav>

            <!-- Quick Stats Cards -->
            <div class="container mt-4">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-white bg-primary">
                            <div class="card-body d-flex">
                                <i class="fas fa-box" style="margin-right: 10px; margin-top: 5px;"></i>
                                <div>
                                    <h5 class="card-title">Total Produk</h5>
                                    <p class="card-text"><?= $product_stats['dijual'] + $product_stats['tidak_dijual']; ?> Produk</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-success">
                            <div class="card-body d-flex">
                                <i class="fas fa-shopping-cart" style="margin-right: 10px; margin-top: 5px;"></i>
                                <div>
                                    <h5 class="card-title">Produk Dijual</h5>
                                    <p class="card-text"><?= $product_stats['dijual']; ?> Produk Dijual</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-danger">
                            <div class="card-body d-flex">
                                <i class="fas fa-ban" style="margin-right: 10px; margin-top: 5px;"></i>
                                <div>
                                    <h5 class="card-title">Produk Tidak Dijual</h5>
                                    <p class="card-text"><?= $product_stats['tidak_dijual']; ?> Produk Tidak Dijual</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="container mt-4">
                <h3>Grafik Status Produk</h3>
                <canvas id="productChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });

        var productStats = <?= json_encode($product_stats); ?>;

        const ctx = document.getElementById('productChart').getContext('2d');

        let productChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Dijual', 'Tidak Dijual'],
                datasets: [{
                    label: 'Jumlah Produk',
                    data: [productStats.dijual, productStats.tidak_dijual],
                    backgroundColor: ['#28a745', '#dc3545'],
                    borderColor: ['#28a745', '#dc3545'],
                    borderWidth: 1,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.raw + ' Produk';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                onClick: (event, elements) => {
                    if (elements.length > 0) {
                        let index = elements[0].index;

                        // Sembunyikan atau tampilkan bar yang diklik
                        if (index === 0) { // Dijual
                            productChart.data.datasets[0].data[1] = productStats.tidak_dijual; // Tampilkan 'Tidak Dijual'
                            productChart.data.datasets[0].data[0] = 0; // Sembunyikan 'Dijual'
                        } else if (index === 1) { // Tidak Dijual
                            productChart.data.datasets[0].data[0] = productStats.dijual; // Tampilkan 'Dijual'
                            productChart.data.datasets[0].data[1] = 0; // Sembunyikan 'Tidak Dijual'
                        }

                        // Update chart
                        productChart.update();
                    }
                }

            }
        });
    </script>
</body>

</html>