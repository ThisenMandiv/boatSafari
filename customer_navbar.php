<nav class="navbar customer-navbar">
    <div class="navbar-container">
        <a href="/useracc/index.php" class="navbar-logo">Boat Safari</a>
        <ul style="overflow-x: auto; white-space: nowrap; display: flex; gap: 10px; max-width: 100vw;">
            <li><a href="/useracc/index.php" class="nav-link active">Home</a></li>
            <li><a href="/useracc/customer_book_safari.php" class="nav-link">Book Safari</a></li>
            <li><a href="/useracc/customer_bookings.php" class="nav-link">My Bookings</a></li>
            <li><a href="/useracc/about.php" class="nav-link">About</a></li>
            <li><a href="/useracc/contact.php" class="nav-link">Contact</a></li>
            <li><a href="/useracc/user_profile.php" class="nav-link">My Profile</a></li>
            <li><a href="/useracc/login.php" class="nav-link">Login</a></li>
            <li><a href="/useracc/registration.php" class="nav-link">Registration</a></li>
            <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin', 'superadmin'])): ?>
                <li><a href="/useracc/admin_dashboard.php" class="nav-link switch-btn">Switch to Admin</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
