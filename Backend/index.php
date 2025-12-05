<?php
session_start();
include "connection.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// ── LIVE DATA FROM speczo_db ─────────────────────────────────────

$total_products  = $conn->query("SELECT COUNT(*) as c FROM product_tbl WHERE p_status='1'")->fetch_assoc()['c'];
$total_users     = $conn->query("SELECT COUNT(*) as c FROM user_tbl WHERE u_status='1'")->fetch_assoc()['c'];
$total_inquiries = $conn->query("SELECT COUNT(*) as c FROM inquiries_tbl")->fetch_assoc()['c'];
$total_reviews   = $conn->query("SELECT COUNT(*) as c FROM review_tbl")->fetch_assoc()['c'];

$order_row     = $conn->query("SELECT COUNT(*) as cnt, COALESCE(SUM(total_amount),0) as rev FROM order_tbl")->fetch_assoc();
$total_orders  = $order_row['cnt'];
$total_revenue = $order_row['rev'];

$avg_rating    = $conn->query("SELECT ROUND(AVG(rating),1) as a FROM review_tbl")->fetch_assoc()['a'] ?? 0;
$good_reviews  = $conn->query("SELECT COUNT(*) as c FROM review_tbl WHERE rating >= 4")->fetch_assoc()['c'];
$satisfaction  = $total_reviews > 0 ? round(($good_reviews / $total_reviews) * 100, 1) : 0;

// Products by Category (donut)
$cat_res = $conn->query("SELECT c.c_name, COUNT(p.product_id) as cnt FROM category_tbl c LEFT JOIN product_tbl p ON p.category_id=c.category_id AND p.p_status='1' GROUP BY c.category_id");
$cat_labels = []; $cat_data = [];
while ($r = $cat_res->fetch_assoc()) { $cat_labels[] = $r['c_name']; $cat_data[] = (int)$r['cnt']; }

// Products by Shape (bar)
$shape_res = $conn->query("SELECT sh.s_name, COUNT(p.product_id) as cnt FROM shape_tbl sh LEFT JOIN product_tbl p ON p.shape_id=sh.shape_id AND p.p_status='1' GROUP BY sh.shape_id ORDER BY cnt DESC LIMIT 8");
$shape_labels = []; $shape_data = [];
while ($r = $shape_res->fetch_assoc()) { $shape_labels[] = $r['s_name']; $shape_data[] = (int)$r['cnt']; }

// Products by Gender
$gender_res = $conn->query("SELECT gender, COUNT(*) as cnt FROM product_tbl WHERE p_status='1' GROUP BY gender");
$gender_labels = []; $gender_data = [];
while ($r = $gender_res->fetch_assoc()) { $gender_labels[] = $r['gender']; $gender_data[] = (int)$r['cnt']; }

// Order status
$os_res = $conn->query("SELECT o_status, COUNT(*) as cnt FROM order_tbl GROUP BY o_status");
$os = ['Pending'=>0,'Shipped'=>0,'Delivered'=>0,'Cancelled'=>0];
while ($r = $os_res->fetch_assoc()) $os[$r['o_status']] = (int)$r['cnt'];

// Monthly inquiries
$inq_res = $conn->query("SELECT DATE_FORMAT(created_at,'%b') as mo, COUNT(*) as cnt FROM inquiries_tbl WHERE created_at >= DATE_SUB(NOW(),INTERVAL 6 MONTH) GROUP BY DATE_FORMAT(created_at,'%Y-%m') ORDER BY MIN(created_at)");
$inq_months = []; $inq_counts = [];
while ($r = $inq_res->fetch_assoc()) { $inq_months[] = $r['mo']; $inq_counts[] = (int)$r['cnt']; }

// Price stats
$price = $conn->query("SELECT MIN(price) as mn, MAX(price) as mx, AVG(price) as av FROM product_variation_tbl WHERE v_status='1'")->fetch_assoc();

// Per-category counts
$cat_counts = [];
$cc = $conn->query("SELECT c.c_name, COUNT(p.product_id) as cnt FROM category_tbl c LEFT JOIN product_tbl p ON p.category_id=c.category_id AND p.p_status='1' GROUP BY c.category_id");
while ($r = $cc->fetch_assoc()) $cat_counts[$r['c_name']] = (int)$r['cnt'];
$sunglasses_cnt = $cat_counts['Sunglasses'] ?? 0;
$eyeglasses_cnt = $cat_counts['Eyeglasses'] ?? 0;
$screen_cnt     = $cat_counts['Zero Power Screen Glasses'] ?? 0;
$clipon_cnt     = $cat_counts['Clip - on'] ?? 0;

// Recent orders
$recent_orders = $conn->query("SELECT o.order_id, u.name, o.total_amount, o.o_status, o.payment_status, o.created_at FROM order_tbl o JOIN user_tbl u ON o.user_id=u.user_id ORDER BY o.created_at DESC LIMIT 5");

// Recent inquiries
$recent_inq = $conn->query("SELECT full_name, email, subject, message, created_at FROM inquiries_tbl ORDER BY created_at DESC LIMIT 5");

// Top products by review count
$top_products = $conn->query("
    SELECT p.title, c.c_name, sh.s_name as shape,
           COUNT(r.review_id) as review_cnt,
           ROUND(AVG(r.rating),1) as avg_rat,
           MIN(pv.price) as min_price, MAX(pv.price) as max_price,
           p.gender
    FROM product_tbl p
    JOIN category_tbl c ON p.category_id=c.category_id
    JOIN shape_tbl sh ON p.shape_id=sh.shape_id
    LEFT JOIN review_tbl r ON r.product_id=p.product_id
    LEFT JOIN product_variation_tbl pv ON pv.product_id=p.product_id AND pv.v_status='1'
    WHERE p.p_status='1'
    GROUP BY p.product_id
    ORDER BY review_cnt DESC, avg_rat DESC
    LIMIT 5
");

// Recent customers
$customers = $conn->query("SELECT name, email, phone, created_at FROM user_tbl WHERE u_status='1' ORDER BY created_at DESC LIMIT 5");

$total_colors = $conn->query("SELECT COUNT(*) as c FROM color_tbl")->fetch_assoc()['c'];
$total_shapes = $conn->query("SELECT COUNT(*) as c FROM shape_tbl")->fetch_assoc()['c'];
?>
<!DOCTYPE html>
<html lang="en" data-layout="">
<head>
    <meta charset="utf-8" />
    <title>Dashboard | Speczo Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Speczo Eyewear Admin Panel" name="description" />
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <script src="assets/js/config.js"></script>
    <link href="assets/css/vendor.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="wrapper">

    <?php include_once("sidebar.php"); ?>
    <?php include_once("header.php"); ?>

    <!-- Search Modal -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-transparent">
                <form>
                    <div class="card mb-1">
                        <div class="px-3 py-2 d-flex flex-row align-items-center" id="top-search">
                            <i class="ri-search-line fs-22"></i>
                            <input type="search" class="form-control border-0" placeholder="Search for actions, people,">
                            <button type="submit" class="btn p-0" data-bs-dismiss="modal" aria-label="Close">[esc]</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    <div class="page-content">
        <div class="page-container">

            <!-- ── ROW 1: 4 STAT CARDS ── -->
            <div class="row row-cols-xxl-4 row-cols-md-2 row-cols-1">

                <!-- Total Orders -->
                <div class="col">
                    <div class="card">
                        <div class="d-flex card-header justify-content-between align-items-center">
                            <div><h4 class="header-title">Total Orders</h4></div>
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle drop-arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-more-2-fill fs-18"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="orders.php" class="dropdown-item">View Orders</a>
                                    <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="d-flex align-items-end gap-2 justify-content-between">
                                <div>
                                    <?php if($os['Pending'] > 0): ?>
                                    <span class="badge bg-warning rounded-pill fs-13"><?= $os['Pending'] ?> Pending <i class="ti ti-clock"></i></span>
                                    <?php else: ?>
                                    <span class="badge bg-success rounded-pill fs-13">All Clear <i class="ti ti-check"></i></span>
                                    <?php endif; ?>
                                    <p class="text-muted mt-2 mb-0 fs-12">
                                        <i class="ti ti-circle-filled text-success fs-10"></i> <?= $os['Delivered'] ?> Delivered &nbsp;
                                        <i class="ti ti-circle-filled text-info fs-10"></i> <?= $os['Shipped'] ?> Shipped
                                    </p>
                                </div>
                                <div class="text-end">
                                    <h3 class="fw-semibold"><?= number_format($total_orders) ?></h3>
                                    <p class="text-muted mb-0">Total orders</p>
                                </div>
                            </div>
                            <div class="progress progress-soft progress-sm mt-3">
                                <?php $del_pct = $total_orders > 0 ? round(($os['Delivered']/$total_orders)*100) : 0; ?>
                                <div class="progress-bar bg-danger" role="progressbar" style="width:<?= $del_pct ?>%" aria-valuenow="<?= $del_pct ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->

                <!-- Total Revenue -->
                <div class="col">
                    <div class="card">
                        <div class="d-flex card-header justify-content-between align-items-center">
                            <div><h4 class="header-title">Total Revenue</h4></div>
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle drop-arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-more-2-fill fs-18"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="orders.php" class="dropdown-item">View Orders</a>
                                    <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="d-flex align-items-center gap-2 justify-content-between">
                                <div>
                                    <span class="badge bg-success rounded-pill fs-13">Live <i class="ti ti-trending-up"></i></span>
                                    <p class="text-muted mt-2 mb-0 fs-12">Avg ₹<?= number_format($price['av'] ?? 0, 0) ?>/product</p>
                                </div>
                                <div class="text-end">
                                    <h3 class="fw-semibold">₹<?= number_format($total_revenue, 0) ?></h3>
                                    <p class="text-muted mb-0">Total revenue</p>
                                </div>
                            </div>
                            <div class="progress progress-soft progress-sm mt-3">
                                <div class="progress-bar bg-success" role="progressbar" style="width:<?= min(100, $total_orders * 20) ?>%"></div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->

                <!-- Customers -->
                <div class="col">
                    <div class="card">
                        <div class="d-flex card-header justify-content-between align-items-center">
                            <div><h4 class="header-title">Customers</h4></div>
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle drop-arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-more-2-fill fs-18"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="users.php" class="dropdown-item">View All Users</a>
                                    <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="d-flex align-items-end gap-2 justify-content-between">
                                <div>
                                    <span class="badge bg-warning rounded-pill fs-13"><?= $total_inquiries ?> Inquiries</span>
                                    <p class="text-muted mt-2 mb-0 fs-12">
                                        <i class="ti ti-star text-warning"></i> <?= $total_reviews ?> Reviews
                                    </p>
                                </div>
                                <div class="text-end">
                                    <h3 class="fw-semibold"><?= number_format($total_users) ?></h3>
                                    <p class="text-muted mb-0">Active customers</p>
                                </div>
                            </div>
                            <div class="progress progress-soft progress-sm mt-3">
                                <div class="progress-bar bg-warning" role="progressbar" style="width:<?= min(100, $total_users * 10) ?>%"></div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->

                <!-- Customer Satisfaction -->
                <div class="col">
                    <div class="card">
                        <div class="d-flex card-header justify-content-between align-items-center">
                            <div><h4 class="header-title">Customer Satisfaction</h4></div>
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle drop-arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-more-2-fill fs-18"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="javascript:void(0);" class="dropdown-item">View Reviews</a>
                                    <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="d-flex align-items-center gap-2 justify-content-between">
                                <span class="badge bg-info rounded-pill fs-13"><?= $avg_rating ?>/5 ★ Avg</span>
                                <div class="text-end">
                                    <h3 class="fw-semibold"><?= $satisfaction ?>%</h3>
                                    <p class="text-muted mb-0">Based on <?= $total_reviews ?> reviews</p>
                                </div>
                            </div>
                            <div class="progress progress-soft progress-sm mt-3">
                                <div class="progress-bar bg-info" role="progressbar" style="width:<?= $satisfaction ?>%" aria-valuenow="<?= $satisfaction ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->

            </div><!-- end row -->

            <!-- ── ROW 2: 3 CHARTS ── -->
            <div class="row">

                <!-- Category Donut (replaces Orders Statistics) -->
                <div class="col-xxl-4 col-xl-6">
                    <div class="card">
                        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2 border-bottom border-dashed">
                            <h4 class="header-title">Products by Category</h4>
                            <a href="products.php" class="btn btn-sm btn-light">View All <i class="ri-arrow-right-line ms-1"></i></a>
                        </div>
                        <div class="card-body pt-2">
                            <div dir="ltr">
                                <div id="category-donut-chart" class="apex-charts" data-colors="#5b69bc,#ff8acc,#10c469,#35b8e0"></div>
                                <div class="row mt-3">
                                    <?php foreach($cat_labels as $i => $lbl): ?>
                                    <div class="col-6">
                                        <div class="d-flex justify-content-between align-items-center p-1">
                                            <span class="align-middle fw-semibold fs-13"><?= htmlspecialchars($lbl) ?></span>
                                            <span class="fw-semibold text-muted"><?= $cat_data[$i] ?></span>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->

                <!-- Frame Shape Bar (replaces Statistics) -->
                <div class="col-xxl-4 col-xl-6">
                    <div class="card">
                        <div class="d-flex card-header justify-content-between align-items-center border-bottom border-dashed">
                            <h4 class="header-title">Products by Frame Shape</h4>
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle drop-arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-more-2-fill fs-18"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="products.php" class="dropdown-item">View Products</a>
                                    <a href="javascript:void(0);" class="dropdown-item">Export</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0 pt-1">
                            <div dir="ltr" class="px-1">
                                <div id="shape-bar-chart" class="apex-charts" data-colors="#188ae2"></div>
                            </div>
                            <div class="border-top border-dashed mt-2">
                                <div class="row text-center align-items-center g-0">
                                    <div class="col-md-4 col-6">
                                        <p class="text-muted mt-3 mb-1">Shapes</p>
                                        <h4 class="mb-3"><span><?= $total_shapes ?></span></h4>
                                    </div>
                                    <div class="col-md-4 col-6 border-start border-end border-dashed">
                                        <p class="text-muted mt-3 mb-1">Colors</p>
                                        <h4 class="mb-3"><span><?= $total_colors ?></span></h4>
                                    </div>
                                    <div class="col-md-4 col">
                                        <p class="text-muted mt-3 mb-1">Products</p>
                                        <h4 class="mb-3"><span><?= $total_products ?></span></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->

                <!-- Monthly Inquiries + Gender split (replaces Total Revenue chart) -->
                <div class="col-xxl-4 col-xl-12">
                    <div class="card">
                        <div class="d-flex card-header justify-content-between align-items-center border-bottom border-dashed">
                            <h4 class="header-title">Inquiries Trend</h4>
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle drop-arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-more-2-fill fs-18"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="inquiries.php" class="dropdown-item">View Inquiries</a>
                                    <a href="javascript:void(0);" class="dropdown-item">Export</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0 pt-1">
                            <div dir="ltr" class="px-2">
                                <div id="inquiry-trend-chart" class="apex-charts" data-colors="#10c469,#35b8e0"></div>
                            </div>
                            <div class="border-top border-dashed mt-2">
                                <div class="row text-center align-items-center g-0">
                                    <?php foreach($gender_labels as $i => $gl): ?>
                                    <div class="col border-end border-dashed">
                                        <p class="text-muted mt-3 mb-1"><?= htmlspecialchars($gl) ?></p>
                                        <h4 class="mb-3"><?= $gender_data[$i] ?></h4>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->

            </div><!-- end row -->

            <!-- ── ROW 3: 5 MINI CATEGORY CARDS (replaces Team Members) ── -->
            <div class="row row-cols-xxl-5 row-cols-md-2 row-cols-1">

                <div class="col">
                    <div class="card">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="avatar-xl flex-shrink-0">
                                <span class="avatar-title bg-primary-subtle rounded-circle fs-24">
                                    <i class="ri-eyeglass-line text-primary"></i>
                                </span>
                            </div>
                            <div>
                                <h2 class="fw-bold mb-0"><?= $eyeglasses_cnt ?></h2>
                                <p class="text-muted mb-0">Eyeglasses</p>
                                <p class="m-0 fs-13 text-truncate">
                                    <?= round(($eyeglasses_cnt / max(1,$total_products))*100) ?>% of catalogue
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="avatar-xl flex-shrink-0">
                                <span class="avatar-title bg-danger-subtle rounded-circle fs-24">
                                    <i class="ri-sun-line text-danger"></i>
                                </span>
                            </div>
                            <div>
                                <h2 class="fw-bold mb-0"><?= $sunglasses_cnt ?></h2>
                                <p class="text-muted mb-0">Sunglasses</p>
                                <p class="m-0 fs-13 text-truncate">
                                    <?= round(($sunglasses_cnt / max(1,$total_products))*100) ?>% of catalogue
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="avatar-xl flex-shrink-0">
                                <span class="avatar-title bg-info-subtle rounded-circle fs-24">
                                    <i class="ri-computer-line text-info"></i>
                                </span>
                            </div>
                            <div>
                                <h2 class="fw-bold mb-0"><?= $screen_cnt ?></h2>
                                <p class="text-muted mb-0">Screen Glasses</p>
                                <p class="m-0 fs-13 text-truncate">Zero Power</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="avatar-xl flex-shrink-0">
                                <span class="avatar-title bg-success-subtle rounded-circle fs-24">
                                    <i class="ri-stack-line text-success"></i>
                                </span>
                            </div>
                            <div>
                                <h2 class="fw-bold mb-0"><?= $clipon_cnt ?></h2>
                                <p class="text-muted mb-0">Clip-on</p>
                                <p class="m-0 fs-13 text-truncate">Attachable lenses</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="avatar-xl flex-shrink-0">
                                <span class="avatar-title bg-warning-subtle rounded-circle fs-24">
                                    <i class="ri-star-fill text-warning"></i>
                                </span>
                            </div>
                            <div>
                                <h2 class="fw-bold mb-0"><?= $avg_rating ?></h2>
                                <p class="text-muted mb-0">Avg Rating /5</p>
                                <p class="m-0 fs-13 text-truncate"><?= $total_reviews ?> total reviews</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- end row -->

            <!-- ── ROW 4: TWO TABLES ── -->
            <div class="row">

                <!-- Recent Orders (replaces Brands Listing) -->
                <div class="col-xxl-6">
                    <div class="card">
                        <div class="d-flex card-header justify-content-between align-items-center">
                            <h4 class="header-title">Recent Orders</h4>
                            <a href="orders.php" class="btn btn-sm btn-light">View All <i class="ti ti-arrow-right ms-1"></i></a>
                        </div>
                        <div class="card-body p-0">
                            <div class="bg-light bg-opacity-50 py-1 text-center">
                                <p class="m-0">
                                    <b><?= $os['Pending'] ?></b> Pending &nbsp;·&nbsp;
                                    <b><?= $os['Shipped'] ?></b> Shipped &nbsp;·&nbsp;
                                    <b><?= $os['Delivered'] ?></b> Delivered &nbsp;·&nbsp;
                                    <b><?= $os['Cancelled'] ?></b> Cancelled
                                </p>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-custom table-centered table-sm table-nowrap table-hover mb-0">
                                    <tbody>
                                        <?php if($total_orders == 0): ?>
                                        <tr><td class="text-center text-muted py-5">No orders yet</td></tr>
                                        <?php else: while($o = $recent_orders->fetch_assoc()): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-md flex-shrink-0 me-2">
                                                        <span class="avatar-title bg-primary-subtle rounded-circle fw-bold text-primary">
                                                            #<?= $o['order_id'] ?>
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <span class="text-muted fs-12"><?= date('d M Y', strtotime($o['created_at'])) ?></span><br/>
                                                        <h5 class="fs-14 mt-1"><?= htmlspecialchars($o['name']) ?></h5>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-muted fs-12">Amount</span>
                                                <h5 class="fs-14 mt-1 fw-normal">₹<?= number_format($o['total_amount'],0) ?></h5>
                                            </td>
                                            <td>
                                                <span class="text-muted fs-12">Status</span>
                                                <?php $oc=['Pending'=>'warning','Shipped'=>'info','Delivered'=>'success','Cancelled'=>'danger']; $cls=$oc[$o['o_status']]?? 'secondary'; ?>
                                                <h5 class="fs-14 mt-1 fw-normal">
                                                    <i class="ti ti-circle-filled fs-12 text-<?= $cls ?>"></i> <?= $o['o_status'] ?>
                                                </h5>
                                            </td>
                                            <td>
                                                <span class="text-muted fs-12">Payment</span>
                                                <?php $pc = $o['payment_status']=='Paid' ? 'success' : 'danger'; ?>
                                                <h5 class="fs-14 mt-1 fw-normal">
                                                    <i class="ti ti-circle-filled fs-12 text-<?= $pc ?>"></i> <?= $o['payment_status'] ?>
                                                </h5>
                                            </td>
                                        </tr>
                                        <?php endwhile; endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="align-items-center justify-content-between row text-center text-sm-start">
                                <div class="col-sm">
                                    <div class="text-muted">
                                        <span class="fw-semibold"><?= $total_orders ?></span> total orders &nbsp;|&nbsp;
                                        Revenue: <span class="fw-semibold">₹<?= number_format($total_revenue,0) ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-auto mt-3 mt-sm-0">
                                    <a href="orders.php" class="btn btn-sm btn-soft-primary">View All</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->

                <!-- Top Reviewed Products (replaces Top Selling Products) -->
                <div class="col-xxl-6">
                    <div class="card card-h-100">
                        <div class="card-header d-flex flex-wrap align-items-center gap-2 border-bottom border-dashed">
                            <h4 class="header-title me-auto">Top Reviewed Products</h4>
                            <a href="products.php" class="btn btn-sm btn-light">View All <i class="ti ti-arrow-right ms-1"></i></a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary">Export <i class="ti ti-file-export ms-1"></i></a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-custom align-middle table-nowrap table-hover mb-0">
                                    <tbody>
                                        <?php while($p = $top_products->fetch_assoc()):
                                            // pick an emoji icon based on category
                                            $icon = '👓';
                                            if(strpos($p['c_name'],'Sun')!==false) $icon = '🕶️';
                                            elseif(strpos($p['c_name'],'Screen')!==false) $icon = '💻';
                                            elseif(strpos($p['c_name'],'Clip')!==false) $icon = '🔗';
                                        ?>
                                        <tr>
                                            <td style="width:70px;">
                                                <div class="avatar-lg border rounded d-flex align-items-center justify-content-center fs-32">
                                                    <?= $icon ?>
                                                </div>
                                            </td>
                                            <td class="ps-0">
                                                <h5 class="fs-14 my-1"><?= htmlspecialchars(substr($p['title'],0,28)) ?><?= strlen($p['title'])>28?'...':'' ?></h5>
                                                <span class="text-muted fs-12"><?= htmlspecialchars($p['shape']) ?> · <?= $p['gender'] ?></span>
                                            </td>
                                            <td>
                                                <h5 class="fs-14 my-1">₹<?= number_format($p['min_price'],0) ?></h5>
                                                <span class="text-muted fs-12">to ₹<?= number_format($p['max_price'],0) ?></span>
                                            </td>
                                            <td>
                                                <h5 class="fs-14 my-1"><?= $p['review_cnt'] ?></h5>
                                                <span class="text-muted fs-12">Reviews</span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-end">
                                                    <?php
                                                    $rc = 'success';
                                                    if($p['avg_rat'] < 3) $rc = 'danger';
                                                    elseif($p['avg_rat'] < 4) $rc = 'warning';
                                                    ?>
                                                    <div class="me-2">
                                                        <h5 class="fs-14 my-1">
                                                            <span class="badge bg-<?= $rc ?>-subtle text-<?= $rc ?>"><?= $p['avg_rat'] ?? '—' ?> ★</span>
                                                        </h5>
                                                        <span class="text-muted fs-12"><?= htmlspecialchars($p['c_name']) ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="align-items-center justify-content-between row text-center text-sm-start">
                                <div class="col-sm">
                                    <div class="text-muted">
                                        <?= $total_products ?> active products &nbsp;|&nbsp; <?= $total_reviews ?> total reviews
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->

            </div><!-- end row -->

            <!-- ── ROW 5: CUSTOMERS + RECENT INQUIRIES ── -->
            <div class="row">

                <!-- Customers table -->
                <div class="col-xxl-6">
                    <div class="card">
                        <div class="d-flex card-header justify-content-between align-items-center">
                            <h4 class="header-title">Recent Customers</h4>
                            <a href="users.php" class="btn btn-sm btn-light">View All <i class="ti ti-arrow-right ms-1"></i></a>
                        </div>
                        <div class="card-body p-0">
                            <div class="bg-light bg-opacity-50 py-1 text-center">
                                <p class="m-0"><b><?= $total_users ?></b> active customers</p>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-custom table-centered table-sm table-nowrap table-hover mb-0">
                                    <tbody>
                                        <?php while($c = $customers->fetch_assoc()): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-md flex-shrink-0 me-2">
                                                        <span class="avatar-title bg-primary-subtle rounded-circle fw-bold text-primary fs-16">
                                                            <?= strtoupper(substr($c['name'],0,1)) ?>
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <span class="text-muted fs-12"><?= htmlspecialchars($c['email']) ?></span><br/>
                                                        <h5 class="fs-14 mt-1"><?= htmlspecialchars($c['name']) ?></h5>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-muted fs-12">Phone</span>
                                                <h5 class="fs-14 mt-1 fw-normal"><?= htmlspecialchars($c['phone']) ?></h5>
                                            </td>
                                            <td>
                                                <span class="text-muted fs-12">Joined</span>
                                                <h5 class="fs-14 mt-1 fw-normal"><?= date('d M Y', strtotime($c['created_at'])) ?></h5>
                                            </td>
                                            <td>
                                                <span class="text-muted fs-12">Status</span>
                                                <h5 class="fs-14 mt-1 fw-normal">
                                                    <i class="ti ti-circle-filled fs-12 text-success"></i> Active
                                                </h5>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="align-items-center justify-content-between row text-center text-sm-start">
                                <div class="col-sm">
                                    <div class="text-muted">
                                        Showing <span class="fw-semibold">5</span> of <span class="fw-semibold"><?= $total_users ?></span> Results
                                    </div>
                                </div>
                                <div class="col-sm-auto mt-3 mt-sm-0">
                                    <ul class="pagination pagination-boxed pagination-sm mb-0 justify-content-center">
                                        <li class="page-item disabled"><a href="#" class="page-link"><i class="ti ti-chevron-left"></i></a></li>
                                        <li class="page-item active"><a href="#" class="page-link">1</a></li>
                                        <li class="page-item"><a href="users.php" class="page-link"><i class="ti ti-chevron-right"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->

                <!-- Recent Inquiries -->
                <div class="col-xxl-6">
                    <div class="card card-h-100">
                        <div class="card-header d-flex flex-wrap align-items-center gap-2 border-bottom border-dashed">
                            <h4 class="header-title me-auto">Recent Inquiries</h4>
                            <a href="inquiries.php" class="btn btn-sm btn-light">View All <i class="ti ti-arrow-right ms-1"></i></a>
                            <a href="inquiries.php" class="btn btn-sm btn-primary">Manage <i class="ti ti-settings ms-1"></i></a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-custom align-middle table-nowrap table-hover mb-0">
                                    <tbody>
                                        <?php while($inq = $recent_inq->fetch_assoc()): ?>
                                        <tr>
                                            <td style="width:60px;">
                                                <div class="avatar-lg border rounded d-flex align-items-center justify-content-center fs-22 bg-soft-primary">
                                                    <span class="avatar-title bg-primary-subtle rounded fw-bold text-primary fs-16">
                                                        <?= strtoupper(substr($inq['full_name'],0,1)) ?>
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="ps-0">
                                                <h5 class="fs-14 my-1"><?= htmlspecialchars($inq['full_name']) ?></h5>
                                                <span class="text-muted fs-12"><?= htmlspecialchars($inq['email']) ?></span>
                                            </td>
                                            <td>
                                                <h5 class="fs-14 my-1"><?= htmlspecialchars(substr($inq['subject'],0,22)) ?>...</h5>
                                                <span class="text-muted fs-12"><?= htmlspecialchars(substr($inq['message'],0,30)) ?>...</span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-end">
                                                    <div class="me-2">
                                                        <h5 class="fs-14 my-1"><?= date('d M', strtotime($inq['created_at'])) ?></h5>
                                                        <span class="text-muted fs-12"><?= date('Y', strtotime($inq['created_at'])) ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="align-items-center justify-content-between row text-center text-sm-start">
                                <div class="col-sm">
                                    <div class="text-muted">
                                        Total <span class="fw-semibold"><?= $total_inquiries ?></span> inquiries received
                                    </div>
                                </div>
                                <div class="col-sm-auto mt-3 mt-sm-0">
                                    <ul class="pagination pagination-boxed pagination-sm mb-0 justify-content-center">
                                        <li class="page-item disabled"><a href="#" class="page-link"><i class="ti ti-chevron-left"></i></a></li>
                                        <li class="page-item active"><a href="#" class="page-link">1</a></li>
                                        <li class="page-item"><a href="inquiries.php" class="page-link"><i class="ti ti-chevron-right"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col -->

            </div><!-- end row -->

        </div><!-- page-container -->

        <?php include_once("footer.php"); ?>
    </div><!-- page-content -->

</div><!-- END wrapper -->

<!-- Theme Settings offcanvas (keep original) -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="theme-settings-offcanvas">
    <div class="d-flex align-items-center gap-2 px-3 py-3 offcanvas-header border-bottom border-dashed">
        <h5 class="flex-grow-1 fs-16 fw-bold mb-0">Theme Settings</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0 h-100" data-simplebar>
        <div class="p-3 border-bottom border-dashed">
            <h5 class="mb-3 fs-13 text-uppercase fw-bold">Color Scheme</h5>
            <div class="row">
                <div class="col-4">
                    <div class="form-check card-radio">
                        <input class="form-check-input" type="radio" name="data-bs-theme" id="layout-color-light" value="light">
                        <label class="form-check-label p-3 w-100 d-flex justify-content-center align-items-center" for="layout-color-light">
                            <iconify-icon icon="solar:sun-bold-duotone" class="fs-32 text-muted"></iconify-icon>
                        </label>
                    </div>
                    <h5 class="fs-14 text-center text-muted mt-2">Light</h5>
                </div>
                <div class="col-4">
                    <div class="form-check card-radio">
                        <input class="form-check-input" type="radio" name="data-bs-theme" id="layout-color-dark" value="dark">
                        <label class="form-check-label p-3 w-100 d-flex justify-content-center align-items-center" for="layout-color-dark">
                            <iconify-icon icon="solar:cloud-sun-2-bold-duotone" class="fs-32 text-muted"></iconify-icon>
                        </label>
                    </div>
                    <h5 class="fs-14 text-center text-muted mt-2">Dark</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex align-items-center gap-2 px-3 py-2 offcanvas-header border-top border-dashed">
        <button type="button" class="btn w-50 btn-soft-danger" id="reset-layout">Reset</button>
    </div>
</div>

<!-- Vendor js -->
<script src="assets/js/vendor.min.js"></script>
<script src="assets/js/app.js"></script>
<script src="assets/vendor/apexcharts/apexcharts.min.js"></script>

<script>
// ── PHP → JS data ────────────────────────────────────────────────
const catLabels   = <?= json_encode($cat_labels) ?>;
const catData     = <?= json_encode($cat_data) ?>;
const shapeLabels = <?= json_encode($shape_labels) ?>;
const shapeData   = <?= json_encode($shape_data) ?>;
const inqMonths   = <?= json_encode(count($inq_months) ? $inq_months : ['No data']) ?>;
const inqCounts   = <?= json_encode(count($inq_counts) ? $inq_counts : [0]) ?>;

// ── Detect dark/light theme from Adminto ────────────────────────
const isDark      = document.documentElement.getAttribute('data-bs-theme') === 'dark';
const textClr     = isDark ? '#aab8c5' : '#8c98a4';
const gridClr     = isDark ? 'rgba(255,255,255,0.07)' : 'rgba(0,0,0,0.06)';
const cardBg      = isDark ? '#30363d' : '#ffffff';

// Adminto palette colours
const palette = ['#5b69bc','#ff8acc','#10c469','#35b8e0','#ffc107','#fd7e14','#6f42c1','#20c997'];

// ── 1. Category Donut ────────────────────────────────────────────
new ApexCharts(document.getElementById('category-donut-chart'), {
    series: catData,
    chart:  { type:'donut', height:230 },
    labels: catLabels,
    colors: palette,
    legend: { position:'bottom', fontSize:'12px', labels:{ colors: textClr } },
    plotOptions: { pie: { donut:{ size:'62%', labels:{ show:true, total:{ show:true, label:'Products', color: textClr } } } } },
    dataLabels: { enabled:false },
    tooltip: { y:{ formatter: v => v + ' products' } }
}).render();

// ── 2. Frame Shape Bar ───────────────────────────────────────────
new ApexCharts(document.getElementById('shape-bar-chart'), {
    series: [{ name:'Products', data: shapeData }],
    chart:  { type:'bar', height:230, toolbar:{ show:false } },
    plotOptions: { bar:{ borderRadius:4, columnWidth:'52%', distributed:true } },
    dataLabels: { enabled:false },
    legend: { show:false },
    xaxis: {
        categories: shapeLabels,
        labels: { style:{ colors: textClr, fontSize:'11px' } },
        axisBorder:{ show:false }, axisTicks:{ show:false }
    },
    yaxis: { labels:{ style:{ colors: textClr }, formatter: v => Math.floor(v) } },
    grid:  { borderColor: gridClr, strokeDashArray:4, padding:{ left:0, right:0 } },
    colors: palette,
    tooltip: { y:{ formatter: v => v + ' products' } }
}).render();

// ── 3. Inquiry Trend Line ────────────────────────────────────────
new ApexCharts(document.getElementById('inquiry-trend-chart'), {
    series: [{ name:'Inquiries', data: inqCounts }],
    chart:  { type:'area', height:230, toolbar:{ show:false } },
    stroke: { curve:'smooth', width:2.5 },
    fill:   { type:'gradient', gradient:{ shadeIntensity:1, opacityFrom:0.35, opacityTo:0.04 } },
    markers:{ size:3 },
    xaxis: {
        categories: inqMonths,
        labels: { style:{ colors: textClr, fontSize:'11px' } },
        axisBorder:{ show:false }, axisTicks:{ show:false }
    },
    yaxis: { labels:{ style:{ colors: textClr }, formatter: v => Math.floor(v) } },
    grid:  { borderColor: gridClr, strokeDashArray:4 },
    colors: ['#10c469'],
    dataLabels: { enabled:false },
    tooltip: { x:{ show:true } }
}).render();
</script>

</body>
</html>