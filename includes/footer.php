</main> <!-- End of main content area -->

<!-- 1. Main Footer Section -->
<footer class="main-footer">
    <div class="container">
        <div class="row g-4"> <!-- g-4 adds consistent spacing between grid columns -->
            
            <!-- Column 1: Brand & About -->
            <div class="col-lg-4 col-md-6">
                <h5><i class="fas fa-database me-2"></i>ShopDB</h5>
                <p class="text-muted small">مشروع تعليمي متكامل لتطبيق مهارات MySQL وPHP وBootstrap في بيئة واقعية.</p>
                <!-- Social Media Links -->
                <div class="social-icons mt-3">
                    <a href="#"><i class="fab fa-github"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                </div>
            </div>
            
            <!-- Column 2: Quick Navigation Links -->
            <div class="col-lg-2 col-md-3 col-6">
                <h6>روابط سريعة</h6>
                <ul class="footer-links">
                    <li><a href="index.php"><i class="fas fa-home me-2"></i>الرئيسية</a></li>
                    <li><a href="1_high_salary.php"><i class="fas fa-money-bill-wave me-2"></i>المرتبات</a></li>
                    <li><a href="4_top_products.php"><i class="fas fa-star me-2"></i>المنتجات</a></li>
                    <li><a href="6_search_customer.php"><i class="fas fa-search me-2"></i>البحث</a></li>
                </ul>
            </div>
            
            <!-- Column 3: Reports & Features Links -->
            <div class="col-lg-2 col-md-3 col-6">
                <h6>التقارير</h6>
                <ul class="footer-links">
                    <li><a href="3_orders_per_customer.php"><i class="fas fa-shopping-cart me-2"></i>الطلبات</a></li>
                    <li><a href="5_employees_manager.php"><i class="fas fa-users-cog me-2"></i>الموظفين</a></li>
                    <li><a href="9_richest_in_city.php"><i class="fas fa-crown me-2"></i>الأغنى</a></li>
                    <li><a href="10_product_details.php"><i class="fas fa-info-circle me-2"></i>التفاصيل</a></li>
                </ul>
            </div>
            
            <!-- Column 4: Contact Information -->
            <div class="col-lg-4 col-md-6">
                <h6>تواصل معنا</h6>
                <ul class="footer-links">
                    <li><i class="fas fa-envelope me-2 text-warning"></i> info@shopdb.com</li>
                    <li><i class="fas fa-phone me-2 text-warning"></i> +20 100 000 0000</li>
                    <li><i class="fas fa-map-marker-alt me-2 text-warning"></i> Cairo, Egypt</li>
                </ul>
            </div>
        </div>
        
        <!-- 2. Footer Bottom: Copyright & Tech Stack -->
        <div class="footer-bottom mt-4 pt-3 border-top">
            <small class="text-muted d-block text-center">
                <!-- Dynamically update the year using PHP so it never gets outdated -->
                © <?= date('Y') ?> Shop. جميع الحقوق محفوظة.
                
                <!-- Responsive line break for mobile devices -->
                <br class="d-md-none">
                
                صُنع بـ <i class="fas fa-heart text-danger"></i> باستخدام 
                <i class="fab fa-php text-warning"></i> PHP،
                <i class="fas fa-database text-info"></i> MySQL،
                <i class="fab fa-bootstrap text-primary"></i> Bootstrap
            </small>
        </div>
    </div>
</footer>

<!-- 3. External Scripts -->
<!-- Bootstrap 5 JS Bundle (includes Popper.js for dropdowns, tooltips, and modals) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>