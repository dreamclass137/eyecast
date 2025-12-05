<div class="sidenav-menu">
    <!-- Brand Logo -->
    <a href="index.php" class="logo">
        <span class="logo-light">
            <span class="logo-lg"><img src="assets/images/logo.png" alt="logo"></span>
            <span class="logo-sm"><img src="assets/images/logo-sm.png" alt="small logo"></span>
        </span>
        <span class="logo-dark">
            <span class="logo-lg"><img src="assets/images/logo-dark.png" alt="dark logo"></span>
            <span class="logo-sm"><img src="assets/images/logo-sm.png" alt="small logo"></span>
        </span>
    </a>

    <!-- Sidebar Buttons -->
    <button class="button-sm-hover"><i class="ri-circle-line align-middle"></i></button>
    <button class="sidenav-toggle-button"><i class="ri-menu-5-line fs-20"></i></button>
    <button class="button-close-fullsidebar"><i class="ti ti-x align-middle"></i></button>

    <div data-simplebar>

        <!-- User -->
        <div class="sidenav-user text-center">
            <div class="dropdown-center">
                <a class="topbar-link dropdown-toggle text-reset drop-arrow-none px-2" data-bs-toggle="dropdown">
                    <img src="assets/images/users/avatar-1.jpg" width="46" class="rounded-circle" alt="user-image">
                    <span class="d-flex justify-content-center gap-1 sidenav-user-name my-2">
                        <span>
							<span class="d-none d-xl-inline-block ms-1 fw-semibold">
								<div class="sidenav-user text-center">
									<span class="d-flex align-items-center gap-1 fw-semibold">
										<?= htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?>
									</span>
								</div>
							</span>
                        </span>
                        <i class="ri-arrow-down-s-line d-block sidenav-user-arrow align-middle"></i>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome!</h6>
                    </div>
                    <a href="javascript:void(0);" class="dropdown-item">
                        <i class="ri-account-circle-line me-1 fs-16 align-middle"></i>My Account
                    </a>
                    <a href="javascript:void(0);" class="dropdown-item">
                        <i class="ri-wallet-3-line me-1 fs-16 align-middle"></i>Wallet : <span class="fw-semibold">$89.25k</span>
                    </a>
                    <a href="javascript:void(0);" class="dropdown-item">
                        <i class="ri-settings-2-line me-1 fs-16 align-middle"></i>Settings
                    </a>
                    <a href="javascript:void(0);" class="dropdown-item">
                        <i class="ri-question-line me-1 fs-16 align-middle"></i>Support
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="javascript:void(0);" class="dropdown-item">
                        <i class="ri-lock-line me-1 fs-16 align-middle"></i>Lock Screen
                    </a>
                    <a href="logout.php" class="dropdown-item active fw-semibold text-danger">
						<i class="ri-logout-box-line me-1 fs-16 align-middle"></i>Sign Out
					</a>

                </div>
            </div>
        </div>

        <!-- Sidenav Menu -->
        <ul class="side-nav">
            <!-- Dashboard -->
            <li class="side-nav-item">
                <a href="index.php" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-dashboard"></i></span>
                    <span class="menu-text">Dashboard</span>
                    <span class="badge bg-danger rounded-pill">9+</span>
                </a>
            </li>
            <!-- Product -->
            <li class="side-nav-item">
                <a class="side-nav-link collapsed" data-bs-toggle="collapse" href="#sidebarProduct" aria-expanded="false">
                    <span class="menu-icon"><i class="ri-glasses-line"></i></span>
                    <span class="menu-text">Product</span>
                    <span class="menu-arrow"><i class="feather icon-feather-chevron-right"></i></span>
                </a>
                <div class="collapse" id="sidebarProduct">
                    <ul class="sub-menu">
					    <li><a href="viewproduct.php" class="side-nav-link sub-item">View Products</a></li>
                        <!--<li><a href="add-product.php" class="side-nav-link sub-item">Add Product</a></li>
						<li><a href="add-product-image.php" class="side-nav-link sub-item">Add Product Image</a></li>-->
                        <li><a href="manage-product.php" class="side-nav-link sub-item">Manage Product</a></li>
						<li><a href="manage-product-variation.php" class="side-nav-link sub-item">Manage Product Variation</a></li>
                        <li><a href="manage-product-image.php" class="side-nav-link sub-item">Manage Product Image</a></li>
                    </ul>
                </div>
            </li>

            <!-- Category -->
            <li class="side-nav-item">
                <a class="side-nav-link collapsed" data-bs-toggle="collapse" href="#sidebarCategory" aria-expanded="false">
                    <span class="menu-icon"><i class="ri-eye-line"></i></span>
                    <span class="menu-text">Category</span>
                    <span class="menu-arrow"><i class="feather icon-feather-chevron-right"></i></span>
                </a>
                <div class="collapse" id="sidebarCategory">
                    <ul class="sub-menu">
                        <li><a href="add-category.php" class="side-nav-link sub-item">Add Category</a></li>
                        <li><a href="manage-category.php" class="side-nav-link sub-item">Manage Category</a></li>
                    </ul>
                </div>
            </li>

            <!-- Shape -->
            <li class="side-nav-item">
                <a class="side-nav-link collapsed" data-bs-toggle="collapse" href="#sidebarShape" aria-expanded="false">
                    <span class="menu-icon"><i class="ti ti-tag"></i></span>
                    <span class="menu-text">Shape</span>
                    <span class="menu-arrow"><i class="feather icon-feather-chevron-right"></i></span>
                </a>
                <div class="collapse" id="sidebarShape">
                    <ul class="sub-menu">
                        <li><a href="add-shape.php" class="side-nav-link sub-item">Add Shape</a></li>
                        <li><a href="manage-shape.php" class="side-nav-link sub-item">Manage Shape</a></li>
                    </ul>
                </div>
            </li>

            <!-- Colour -->
            <li class="side-nav-item">
                <a class="side-nav-link collapsed" data-bs-toggle="collapse" href="#sidebarColour" aria-expanded="false">
                    <span class="menu-icon"><i class="ri-paint-line"></i></span>
                    <span class="menu-text">Color</span>
                    <span class="menu-arrow"><i class="feather icon-feather-chevron-right"></i></span>
                </a>
                <div class="collapse" id="sidebarColour">
                    <ul class="sub-menu">
                        <li><a href="add-color.php" class="side-nav-link sub-item">Add Color</a></li>
                        <li><a href="manage-color.php" class="side-nav-link sub-item">Manage Color</a></li>
                    </ul>
                </div>
            </li>
			
			<!-- Users -->
            <li class="side-nav-item">
                <a class="side-nav-link collapsed" data-bs-toggle="collapse" href="#sidebarUsers" aria-expanded="false">
                    <span class="menu-icon"><i class="ri-group-line"></i></span>
                    <span class="menu-text">Users</span>
                    <span class="menu-arrow"><i class="feather icon-feather-chevron-right"></i></span>
                </a>
                <div class="collapse" id="sidebarUsers">
                    <ul class="sub-menu">
                        <li><a href="manage-users.php" class="side-nav-link sub-item">Manage Users</a></li>
						<li><a href="manage-addresses.php" class="side-nav-link sub-item">Manage Addresses</a></li>
                    </ul>
                </div>
            </li>
			
			<!-- Orders -->
            <li class="side-nav-item">
                <a class="side-nav-link collapsed" data-bs-toggle="collapse" href="#sidebarOrder" aria-expanded="false">
                    <span class="menu-icon"><i class="ri-shopping-bag-line"></i></span>
                    <span class="menu-text">Orders</span>
                    <span class="menu-arrow"><i class="feather icon-feather-chevron-right"></i></span>
                </a>
                <div class="collapse" id="sidebarOrder">
                    <ul class="sub-menu">
                        <li><a href="manage-orders.php" class="side-nav-link sub-item">Manage Orders</a></li>
                    </ul>
                </div>
            </li>
	
			<!-- Payments -->
            <li class="side-nav-item">
                <a class="side-nav-link collapsed" data-bs-toggle="collapse" href="#sidebarPayment" aria-expanded="false">
                    <span class="menu-icon"><i class="ri-money-dollar-box-line"></i></span>
                    <span class="menu-text">Payments</span>
                    <span class="menu-arrow"><i class="feather icon-feather-chevron-right"></i></span>
                </a>
                <div class="collapse" id="sidebarPayment">
                    <ul class="sub-menu">
                        <li><a href="manage-payments.php" class="side-nav-link sub-item">Manage Payments</a></li>
                    </ul>
                </div>
            </li>
			
			<!-- Reviews -->
            <li class="side-nav-item">
                <a class="side-nav-link collapsed" data-bs-toggle="collapse" href="#sidebarReview" aria-expanded="false">
                    <span class="menu-icon"><i class="ri-star-line"></i></span>
                    <span class="menu-text">Reviews</span>
                    <span class="menu-arrow"><i class="feather icon-feather-chevron-right"></i></span>
                </a>
                <div class="collapse" id="sidebarReview">
                    <ul class="sub-menu">
                        <li><a href="manage-reviews.php" class="side-nav-link sub-item">Manage Reviews</a></li>
                    </ul>
                </div>
            </li>
			
			<!-- Wishlist -->
            <li class="side-nav-item">
                <a class="side-nav-link collapsed" data-bs-toggle="collapse" href="#sidebarWishlist" aria-expanded="false">
                    <span class="menu-icon"><i class="ri-heart-line"></i></span>
                    <span class="menu-text">Wishlist</span>
                    <span class="menu-arrow"><i class="feather icon-feather-chevron-right"></i></span>
                </a>
                <div class="collapse" id="sidebarWishlist">
                    <ul class="sub-menu">
                        <li><a href="manage-wishlist.php" class="side-nav-link sub-item">Manage Wishlist</a></li>
                    </ul>
                </div>
            </li>
        </ul>

        <div class="clearfix"></div>
    </div>
</div>

<style>
.side-nav-link .menu-arrow {
    transition: transform 0.3s;
}
.side-nav-link.collapsed .menu-arrow i {
    transform: rotate(0deg);
}
.side-nav-link:not(.collapsed) .menu-arrow i {
    transform: rotate(90deg);
}
</style>

<script>
function initSidebar() {
    const collapseLinks = document.querySelectorAll('.side-nav-link[data-bs-toggle="collapse"]');

    collapseLinks.forEach(link => {
        const target = document.querySelector(link.getAttribute('href'));
        const arrow = link.querySelector('.menu-arrow');

        if (target && arrow) {
            // Ensure all dropdowns are closed initially
            target.classList.remove('show');
            link.classList.add('collapsed');
            arrow.style.transform = 'rotate(0deg)'; // arrow points right

            // Arrow rotation on open/close
            target.addEventListener('shown.bs.collapse', () => {
                link.classList.remove('collapsed');
                arrow.style.transform = 'rotate(90deg)'; // arrow down
            });
            target.addEventListener('hidden.bs.collapse', () => {
                link.classList.add('collapsed');
                arrow.style.transform = 'rotate(0deg)'; // arrow right
            });
        }
    });
}

// Call immediately so every page gets it
initSidebar();
</script>

