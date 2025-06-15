<?php
include '../includes/header.php';

// In a real application, you would fetch product report data from database
$products = [
    [
        'id' => 1,
        'name' => 'Laptop Pro',
        'category' => 'Electronics',
        'price' => 1200,
        'stock' => 45,
        'sold' => 155,
        'revenue' => 186000,
        'last_updated' => '2023-06-15'
    ],
    [
        'id' => 2,
        'name' => 'Smartphone X',
        'category' => 'Electronics',
        'price' => 800,
        'stock' => 32,
        'sold' => 218,
        'revenue' => 174400,
        'last_updated' => '2023-06-14'
    ],
    [
        'id' => 3,
        'name' => 'Wireless Headphones',
        'category' => 'Accessories',
        'price' => 150,
        'stock' => 78,
        'sold' => 342,
        'revenue' => 51300,
        'last_updated' => '2023-06-13'
    ],
    [
        'id' => 4,
        'name' => 'Desk Chair',
        'category' => 'Furniture',
        'price' => 250,
        'stock' => 12,
        'sold' => 48,
        'revenue' => 12000,
        'last_updated' => '2023-06-12'
    ],
    [
        'id' => 5,
        'name' => 'Coffee Maker',
        'category' => 'Home Appliances',
        'price' => 180,
        'stock' => 23,
        'sold' => 97,
        'revenue' => 17460,
        'last_updated' => '2023-06-11'
    ]
];

// Calculate totals
$total_sold = array_sum(array_column($products, 'sold'));
$total_revenue = array_sum(array_column($products, 'revenue'));
$total_stock = array_sum(array_column($products, 'stock'));

// Filter by category if requested
$selected_category = $_GET['category'] ?? 'all';
if ($selected_category !== 'all') {
    $products = array_filter($products, function($product) use ($selected_category) {
        return strtolower($product['category']) === strtolower($selected_category);
    });
}

// Get unique categories for filter dropdown
$categories = array_unique(array_column($products, 'category'));
sort($categories);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Products Report</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="../dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="index.php">Reports</a></li>
                        <li class="breadcrumb-item active">Products Report</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Filters</h3>
                        </div>
                        <div class="card-body">
                            <form method="get" action="">
                                <div class="form-group">
                                    <label>Category</label>
                                    <select class="form-control" name="category" onchange="this.form.submit()">
                                        <option value="all" <?= $selected_category === 'all' ? 'selected' : '' ?>>All Categories</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?= htmlspecialchars(strtolower($category)) ?>" 
                                                <?= strtolower($selected_category) === strtolower($category) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($category) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Summary</h3>
                        </div>
                        <div class="card-body">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><?= number_format($total_sold) ?></h3>
                                    <p>Total Sold</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                            </div>

                            <div class="small-box bg-success mt-3">
                                <div class="inner">
                                    <h3>$<?= number_format($total_revenue, 2) ?></h3>
                                    <p>Total Revenue</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                            </div>

                            <div class="small-box bg-warning mt-3">
                                <div class="inner">
                                    <h3><?= number_format($total_stock) ?></h3>
                                    <p>Total In Stock</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-boxes"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Product Performance</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                                        <i class="fas fa-download"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                                        <a href="#" class="dropdown-item" onclick="exportToPDF()"><i class="fas fa-file-pdf mr-2"></i>Export as PDF</a>
                                        <a href="#" class="dropdown-item" onclick="exportToExcel()"><i class="fas fa-file-excel mr-2"></i>Export as Excel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="productsChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Product Details</h3>
                        </div>
                        <div class="card-body">
                            <table id="productsTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>In Stock</th>
                                        <th>Sold</th>
                                        <th>Revenue</th>
                                        <th>Last Updated</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($products as $product): ?>
                                        <tr>
                                            <td><?= $product['id'] ?></td>
                                            <td><?= htmlspecialchars($product['name']) ?></td>
                                            <td><?= htmlspecialchars($product['category']) ?></td>
                                            <td>$<?= number_format($product['price'], 2) ?></td>
                                            <td><?= $product['stock'] ?></td>
                                            <td><?= $product['sold'] ?></td>
                                            <td>$<?= number_format($product['revenue'], 2) ?></td>
                                            <td><?= $product['last_updated'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="bg-gray">
                                        <th colspan="4">Totals</th>
                                        <th><?= number_format(array_sum(array_column($products, 'stock'))) ?></th>
                                        <th><?= number_format(array_sum(array_column($products, 'sold'))) ?></th>
                                        <th>$<?= number_format(array_sum(array_column($products, 'revenue')), 2) ?></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include '../includes/footer.php'; ?>

<!-- DataTables & ChartJS -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../plugins/chart.js/Chart.min.js"></script>

<script>
$(function () {
    // Initialize DataTable
    $('#productsTable').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "order": [[5, 'desc']] // Sort by Sold column descending by default
    });

    // Products Chart
    var ctx = document.getElementById('productsChart').getContext('2d');
    var productsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_column($products, 'name')) ?>,
            datasets: [
                {
                    label: 'Sold',
                    backgroundColor: 'rgba(60, 141, 188, 0.9)',
                    data: <?= json_encode(array_column($products, 'sold')) ?>
                },
                {
                    label: 'In Stock',
                    backgroundColor: 'rgba(210, 214, 222, 0.9)',
                    data: <?= json_encode(array_column($products, 'stock')) ?>
                }
            ]
        },
        options: {
            responsive: true,
            legend: {
                position: 'top',
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
});

function exportToPDF() {
    alert('PDF export functionality would be implemented here');
    // In a real app, this would generate a PDF report
}

function exportToExcel() {
    alert('Excel export functionality would be implemented here');
    // In a real app, this would generate an Excel report
}
</script>