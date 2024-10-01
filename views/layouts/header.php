<!-- Navbar -->
<nav class="navbar navbar-expand-lg border-bottom shadow-sm py-3">
    <div class="container fs-5">
        <!-- Logo and Brand -->
        <a class="navbar-brand text-teal d-flex align-items-center" href="/" style="font-size: 1.5rem;">
            <i class="fas fa-book-open text-teal me-2"></i>Storylog
        </a>

        <!-- Toggle Button for Mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">

                <!-- Primary Nav Items -->
                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/journals">My Journals</a>
                </li>

                <!-- Streak Display with Tooltip -->
                <li class="nav-item">
                    <div class="nav-link d-flex align-items-center" data-bs-toggle="tooltip"
                        data-bs-placement="bottom"
                        title="You've continued your journaling streak for 5 days! 
                                  Keep it going for more achievements.">
                        <i class="bi bi-fire fs-5 text-danger me-1"></i>
                        <span class="fw-bold">5</span>
                    </div>
                </li>

                <!-- User Dropdown for Account Related Actions -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://via.placeholder.com/40" alt="Profile" class="rounded-circle" style="width: 35px; height: 35px;">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="/profile">My Profile</a></li>
                        <li><a class="dropdown-item" href="/achievements">Achievements</a></li>
                        <li><a class="dropdown-item" href="/settings">Settings</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger" href="/logout">Log Out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>