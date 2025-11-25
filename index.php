<!DOCTYPE html>
<html lang="en" data-layout="">

    
<!-- Mirrored from coderthemes.com/adminto/layouts/ by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 07 Nov 2025 04:57:02 GMT -->
<head>
        <meta charset="utf-8" />
        <title>Dashboard | Adminto - Responsive Bootstrap 5 Admin Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- Theme Config Js -->
        <script src="assets/js/config.js"></script>

        <!-- Vendor css -->
        <link href="assets/css/vendor.min.css" rel="stylesheet" type="text/css" />

        <!-- App css -->
        <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

        <!-- Icons css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <!-- Begin page -->
        <div class="wrapper">

            <!-- Menu -->
            <!-- Sidenav Menu Start -->
          
            <?php  include_once("sidebar.php");?>

            <!-- Sidenav Menu End -->

            
            <!-- Topbar Start -->
          
            <?php include_once("header.php");?>
          
            <!-- Topbar End -->

            <!-- Search Modal -->
            <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content bg-transparent">
                        <form>
                            <div class="card mb-1">
                                <div class="px-3 py-2 d-flex flex-row align-items-center" id="top-search">
                                    <i class="ri-search-line fs-22"></i>
                                    <input type="search" class="form-control border-0" id="search-modal-input"
                                        placeholder="Search for actions, people,">
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

                    <div class="row row-cols-xxl-4 row-cols-md-2 row-cols-1">
                        <div class="col">
                            <div class="card">
                                <div class="d-flex card-header justify-content-between align-items-center">
                                    <div>
                                        <h4 class="header-title">Total Orders</h4>
                                    </div>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle drop-arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-2-fill fs-18"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body pt-0">
                                    <div class="d-flex align-items-end gap-2 justify-content-between">
                                        <div class="text-end flex-shrink-0">
                                            <div id="total-orders-chart" data-colors="#ff5b5b,#F6F7FB"></div>
                                        </div>
                                        <div class="text-end">
                                            <h3 class="fw-semibold">687.3k</h3>
                                            <p class="text-muted mb-0">Since last month</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->

                        <div class="col">
                            <div class="card">
                                <div class="d-flex card-header justify-content-between align-items-center">
                                    <div>
                                        <h4 class="header-title">Total Revenue</h4>
                                    </div>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle drop-arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-2-fill fs-18"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body pt-0">
                                    <div class="d-flex align-items-center gap-2 justify-content-between">
                                        <span class="badge bg-success rounded-pill fs-13">32% <i class="ti ti-trending-up"></i> </span>
                                        <div class="text-end">
                                            <h3 class="fw-semibold">$5.42M</h3>
                                            <p class="text-muted mb-0">Since last month</p>
                                        </div>
                                    </div>

                                    <div class="progress progress-soft progress-sm mt-3">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->

                        <div class="col">
                            <div class="card">
                                <div class="d-flex card-header justify-content-between align-items-center">
                                    <div>
                                        <h4 class="header-title">New Users</h4>
                                    </div>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle drop-arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-2-fill fs-18"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body pt-0">
                                    <div class="d-flex align-items-end gap-2 justify-content-between">
                                        <div class="text-end flex-shrink-0">
                                            <div id="new-users-chart" data-colors="#f9c851,#F6F7FB"></div>
                                        </div>
                                        <div class="text-end">
                                            <h3 class="fw-semibold">45.3k</h3>
                                            <p class="text-muted mb-0">Since last month</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->

                        <div class="col">
                            <div class="card">
                                <div class="d-flex card-header justify-content-between align-items-center">
                                    <div>
                                        <h4 class="header-title">Customer Satisfaction</h4>
                                    </div>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle drop-arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-2-fill fs-18"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body pt-0">
                                    <div class="d-flex align-items-center gap-2 justify-content-between">
                                        <span class="badge bg-info rounded-pill fs-13">5.7% <i class="ti ti-trending-down"></i> </span>
                                        <div class="text-end">
                                            <h3 class="fw-semibold">94.3%</h3>
                                            <p class="text-muted mb-0">Since last month</p>
                                        </div>
                                    </div>

                                    <div class="progress progress-soft progress-sm mt-3">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 94.3%" aria-valuenow="94.3" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->

                    </div><!-- end row -->

                    <div class="row">
                        <div class="col-xxl-4 col-xl-6">
                            <div class="card">
                                <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2 border-bottom border-dashed">
                                    <h4 class="header-title">Orders Statistics</h4>

                                    <div class="d-flex gap-2 justify-content-end text-end">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-light">Refresh <i class="ri-refresh-line ms-1"></i></a>
                                    </div>
                                </div>
                                <div class="card-body pt-2">
                                    <div dir="ltr">
                                        <div id="data-visits-chart" class="apex-charts" data-colors="#5b69bc,#ff8acc,#10c469,#35b8e0"></div>

                                        <div class="row mt-3">
                                            <div class="col">
                                                <div class="d-flex justify-content-between align-items-center p-1">
                                                    <div>
                                                        <i class="ri-circle-fill fs-12 align-middle me-1 text-primary"></i>
                                                        <span class="align-middle fw-semibold">Direct</span>
                                                    </div>
                                                    <span class="fw-semibold text-muted float-end"><i class="ri-arrow-down-s-fill text-danger"></i> 965</span>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center p-1">
                                                    <div>
                                                        <i class="ri-circle-fill fs-12 text-secondary align-middle me-1"></i>
                                                        <span class="align-middle fw-semibold">Social</span>
                                                    </div>
                                                    <span class="fw-semibold text-muted float-end"><i class="ri-arrow-up-s-fill text-success"></i> 75</span>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="d-flex justify-content-between align-items-center p-1">
                                                    <div>
                                                        <i class="ri-circle-fill fs-12 text-success align-middle me-1"></i>
                                                        <span class="align-middle fw-semibold"> Marketing</span>
                                                    </div>
                                                    <span class="fw-semibold text-muted float-end"><i class="ri-arrow-up-s-fill text-success"></i> 102</span>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center p-1">
                                                    <div>
                                                        <i class="ri-circle-fill fs-12 text-info align-middle me-1"></i>
                                                        <span class="align-middle fw-semibold">Affiliates</span>
                                                    </div>
                                                    <span class="fw-semibold text-muted float-end"><i class="ri-arrow-down-s-fill text-danger"></i> 96</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                        <div class="col-xxl-4 col-xl-6">
                            <div class="card">
                                <div class="d-flex card-header justify-content-between align-items-center border-bottom border-dashed">
                                    <h4 class="header-title">Statistics</h4>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle drop-arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-2-fill fs-18"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body p-0 pt-1">
                                    <div dir="ltr" class="px-1">
                                        <div id="statistics-chart" class="apex-charts" data-colors="#188ae2"></div>
                                    </div>

                                    <div class="border-top border-dashed mt-2">
                                        <div class="row text-center align-items-center g-0">
                                            <div class="col-md-4 col-6">
                                                <p class="text-muted mt-3 mb-1">Revenue</p>
                                                <h4 class="mb-3">
                                                    <span class="ri-arrow-left-down-box-line text-success me-1"></span>
                                                    <span>$29.5k</span>
                                                </h4>
                                            </div>
                                            <div class="col-md-4 col-6 border-start border-end border-dashed">
                                                <p class="text-muted mt-3 mb-1">Expenses</p>
                                                <h4 class="mb-3">
                                                    <span class="ri-arrow-left-up-box-line text-danger me-1"></span>
                                                    <span>$15.07k</span>
                                                </h4>
                                            </div>
                                            <div class="col-md-4 col">
                                                <p class="text-muted mt-3 mb-1">Revenue</p>
                                                <h4 class="mb-3">
                                                    <span class="ri-arrow-left-down-box-line text-success me-1"></span>
                                                    <span>$71.5k</span>
                                                </h4>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-xxl-4 col-xl-12">
                            <div class="card">
                                <div class="d-flex card-header justify-content-between align-items-center border-bottom border-dashed">
                                    <h4 class="header-title">Total Revenue</h4>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle drop-arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-2-fill fs-18"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body p-0 pt-1">
                                    <div dir="ltr" class="px-2">
                                        <div id="revenue-chart" class="apex-charts" data-colors="#10c469,#35b8e0"></div>
                                    </div>

                                    <div class="border-top border-dashed mt-2">
                                        <div class="row text-center align-items-center g-0">
                                            <div class="col-md-4 col-12">
                                                <p class="text-muted mb-0">Payments</p>
                                                <img src="assets/images/cards/american-express.svg" alt="user-card" height="36" />
                                                <img src="assets/images/cards/discover-card.svg" alt="user-card" height="36" />
                                                <img src="assets/images/cards/mastercard.svg" alt="user-card" height="36" />
                                            </div>
                                            <div class="col-md-4 col-6 border-start border-end border-dashed">
                                                <p class="text-muted mt-3 mb-1">Expenses</p>
                                                <h4 class="mb-3">
                                                    <span class="ri-arrow-left-up-box-line text-danger me-1"></span>
                                                    <span>$15.07k</span>
                                                </h4>
                                            </div>
                                            <div class="col-md-4 col">
                                                <p class="text-muted mt-3 mb-1">Revenue</p>
                                                <h4 class="mb-3">
                                                    <span class="ri-arrow-left-down-box-line text-success me-1"></span>
                                                    <span>$45.5k</span>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                    </div> <!-- end row-->

                    <div class="row row-cols-xxl-5 row-cols-md-2 row-cols-1">
                        <div class="col">
                            <div class="card">
                                <div class="card-body d-flex align-items-center gap-2">
                                    <img src="assets/images/users/avatar-7.jpg" alt="team-member-image" class="me-1 avatar-xl img-thumbnail rounded-circle">
                                    <div>
                                        <h5>John Smith</h5>
                                        <p class="text-muted">Project Manager</p>
                                        <p class="m-0 fs-14 text-truncate">80+ Feedbacks <a href="#!" class="link-reset fw-medium"><i class="ti ti-arrow-right"></i></a></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card">
                                <div class="card-body d-flex align-items-center gap-2">
                                    <img src="assets/images/users/avatar-4.jpg" alt="team-member-image" class="me-1 avatar-xl img-thumbnail rounded-circle">
                                    <div>
                                        <h5>Jane Doe</h5>
                                        <p class="text-muted">UI/UX Designer</p>
                                        <p class="m-0 fs-14 text-truncate">90+ Feedbacks <a href="#!" class="link-reset fw-medium"><i class="ti ti-arrow-right"></i></a></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card">
                                <div class="card-body d-flex align-items-center gap-2">
                                    <img src="assets/images/users/avatar-5.jpg" alt="team-member-image" class="me-1 avatar-xl img-thumbnail rounded-circle">
                                    <div>
                                        <h5>Emily Brown</h5>
                                        <p class="text-muted">Software Engineer</p>
                                        <p class="m-0 fs-14 text-truncate">100+ Feedbacks <a href="#!" class="link-reset fw-medium"><i class="ti ti-arrow-right"></i></a></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card">
                                <div class="card-body d-flex align-items-center gap-2">
                                    <img src="assets/images/users/avatar-6.jpg" alt="team-member-image" class="me-1 avatar-xl img-thumbnail rounded-circle">
                                    <div>
                                        <h5>Mark Wilson</h5>
                                        <p class="text-muted">Marketing Specialist</p>
                                        <p class="m-0 fs-14 text-truncate">70+ Feedbacks <a href="#!" class="link-reset fw-medium"><i class="ti ti-arrow-right"></i></a></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card">
                                <div class="card-body d-flex align-items-center gap-2">
                                    <img src="assets/images/users/avatar-3.jpg" alt="team-member-image" class="me-1 avatar-xl img-thumbnail rounded-circle">
                                    <div>
                                        <h5>Sara Johnson</h5>
                                        <p class="text-muted">Data Analyst</p>
                                        <p class="m-0 fs-14 text-truncate">50+ Feedbacks <a href="#!" class="link-reset fw-medium"><i class="ti ti-arrow-right"></i></a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row-->

                    <div class="row">
                        <div class="col-xxl-6">
                            <div class="card">
                                <div class="d-flex card-header justify-content-between align-items-center">
                                    <h4 class="header-title">Brands Listing</h4>
                                    <a href="javascript:void(0);" class="btn btn-sm btn-light">Add Brand <i class="ti ti-plus ms-1"></i></a>
                                </div>
                                <div class="card-body p-0">
                                    <div class="bg-light bg-opacity-50 py-1 text-center">
                                        <p class="m-0"><b>75</b> Active brands out of <span class="fw-medium">120</span></p>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-custom table-centered table-sm table-nowrap table-hover mb-0">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-md flex-shrink-0 me-2">
                                                                <span class="avatar-title bg-primary-subtle rounded-circle">
                                                                    <img src="assets/images/products/logo/logo-1.svg" alt="" height="22">
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <span class="text-muted fs-12">Electronics</span> <br />
                                                                <h5 class="fs-14 mt-1">TechNova - Germany</h5>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted fs-12">Established</span>
                                                        <h5 class="fs-14 mt-1 fw-normal">Since 2015</h5>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted fs-12">Stores</span> <br />
                                                        <h5 class="fs-14 mt-1 fw-normal">1,200</h5>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted fs-12">Products</span>
                                                        <h5 class="fs-14 mt-1 fw-normal">15,320</h5>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted fs-12">Status</span>
                                                        <h5 class="fs-14 mt-1 fw-normal"><i class="ti ti-circle-filled fs-12 text-success"></i> Active
                                                        </h5>
                                                    </td>
                                                    <td style="width: 30px;">
                                                        <div class="dropdown">
                                                            <a href="#" class="dropdown-toggle text-muted drop-arrow-none card-drop p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ti ti-dots-vertical"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a href="javascript:void(0);" class="dropdown-item">Refresh
                                                                    Report</a>
                                                                <a href="javascript:void(0);" class="dropdown-item">Export
                                                                    Report</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-md flex-shrink-0 me-2">
                                                                <span class="avatar-title bg-info-subtle rounded-circle">
                                                                    <img src="assets/images/products/logo/logo-2.svg" alt="" height="22">
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <span class="text-muted fs-12">Home Decor</span> <br />
                                                                <h5 class="fs-14 mt-1">DecoLux - France</h5>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted fs-12">Established</span>
                                                        <h5 class="fs-14 mt-1 fw-normal">Since 2000</h5>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted fs-12">Stores</span> <br />
                                                        <h5 class="fs-14 mt-1 fw-normal">450</h5>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted fs-12">Products</span>
                                                        <h5 class="fs-14 mt-1 fw-normal">6,800</h5>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted fs-12">Status</span>
                                                        <h5 class="fs-14 mt-1 fw-normal"><i class="ti ti-circle-filled fs-12 text-warning"></i> Pending
                                                        </h5>
                                                    </td>
                                                    <td style="width: 30px;">
                                                        <div class="dropdown">
                                                            <a href="#" class="dropdown-toggle text-muted drop-arrow-none card-drop p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ti ti-dots-vertical"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a href="javascript:void(0);" class="dropdown-item">Refresh
                                                                    Report</a>
                                                                <a href="javascript:void(0);" class="dropdown-item">Export
                                                                    Report</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-md flex-shrink-0 me-2">
                                                                <span class="avatar-title bg-primary-subtle rounded-circle">
                                                                    <img src="assets/images/products/logo/logo-3.svg" alt="" height="22">
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <span class="text-muted fs-12">Technology</span> <br />
                                                                <h5 class="fs-14 mt-1">InnovTech - Japan</h5>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted fs-12">Established</span>
                                                        <h5 class="fs-14 mt-1 fw-normal">Since 2012</h5>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted fs-12">Stores</span> <br />
                                                        <h5 class="fs-14 mt-1 fw-normal">850</h5>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted fs-12">Products</span>
                                                        <h5 class="fs-14 mt-1 fw-normal">12,500</h5>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted fs-12">Status</span>
                                                        <h5 class="fs-14 mt-1 fw-normal"><i class="ti ti-circle-filled fs-12 text-success"></i> Active
                                                        </h5>
                                                    </td>
                                                    <td style="width: 30px;">
                                                        <div class="dropdown">
                                                            <a href="#" class="dropdown-toggle text-muted drop-arrow-none card-drop p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ti ti-dots-vertical"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a href="javascript:void(0);" class="dropdown-item">Refresh
                                                                    Report</a>
                                                                <a href="javascript:void(0);" class="dropdown-item">Export
                                                                    Report</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-md flex-shrink-0 me-2">
                                                                <span class="avatar-title bg-secondary-subtle rounded-circle">
                                                                    <img src="assets/images/products/logo/logo-4.svg" alt="" height="22">
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <span class="text-muted fs-12">Health</span> <br />
                                                                <h5 class="fs-14 mt-1">WellCare - UK</h5>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted fs-12">Established</span>
                                                        <h5 class="fs-14 mt-1 fw-normal">Since 2008</h5>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted fs-12">Stores</span> <br />
                                                        <h5 class="fs-14 mt-1 fw-normal">300</h5>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted fs-12">Products</span>
                                                        <h5 class="fs-14 mt-1 fw-normal">4,200</h5>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted fs-12">Status</span>
                                                        <h5 class="fs-14 mt-1 fw-normal"><i class="ti ti-circle-filled fs-12 text-success"></i> Active
                                                        </h5>
                                                    </td>
                                                    <td style="width: 30px;">
                                                        <div class="dropdown">
                                                            <a href="#" class="dropdown-toggle text-muted drop-arrow-none card-drop p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ti ti-dots-vertical"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a href="javascript:void(0);" class="dropdown-item">Refresh
                                                                    Report</a>
                                                                <a href="javascript:void(0);" class="dropdown-item">Export
                                                                    Report</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-md flex-shrink-0 me-2">
                                                                <span class="avatar-title bg-danger-subtle rounded-circle">
                                                                    <img src="assets/images/products/logo/logo-5.svg" alt="" height="22">
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <span class="text-muted fs-12">Automotive</span> <br />
                                                                <h5 class="fs-14 mt-1">AutoDrive - USA</h5>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted fs-12">Established</span>
                                                        <h5 class="fs-14 mt-1 fw-normal">Since 1999</h5>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted fs-12">Stores</span> <br />
                                                        <h5 class="fs-14 mt-1 fw-normal">600</h5>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted fs-12">Products</span>
                                                        <h5 class="fs-14 mt-1 fw-normal">8,900</h5>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted fs-12">Status</span>
                                                        <h5 class="fs-14 mt-1 fw-normal"><i class="ti ti-circle-filled fs-12 text-danger"></i> Inactive
                                                        </h5>
                                                    </td>
                                                    <td style="width: 30px;">
                                                        <div class="dropdown">
                                                            <a href="#" class="dropdown-toggle text-muted drop-arrow-none card-drop p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ti ti-dots-vertical"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a href="javascript:void(0);" class="dropdown-item">Refresh
                                                                    Report</a>
                                                                <a href="javascript:void(0);" class="dropdown-item">Export
                                                                    Report</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Additional rows with new data -->
                                            </tbody>
                                        </table>
                                    </div> <!-- end table-responsive-->
                                </div> <!-- end card-body-->

                                <div class="card-footer">
                                    <div class="align-items-center justify-content-between row text-center text-sm-start">
                                        <div class="col-sm">
                                            <div class="text-muted">
                                                Showing <span class="fw-semibold">5</span> of <span class="fw-semibold">20</span> Results
                                            </div>
                                        </div>
                                        <div class="col-sm-auto mt-3 mt-sm-0">
                                            <ul class="pagination pagination-boxed pagination-sm mb-0 justify-content-center">
                                                <li class="page-item disabled">
                                                    <a href="#" class="page-link"><i class="ti ti-chevron-left"></i></a>
                                                </li>
                                                <li class="page-item active">
                                                    <a href="#" class="page-link">1</a>
                                                </li>
                                                <li class="page-item">
                                                    <a href="#" class="page-link">2</a>
                                                </li>
                                                <li class="page-item">
                                                    <a href="#" class="page-link">3</a>
                                                </li>
                                                <li class="page-item">
                                                    <a href="#" class="page-link"><i class="ti ti-chevron-right"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div> <!-- -->
                                </div>

                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-xxl-6">
                            <div class="card card-h-100">
                                <div class="card-header d-flex flex-wrap align-items-center gap-2 border-bottom border-dashed">
                                    <h4 class="header-title me-auto">Top Selling Products</h4>

                                    <div class="d-flex gap-2 justify-content-end text-end">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-light">Import <i class="ti ti-download ms-1"></i></a>
                                        <a href="javascript:void(0);" class="btn btn-sm btn-primary">Export <i class="ti ti-file-export ms-1"></i></a>
                                    </div>
                                </div>

                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-custom align-middle table-nowrap table-hover mb-0">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 85px;">
                                                        <div class="avatar-lg border rounded">
                                                            <img src="assets/images/products/p-1.png" alt="Product-10" class="img-fluid rounded-2">
                                                        </div>
                                                    </td>
                                                    <td class="ps-0">
                                                        <h5 class="fs-14 my-1"><a href="#!" class="link-reset">Modern Desk
                                                                Lamp</a></h5>
                                                        <span class="text-muted fs-12">15 April 2024</span>
                                                    </td>
                                                    <td>
                                                        <h5 class="fs-14 my-1">$45.99</h5>
                                                        <span class="text-muted fs-12">Price</span>
                                                    </td>
                                                    <td>
                                                        <h5 class="fs-14 my-1">120</h5>
                                                        <span class="text-muted fs-12">Quantity</span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center justify-content-end">
                                                            <div class="me-2">
                                                                <h5 class="fs-14 my-1">$5,518.80</h5>
                                                                <span class="text-muted fs-12">Amount</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 85px;">
                                                        <div class="avatar-lg border rounded">
                                                            <img src="assets/images/products/p-2.png" alt="Product-11" class="img-fluid rounded-2">
                                                        </div>
                                                    </td>
                                                    <td class="ps-0">
                                                        <h5 class="fs-14 my-1"><a href="#!" class="link-reset">Vintage
                                                                Wooden Chair</a></h5>
                                                        <span class="text-muted fs-12">10 April 2024</span>
                                                    </td>
                                                    <td>
                                                        <h5 class="fs-14 my-1">$99.00</h5>
                                                        <span class="text-muted fs-12">Price</span>
                                                    </td>
                                                    <td>
                                                        <h5 class="fs-14 my-1">80</h5>
                                                        <span class="text-muted fs-12">Quantity</span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center justify-content-end">
                                                            <div class="me-2">
                                                                <h5 class="fs-14 my-1">$7,920.00</h5>
                                                                <span class="text-muted fs-12">Amount</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 85px;">
                                                        <div class="avatar-lg border rounded">
                                                            <img src="assets/images/products/p-3.png" alt="Product-12" class="img-fluid rounded-2">
                                                        </div>
                                                    </td>
                                                    <td class="ps-0">
                                                        <h5 class="fs-14 my-1"><a href="#!" class="link-reset">Wireless
                                                                Keyboard</a></h5>
                                                        <span class="text-muted fs-12">05 April 2024</span>
                                                    </td>
                                                    <td>
                                                        <h5 class="fs-14 my-1">$29.99</h5>
                                                        <span class="text-muted fs-12">Price</span>
                                                    </td>
                                                    <td>
                                                        <h5 class="fs-14 my-1">150</h5>
                                                        <span class="text-muted fs-12">Quantity</span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center justify-content-end">
                                                            <div class="me-2">
                                                                <h5 class="fs-14 my-1">$4,498.50</h5>
                                                                <span class="text-muted fs-12">Amount</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 85px;">
                                                        <div class="avatar-lg border rounded">
                                                            <img src="assets/images/products/p-4.png" alt="Product-13" class="img-fluid rounded-2">
                                                        </div>
                                                    </td>
                                                    <td class="ps-0">
                                                        <h5 class="fs-14 my-1"><a href="#!" class="link-reset">Bluetooth
                                                                Speaker</a></h5>
                                                        <span class="text-muted fs-12">02 April 2024</span>
                                                    </td>
                                                    <td>
                                                        <h5 class="fs-14 my-1">$65.00</h5>
                                                        <span class="text-muted fs-12">Price</span>
                                                    </td>
                                                    <td>
                                                        <h5 class="fs-14 my-1">90</h5>
                                                        <span class="text-muted fs-12">Quantity</span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center justify-content-end">
                                                            <div class="me-2">
                                                                <h5 class="fs-14 my-1">$5,850.00</h5>
                                                                <span class="text-muted fs-12">Amount</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 85px;">
                                                        <div class="avatar-lg border rounded">
                                                            <img src="assets/images/products/p-5.png" alt="Product-14" class="img-fluid rounded-2">
                                                        </div>
                                                    </td>
                                                    <td class="ps-0">
                                                        <h5 class="fs-14 my-1"><a href="#!" class="link-reset">Classic Table
                                                                Lamp</a></h5>
                                                        <span class="text-muted fs-12">29 March 2024</span>
                                                    </td>
                                                    <td>
                                                        <h5 class="fs-14 my-1">$42.50</h5>
                                                        <span class="text-muted fs-12">Price</span>
                                                    </td>
                                                    <td>
                                                        <h5 class="fs-14 my-1">110</h5>
                                                        <span class="text-muted fs-12">Quantity</span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center justify-content-end">
                                                            <div class="me-2">
                                                                <h5 class="fs-14 my-1">$4,675.00</h5>
                                                                <span class="text-muted fs-12">Amount</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>

                                        </table>
                                    </div> <!-- end table-responsive-->
                                </div> <!-- end card-body-->

                                <div class="card-footer">
                                    <div class="align-items-center justify-content-between row text-center text-sm-start">
                                        <div class="col-sm">
                                            <div class="text-muted">
                                                Showing <span class="fw-semibold">5</span> of <span class="fw-semibold">10</span> Results
                                            </div>
                                        </div>
                                        <div class="col-sm-auto mt-3 mt-sm-0">
                                            <ul class="pagination pagination-boxed pagination-sm mb-0 justify-content-center">
                                                <li class="page-item disabled">
                                                    <a href="#" class="page-link"><i class="ti ti-chevron-left"></i></a>
                                                </li>
                                                <li class="page-item active">
                                                    <a href="#" class="page-link">1</a>
                                                </li>
                                                <li class="page-item">
                                                    <a href="#" class="page-link">2</a>
                                                </li>
                                                <li class="page-item">
                                                    <a href="#" class="page-link"><i class="ti ti-chevron-right"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div> <!-- -->
                                </div>
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                    </div> <!-- end row-->

                </div> <!-- container -->

                <!-- Footer Start -->
                <?php include_once("footer.php");?>
                <!-- end Footer -->

            </div>
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->

        <!-- Theme Settings -->
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
                                <input class="form-check-input" type="radio" name="data-bs-theme" id="layout-color-light"
                                    value="light">
                                <label class="form-check-label p-3 w-100 d-flex justify-content-center align-items-center"
                                    for="layout-color-light">
                                    <iconify-icon icon="solar:sun-bold-duotone" class="fs-32 text-muted"></iconify-icon>
                                </label>
                            </div>
                            <h5 class="fs-14 text-center text-muted mt-2">Light</h5>
                        </div>

                        <div class="col-4">
                            <div class="form-check card-radio">
                                <input class="form-check-input" type="radio" name="data-bs-theme" id="layout-color-dark"
                                    value="dark">
                                <label class="form-check-label p-3 w-100 d-flex justify-content-center align-items-center"
                                    for="layout-color-dark">
                                    <iconify-icon icon="solar:cloud-sun-2-bold-duotone" class="fs-32 text-muted"></iconify-icon>
                                </label>
                            </div>
                            <h5 class="fs-14 text-center text-muted mt-2">Dark</h5>
                        </div>
                    </div>
                </div>

                <div class="p-3 border-bottom border-dashed sidebarMode">
                    <h5 class="mb-3 fs-13 text-uppercase fw-bold">Layout Mode</h5>

                    <div class="row">
                        <div class="col-4">
                            <div class="form-check card-radio">
                                <input class="form-check-input" type="radio" name="data-layout-mode" id="layout-mode-fluid"
                                    value="fluid">
                                <label class="form-check-label p-0 avatar-xl w-100" for="layout-mode-fluid">
                                    <div>
                                        <span class="d-flex h-100">
                                            <span class="flex-shrink-0">
                                                <span class="bg-light d-flex h-100 border-end flex-column p-1 px-2">
                                                    <span class="d-block p-1 bg-dark-subtle rounded mb-1"></span>
                                                    <span
                                                        class="d-block border border-3 border-secondary border-opacity-25 rounded w-100 mb-1"></span>
                                                    <span
                                                        class="d-block border border-3 border-secondary border-opacity-25 rounded w-100 mb-1"></span>
                                                    <span
                                                        class="d-block border border-3 border-secondary border-opacity-25 rounded w-100 mb-1"></span>
                                                    <span
                                                        class="d-block border border-3 border-secondary border-opacity-25 rounded w-100 mb-1"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column rounded-2">
                                                    <span class="bg-light d-block p-1"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </div>

                                    <div>
                                        <span class="d-flex h-100 flex-column">
                                            <span
                                                class="bg-light d-flex p-1 align-items-center border-bottom border-secondary border-opacity-25">
                                                <span class="d-block p-1 bg-dark-subtle rounded me-1"></span>
                                                <span
                                                    class="d-block border border-3 border-secondary border-opacity-25 rounded ms-auto"></span>
                                                <span
                                                    class="d-block border border-3 border-secondary border-opacity-25 rounded ms-1"></span>
                                                <span
                                                    class="d-block border border-3 border-secondary border-opacity-25 rounded ms-1"></span>
                                                <span
                                                    class="d-block border border-3 border-secondary border-opacity-25 rounded ms-1"></span>
                                            </span>
                                            <span class="bg-light d-block p-1"></span>
                                        </span>
                                    </div>
                                </label>
                            </div>
                            <h5 class="fs-14 text-center text-muted mt-2">Fluid</h5>
                        </div>

                        <div class="col-4">
                            <div class="form-check sidebar-setting card-radio">
                                <input class="form-check-input" type="radio" name="data-layout-mode" id="data-layout-detached"
                                    value="detached">
                                <label class="form-check-label p-0 avatar-xl w-100" for="data-layout-detached">
                                    <span class="d-flex h-100 flex-column">
                                        <span class="bg-light d-flex p-1 align-items-center border-bottom ">
                                            <span class="d-block p-1 bg-dark-subtle rounded me-1"></span>
                                            <span
                                                class="d-block border border-3 border-secondary border-opacity-25 rounded ms-auto"></span>
                                            <span
                                                class="d-block border border-3 border-secondary border-opacity-25 rounded ms-1"></span>
                                            <span
                                                class="d-block border border-3 border-secondary border-opacity-25 rounded ms-1"></span>
                                            <span
                                                class="d-block border border-3 border-secondary border-opacity-25 rounded ms-1"></span>
                                        </span>
                                        <span class="d-flex h-100 p-1 px-2">
                                            <span class="flex-shrink-0">
                                                <span class="bg-light d-flex h-100 flex-column p-1 px-2">
                                                    <span
                                                        class="d-block border border-3 border-secondary border-opacity-25 rounded w-100 mb-1"></span>
                                                    <span
                                                        class="d-block border border-3 border-secondary border-opacity-25 rounded w-100 mb-1"></span>
                                                    <span
                                                        class="d-block border border-3 border-secondary border-opacity-25 rounded w-100"></span>
                                                </span>
                                            </span>
                                        </span>
                                        <span class="bg-light d-block p-1 mt-auto px-2"></span>
                                    </span>

                                </label>
                            </div>
                            <h5 class="fs-14 text-center text-muted mt-2">Detached</h5>
                        </div>
                    </div>
                </div>

                <div class="p-3 border-bottom border-dashed">
                    <h5 class="mb-3 fs-16 fw-bold">Topbar Color</h5>

                    <div class="row">
                        <div class="col-3 darkMode">
                            <div class="form-check card-radio">
                                <input class="form-check-input" type="radio" name="data-topbar-color" id="topbar-color-light"
                                    value="light">
                                <label class="form-check-label p-0 avatar-lg w-100 bg-light" for="topbar-color-light">
                                    <span class="d-flex align-items-center justify-content-center h-100">
                                        <span class="p-2 d-inline-flex shadow rounded-circle bg-white"></span>
                                    </span>
                                </label>
                            </div>
                            <h5 class="fs-14 text-center text-muted mt-2">Light</h5>
                        </div>

                        <div class="col-3">
                            <div class="form-check card-radio">
                                <input class="form-check-input" type="radio" name="data-topbar-color" id="topbar-color-dark"
                                    value="dark">
                                <label class="form-check-label p-0 avatar-lg w-100 bg-light" for="topbar-color-dark">
                                    <span class="d-flex align-items-center justify-content-center h-100">
                                        <span class="p-2 d-inline-flex shadow rounded-circle"
                                            style="background-color: #000000;"></span>
                                    </span>
                                </label>
                            </div>
                            <h5 class="fs-14 text-center text-muted mt-2">Dark</h5>
                        </div>

                        <div class="col-3">
                            <div class="form-check card-radio">
                                <input class="form-check-input" type="radio" name="data-topbar-color" id="topbar-color-brand"
                                    value="brand">
                                <label class="form-check-label p-0 avatar-lg w-100 bg-light" for="topbar-color-brand">
                                    <span class="d-flex align-items-center justify-content-center h-100">
                                        <span class="p-2 d-inline-flex shadow rounded-circle bg-primary"></span>
                                    </span>
                                </label>
                            </div>
                            <h5 class="fs-14 text-center text-muted mt-2">Brand</h5>
                        </div>
                    </div>
                </div>

                <div class="p-3 border-bottom border-dashed">
                    <h5 class="mb-3 fs-16 fw-bold">Menu Color</h5>

                    <div class="row">
                        <div class="col-3">
                            <div class="form-check sidebar-setting card-radio">
                                <input class="form-check-input" type="radio" name="data-menu-color" id="sidenav-color-light"
                                    value="light">
                                <label class="form-check-label p-0 avatar-lg w-100 bg-light" for="sidenav-color-light">
                                    <span class="d-flex align-items-center justify-content-center h-100">
                                        <span class="p-2 d-inline-flex shadow rounded-circle bg-white"></span>
                                    </span>
                                </label>
                            </div>
                            <h5 class="fs-14 text-center text-muted mt-2">Light</h5>
                        </div>

                        <div class="col-3">
                            <div class="form-check sidebar-setting card-radio">
                                <input class="form-check-input" type="radio" name="data-menu-color" id="sidenav-color-dark"
                                    value="dark">
                                <label class="form-check-label p-0 avatar-lg w-100 bg-light" for="sidenav-color-dark">
                                    <span class="d-flex align-items-center justify-content-center h-100">
                                        <span class="p-2 d-inline-flex shadow rounded-circle"
                                            style="background-color: #000000;"></span>
                                    </span>
                                </label>
                            </div>
                            <h5 class="fs-14 text-center text-muted mt-2">Dark</h5>
                        </div>
                        <div class="col-3">
                            <div class="form-check sidebar-setting card-radio">
                                <input class="form-check-input" type="radio" name="data-menu-color" id="sidenav-color-brand"
                                    value="brand">
                                <label class="form-check-label p-0 avatar-lg w-100 bg-light" for="sidenav-color-brand">
                                    <span class="d-flex align-items-center justify-content-center h-100">
                                        <span class="p-2 d-inline-flex shadow rounded-circle bg-primary"></span>
                                    </span>
                                </label>
                            </div>
                            <h5 class="fs-14 text-center text-muted mt-2">Brand</h5>
                        </div>
                    </div>
                </div>

                <div class="p-3 .border-bottom .border-dashed sidebarMode">
                    <h5 class="mb-3 fs-13 text-uppercase fw-bold">Sidebar Size</h5>

                    <div class="row">
                        <div class="col-4">
                            <div class="form-check sidebar-setting card-radio">
                                <input class="form-check-input" type="radio" name="data-sidenav-size" id="sidenav-size-default"
                                    value="default">
                                <label class="form-check-label p-0 avatar-xl w-100" for="sidenav-size-default">
                                    <span class="d-flex h-100">
                                        <span class="flex-shrink-0">
                                            <span class="bg-light d-flex h-100 border-end  flex-column p-1 px-2">
                                                <span class="d-block p-1 bg-dark-subtle rounded mb-1"></span>
                                                <span
                                                    class="d-block border border-3 border-secondary border-opacity-25 rounded w-100 mb-1"></span>
                                                <span
                                                    class="d-block border border-3 border-secondary border-opacity-25 rounded w-100 mb-1"></span>
                                                <span
                                                    class="d-block border border-3 border-secondary border-opacity-25 rounded w-100 mb-1"></span>
                                                <span
                                                    class="d-block border border-3 border-secondary border-opacity-25 rounded w-100 mb-1"></span>
                                            </span>
                                        </span>
                                        <span class="flex-grow-1">
                                            <span class="d-flex h-100 flex-column">
                                                <span class="bg-light d-block p-1"></span>
                                            </span>
                                        </span>
                                    </span>
                                </label>
                            </div>
                            <h5 class="fs-14 text-center text-muted mt-2">Default</h5>
                        </div>

                        <div class="col-4">
                            <div class="form-check sidebar-setting card-radio">
                                <input class="form-check-input" type="radio" name="data-sidenav-size" id="sidenav-size-compact"
                                    value="compact">
                                <label class="form-check-label p-0 avatar-xl w-100" for="sidenav-size-compact">
                                    <span class="d-flex h-100">
                                        <span class="flex-shrink-0">
                                            <span class="bg-light d-flex h-100 border-end  flex-column p-1">
                                                <span class="d-block p-1 bg-dark-subtle rounded mb-1"></span>
                                                <span
                                                    class="d-block border border-3 border-secondary border-opacity-25 rounded w-100 mb-1"></span>
                                                <span
                                                    class="d-block border border-3 border-secondary border-opacity-25 rounded w-100 mb-1"></span>
                                                <span
                                                    class="d-block border border-3 border-secondary border-opacity-25 rounded w-100 mb-1"></span>
                                                <span
                                                    class="d-block border border-3 border-secondary border-opacity-25 rounded w-100 mb-1"></span>
                                            </span>
                                        </span>
                                        <span class="flex-grow-1">
                                            <span class="d-flex h-100 flex-column">
                                                <span class="bg-light d-block p-1"></span>
                                            </span>
                                        </span>
                                    </span>
                                </label>
                            </div>
                            <h5 class="fs-14 text-center text-muted mt-2">Compact</h5>
                        </div>

                        <div class="col-4">
                            <div class="form-check sidebar-setting card-radio">
                                <input class="form-check-input" type="radio" name="data-sidenav-size" id="sidenav-size-small"
                                    value="condensed">
                                <label class="form-check-label p-0 avatar-xl w-100" for="sidenav-size-small">
                                    <span class="d-flex h-100">
                                        <span class="flex-shrink-0">
                                            <span class="bg-light d-flex h-100 border-end flex-column" style="padding: 2px;">
                                                <span class="d-block p-1 bg-dark-subtle rounded mb-1"></span>
                                                <span
                                                    class="d-block border border-3 border-secondary border-opacity-25 rounded w-100 mb-1"></span>
                                                <span
                                                    class="d-block border border-3 border-secondary border-opacity-25 rounded w-100 mb-1"></span>
                                                <span
                                                    class="d-block border border-3 border-secondary border-opacity-25 rounded w-100 mb-1"></span>
                                                <span
                                                    class="d-block border border-3 border-secondary border-opacity-25 rounded w-100 mb-1"></span>
                                            </span>
                                        </span>
                                        <span class="flex-grow-1">
                                            <span class="d-flex h-100 flex-column">
                                                <span class="bg-light d-block p-1"></span>
                                            </span>
                                        </span>
                                    </span>
                                </label>
                            </div>
                            <h5 class="fs-14 text-center text-muted mt-2">Condensed</h5>
                        </div>

                        <div class="col-4">
                            <div class="form-check sidebar-setting card-radio">
                                <input class="form-check-input" type="radio" name="data-sidenav-size"
                                    id="sidenav-size-small-hover" value="sm-hover">
                                <label class="form-check-label p-0 avatar-xl w-100" for="sidenav-size-small-hover">
                                    <span class="d-flex h-100">
                                        <span class="flex-shrink-0">
                                            <span class="bg-light d-flex h-100 border-end flex-column" style="padding: 2px;">
                                                <span class="d-block p-1 bg-dark-subtle rounded mb-1"></span>
                                                <span
                                                    class="d-block border border-3 border-secondary border-opacity-25 rounded w-100 mb-1"></span>
                                                <span
                                                    class="d-block border border-3 border-secondary border-opacity-25 rounded w-100 mb-1"></span>
                                                <span
                                                    class="d-block border border-3 border-secondary border-opacity-25 rounded w-100 mb-1"></span>
                                                <span
                                                    class="d-block border border-3 border-secondary border-opacity-25 rounded w-100 mb-1"></span>
                                            </span>
                                        </span>
                                        <span class="flex-grow-1">
                                            <span class="d-flex h-100 flex-column">
                                                <span class="bg-light d-block p-1"></span>
                                            </span>
                                        </span>
                                    </span>
                                </label>
                            </div>
                            <h5 class="fs-14 text-center text-muted mt-2">Hover View</h5>
                        </div>

                        <div class="col-4">
                            <div class="form-check sidebar-setting card-radio">
                                <input class="form-check-input" type="radio" name="data-sidenav-size" id="sidenav-size-full"
                                    value="full">
                                <label class="form-check-label p-0 avatar-xl w-100" for="sidenav-size-full">
                                    <span class="d-flex h-100">
                                        <span class="flex-shrink-0">
                                            <span class="d-flex h-100 flex-column">
                                                <span class="d-block p-1 bg-dark-subtle mb-1"></span>
                                            </span>
                                        </span>
                                        <span class="flex-grow-1">
                                            <span class="d-flex h-100 flex-column">
                                                <span class="bg-light d-block p-1"></span>
                                            </span>
                                        </span>
                                    </span>
                                </label>
                            </div>
                            <h5 class="fs-14 text-center text-muted mt-2">Full Layout</h5>
                        </div>

                        <div class="col-4">
                            <div class="form-check sidebar-setting card-radio">
                                <input class="form-check-input" type="radio" name="data-sidenav-size"
                                    id="sidenav-size-fullscreen" value="fullscreen">
                                <label class="form-check-label p-0 avatar-xl w-100" for="sidenav-size-fullscreen">
                                    <span class="d-flex h-100">
                                        <span class="flex-grow-1">
                                            <span class="d-flex h-100 flex-column">
                                                <span class="bg-light d-block p-1"></span>
                                            </span>
                                        </span>
                                    </span>
                                </label>
                            </div>
                            <h5 class="fs-14 text-center text-muted mt-2">Hidden</h5>
                        </div>
                    </div>
                </div>

                <div class="p-3 border-bottom border-dashed d-none">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fs-16 mb-0">Container Width</h5>

                        <div class="btn-group radio" role="group">
                            <input type="radio" class="btn-check" name="data-container-position" id="container-width-fixed"
                                value="fixed">
                            <label class="btn btn-sm btn-soft-primary w-sm" for="container-width-fixed">Full</label>

                            <input type="radio" class="btn-check" name="data-container-position" id="container-width-scrollable"
                                value="scrollable">
                            <label class="btn btn-sm btn-soft-primary w-sm ms-0" for="container-width-scrollable">Boxed</label>
                        </div>
                    </div>
                </div>

                <div class="p-3 border-bottom border-dashed d-none">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fs-16 mb-0">Layout Position</h5>

                        <div class="btn-group radio" role="group">
                            <input type="radio" class="btn-check" name="data-layout-position" id="layout-position-fixed"
                                value="fixed">
                            <label class="btn btn-sm btn-soft-primary w-sm" for="layout-position-fixed">Fixed</label>

                            <input type="radio" class="btn-check" name="data-layout-position" id="layout-position-scrollable"
                                value="scrollable">
                            <label class="btn btn-sm btn-soft-primary w-sm ms-0"
                                for="layout-position-scrollable">Scrollable</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2 px-3 py-2 offcanvas-header border-top border-dashed">
                <button type="button" class="btn w-50 btn-soft-danger" id="reset-layout">Reset</button>
                <a href="https://1.envato.market/coderthemes" target="_blank" class="btn w-50 btn-soft-info">Buy Now</a>
            </div>

        </div>

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>

        <!-- Apex Chart js -->
        <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>

        <!-- Projects Analytics Dashboard App js -->
        <script src="assets/js/pages/dashboard.js"></script>

    </body>


<!-- Mirrored from coderthemes.com/adminto/layouts/ by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 07 Nov 2025 04:58:08 GMT -->
</html>