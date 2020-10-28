<header class="header header-transparent bg-header" id="header-main">
    <!-- Main navbar -->
    <nav class="navbar navbar navbar-main navbar-expand-lg navbar-transparent navbar-dark" id="navbar-main">
        <!-- Navbar collapse trigger -->
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" onclick="toggleSideBarFunction()" data-target="#navbar-main-collapse" aria-controls="navbar-main-collapse" aria-expanded="false" aria-label="Toggle navigation">
            <svg class="toggle-menu" fill="#fff" viewBox="0 0 80 80" width="40" height="40">
                <rect width="100" height="12" rx="8"></rect>
                <rect y="30" width="100" height="12" rx="8"></rect>
                <rect y="60" width="100" height="12" rx="8"></rect>
            </svg>
        </button>

        <div class="container  d-flex justify-content-between">
            <!-- Logo -->

            <a class="navbar-brand d-flex align-items-center" href="/">
                <img alt="Image placeholder" src="/assets/img/logo-large-beta.png" id="navbar-logo" >
            </a>


            <!-- Navbar nav -->
            <div class="navbar-collapse collapse justify-content-end" id="navbar-main-collapse">
                <div class="py-2 py-lg-0">
                    <ul class="navbar-nav">
                        <li class="nav-item px-3">
                            <a href="/demo" class="nav-link">Demo</a>
                        </li>
                        <li class="nav-item px-3">
                            <a href="/pricing" class="nav-link">Pricing</a>
                        </li>
                        <li class="nav-item px-3">
                            <a href="/faq" class="nav-link">FAQ</a>
                        </li>
                        <li class="nav-item px-3">
                            <a href="/docs" target="_blank" class="nav-link">Documentation</a>
                        </li>
                        <li class="nav-item px-3">
                            <a href="/contact" class="nav-link">Contact</a>
                        </li>
                        <li class="nav-item px-3">
                            <a href="/register" class="nav-link btn-signup bg-warning px-3">Sign up</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <a class="user-login" href="/login">
            <img class="user-login-icon" src="/assets/img/login.png">
        </a>
    </nav>
</header>

