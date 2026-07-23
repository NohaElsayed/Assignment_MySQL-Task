<nav class="navbar navbar-expand-lg main-navbar">
    <div class="container">

        <!-- 1. Brand / Logo -->
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="https://cdn-icons-png.flaticon.com/512/3081/3081559.png"
                alt="شعار متجر تاجر"
                width="35"
                height="35"
                class="d-inline-block align-text-top me-2">

            <!-- Store Name  -->
            <span class="fw-bold">تاجر</span>
        </a>

        <!-- 2. Mobile Menu Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <i class="fas fa-bars text-white"></i>
        </button>
        <!-- 3. Collapsible Menu Content -->
        <div class="collapse navbar-collapse" id="mainNav">

            <!-- CENTER SIDE: Navigation Links -->
            <ul class="navbar-nav mx-auto align-items-lg-center">

                <!-- Home Item (Added) -->
                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        <i class="fas fa-home"></i> الرئيسية
                    </a>
                </li>

                <!-- Reports Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="fas fa-chart-pie"></i> التقارير
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="high_salary.php"><i class="fas fa-money-bill-wave"></i> مرتب > 20K</a></li>
                        <li><a class="dropdown-item" href="orders_per_customer.php"><i class="fas fa-shopping-cart"></i> طلبات العملاء</a></li>
                        <li><a class="dropdown-item" href="top_products.php"><i class="fas fa-star"></i> أفضل المنتجات</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="employees_manager.php"><i class="fas fa-sitemap"></i> هيكل الموظفين</a></li>
                        <li><a class="dropdown-item" href="richest_in_city.php"><i class="fas fa-crown"></i> أغنى 3 بالمدينة</a></li>
                    </ul>
                </li>

                <!-- Search Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="fas fa-search"></i> البحث
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="customer_by_id.php"><i class="fas fa-hashtag"></i> بحث بالـ ID</a></li>
                        <li><a class="dropdown-item" href="search_customer.php"><i class="fas fa-user"></i> بحث بالاسم</a></li>
                        <li><a class="dropdown-item" href="customers_by_city.php"><i class="fas fa-city"></i> حسب المدينة</a></li>
                        <li><a class="dropdown-item" href="products_by_quantity.php"><i class="fas fa-boxes"></i> حسب الكمية</a></li>
                        <li><a class="dropdown-item" href="product_details.php"><i class="fas fa-info-circle"></i> تفاصيل المنتج</a></li>
                    </ul>
                </li>
            </ul>

            <!-- RIGHT SIDE: Empty (Used to balance the center alignment) -->
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <!-- You can add right-side items here later if needed -->
            </ul>

        </div>

        <!-- LEFT SIDE: User Profile -->
        <ul class="navbar-nav me-auto align-items-lg-center">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown">
                    <div class="user-avatar">
                        <?= strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?>
                    </div>
                    <span class="ms-2 d-none d-lg-inline text-white small">
                        <?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="index.php"><i class="fas fa-home"></i> الرئيسية</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt"></i> تسجيل خروج</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>