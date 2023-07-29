<nav class="navbar navbar-expand-md border-bottom px-1 py-0 fixed-top bg-body-tertiary mb-3 shadow" aria-label="header">
    <div class="container">
        <a class="navbar-brand link-body-emphasis" href="/">Storylog</a>
        <button class="navbar-toggler collapsed shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navBarHeader" aria-controls="navBarHeader" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon fs-6"></span>
        </button>

        <div class="navbar-collapse collapse" id="navBarHeader">
            <form class="text-body position-relative ms-auto my-2" role="search">
                <i class="bi bi-search small text-body border-0 ps-3 position-absolute top-50 start-0 translate-middle-y"></i>
                <input class="form-control form-control-sm shadow-none rounded-pill ps-5" type="search" placeholder="Search blogs..." aria-label="Search" aria-describedby="search-blogs">
            </form>
            <div class="d-flex ms-auto my-2">
                <ul class="nav flex-nowrap align-items-center list-unstyled">
                    <li class="nav-item">
                        <a href="/blog/create" class="btn btn-sm border border-secondary rounded-pill"><i class="bi bi-pencil-square me-1"></i>Create</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="btn btn-sm border border-secondary rounded-circle position-relative" role="button">
                            <i class="bi bi-moon-stars"></i>
                        </a>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="btn btn-sm border border-secondary rounded-circle position-relative" role="button">
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger px-1">
                                9+
                                <span class="visually-hidden">unread messages</span>
                            </span>
                            <i class="bi bi-bell"></i>
                        </a>
                    </li>
                    <li class="nav-item ms-2">
                        <div class="dropdown text-end">
                            <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="https://github.com/mdo.png" alt="mdo" width="31" height="31" class="border  border-secondary rounded-circle">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end mt-2 shadow">
                                <!-- <li>
                                    <a class="dropdown-item" href="#"><i class="bi bi-pencil-square me-2"></i>New blog</a>
                                </li> -->
                                <li>
                                    <a class="dropdown-item" href="/profile/henry"><i class="bi bi-person-circle me-2"></i>My Profile</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="/profile/edit"><i class="bi bi-pencil me-2"></i>Edit Profile</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="/settings"><i class="bi bi-gear me-2"></i>Settings</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="/logout"><i class="bi bi-box-arrow-left me-2"></i>Sign out</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>