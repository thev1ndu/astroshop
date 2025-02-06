<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>AstroShop | Dashboard</title>
   

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   <style>
        .stat-card {
            border-left: 4px solid;
            transition: transform 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-card.primary { border-left-color: #0d6efd; }
        .stat-card.success { border-left-color: #198754; }
        .stat-card.warning { border-left-color: #ffc107; }
        .stat-card.info { border-left-color: #0dcaf0; }
        .progress-sm {
            height: 6px;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
        }
    </style>
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="dashboard">

<div class="container-fluid">
    <div class="row">
        <!-- Main Content -->
        <main class="col px-4 py-5">
            <!-- Welcome Banner -->
            <div class="bg-primary text-white p-4 rounded-3 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-0">Welcome back, <?= $fetch_profile['name']; ?>!</h2>
                        <p class="mb-0">Here's what's happening with your store today.</p>
                    </div>
                    <a href="account.php" class="btn btn-light">Update Profile</a>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row g-4 mb-4">
                <!-- Pending Orders -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <?php
                        $total_pendings = 0;
                        $select_pendings = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
                        $select_pendings->execute(['pending']);
                        if($select_pendings->rowCount() > 0){
                            while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
                                $total_pendings += $fetch_pendings['total_price'];
                            }
                        }
                    ?>
                    <div class="card stat-card primary h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2">Pending Orders</h6>
                                    <h3 class="mb-0"><?= number_format($total_pendings); ?>$</h3>
                                </div>
                                <div class="text-primary">
                                    <i class="fas fa-clock fa-2x"></i>
                                </div>
                            </div>
                            <a href="orders.php" class="btn btn-sm btn-primary mt-3">View Details</a>
                        </div>
                    </div>
                </div>

                <!-- Completed Orders -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <?php
                        $total_completes = 0;
                        $select_completes = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
                        $select_completes->execute(['completed']);
                        if($select_completes->rowCount() > 0){
                            while($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)){
                                $total_completes += $fetch_completes['total_price'];
                            }
                        }
                    ?>
                    <div class="card stat-card success h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2">Completed Orders</h6>
                                    <h3 class="mb-0"><?= number_format($total_completes); ?>$</h3>
                                </div>
                                <div class="text-success">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                            </div>
                            <a href="orders.php" class="btn btn-sm btn-success mt-3">View Details</a>
                        </div>
                    </div>
                </div>

                <!-- Total Products -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <?php
                        $select_products = $conn->prepare("SELECT * FROM `products`");
                        $select_products->execute();
                        $number_of_products = $select_products->rowCount()
                    ?>
                    <div class="card stat-card warning h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2">Total Products</h6>
                                    <h3 class="mb-0"><?= number_format($number_of_products); ?></h3>
                                </div>
                                <div class="text-warning">
                                    <i class="fas fa-box fa-2x"></i>
                                </div>
                            </div>
                            <a href="products.php" class="btn btn-sm btn-warning mt-3">Manage Products</a>
                        </div>
                    </div>
                </div>

                <!-- Total Users -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <?php
                        $select_users = $conn->prepare("SELECT * FROM `users`");
                        $select_users->execute();
                        $number_of_users = $select_users->rowCount()
                    ?>
                    <div class="card stat-card info h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2">Total Users</h6>
                                    <h3 class="mb-0"><?= number_format($number_of_users); ?></h3>
                                </div>
                                <div class="text-info">
                                    <i class="fas fa-users fa-2x"></i>
                                </div>
                            </div>
                            <a href="users.php" class="btn btn-sm btn-info mt-3">View Users</a>
                        </div>
                    </div>
                </div>
            </div>

</section>












<script src="../js/admin_script.js"></script>
   
</body>
</html>