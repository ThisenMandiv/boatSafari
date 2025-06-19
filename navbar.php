<?php
// Navigation bar for the site
?>
<nav class="navbar">
    <div class="navbar-container">
        <a href="/useracc/Display.php" class="navbar-logo">Boat Safari</a>
        <ul style="overflow-x: auto; white-space: nowrap; display: flex; gap: 10px; max-width: 100vw;">
            <li><a href="/useracc/Display.php" class="nav-link active">User</a></li>
            <li><a href="/useracc/boats/boats_list.php" class="nav-link">Boats</a></li>
            <li><a href="/useracc/safaris/safaris_list.php" class="nav-link">Safaris</a></li>
            <li><a href="/useracc/bookings/bookings_list.php" class="nav-link">Bookings</a></li>
            <li><a href="/useracc/schedules/schedules_list.php" class="nav-link">Schedules</a></li>
            <li><a href="/useracc/login.php" class="nav-link">Login</a></li>
            <li><a href="/useracc/registration.php" class="nav-link">Registration</a></li>
            <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin', 'superadmin'])): ?>
                <li><a href="/useracc/index.php" class="nav-link">Switch to Customer Side</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
<style>
.navbar ul::-webkit-scrollbar {
    height: 6px;
}
.navbar ul::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 3px;
}
</style> 